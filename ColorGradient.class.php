<?php
/**
 * Calculate the colors for a gradient
 *
 * @author  Cd-MaN <x_at_y_or_z@yahoo.com>
 * @license CC-BY-SA
 * @link    http://hype-free.blogspot.com/2008/10/creating-gradients-in-php.html
 */
class ColorGradient {
    function rgb2yuv($r, $g, $b) {
        # adapted from: http://www.fourcc.org/fccyvrgb.php
        $y = 0.299 * $r + 0.587 * $g + 0.114 * $b;
        return array(
                $y,
                ($b - $y) * 0.565,
                ($r - $y) * 0.713
                );
    }

    function rgb2hsv($r, $g, $b) {
        # adapted from: http://mikeheuss.com/scripts/ColorToy/
        $min = min($r, $g, $b);
        $max = max($r, $g, $b);

        $v = $max/255;
        $delta = $max-$min;

        if ($max != 0)
            $s = $delta/$max;
        else
            return array(-1, 0, $v);

        if ($r == $max) $h = ($g-$b)/$delta;
        else if ($g == $max)  $h = 2+($b-$r)/ $delta;
        else $h = 4+($r-$g)/$delta;

        $h*=60;
        if ($h<0) $h+=360;

        return array($h, $s, $v);
    }

    function ColorGradient($colors, $minimum = 0.0, $maximum = 1.0, $colorspace = 'rgb', $use_cache = true) {
        $funcStr = '';
        $limits = array_keys($colors); sort($limits);
        $low_limit = array_shift($limits);

        $gap = $maximum - $minimum;
        $funcStr .= "\$value = \$value * 100 / $gap;\n";

        foreach ($colors as $limit => $color) {
            preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/iD', $color, $m);
            $colors[$limit] = array(hexdec($m[1]), hexdec($m[2]), hexdec($m[3]));
            $orig_colors[$limit] = $colors[$limit];
            if ('yuv' == $colorspace)
                $colors[$limit] = $this->rgb2yuv($colors[$limit][0], $colors[$limit][1], $colors[$limit][2]);
            else if ('hsv' == $colorspace)
                $colors[$limit] = $this->rgb2hsv($colors[$limit][0], $colors[$limit][1], $colors[$limit][2]);
        }

        foreach ($limits as $up_limit) {
            $m_start = $colors[$low_limit]; $m_end = $colors[$up_limit];

            $funcStr .= "if (\$value >= $low_limit && \$value <= $up_limit) {\n";
            $gap = ($m_end[0] - $m_start[0]) / 100;
            $funcStr .= "  \$a = {$m_start[0]} + ({$gap}) * \$value;\n";
            $gap = ($m_end[1] - $m_start[1]) / 100;
            $funcStr .= "  \$b = {$m_start[1]} + ({$gap}) * \$value;\n";
            $gap = ($m_end[2] - $m_start[2]) / 100;
            $funcStr .= "  \$c = {$m_start[2]} + ({$gap}) * \$value;\n";
            $funcStr .= "}\n";

            $low_limit = $up_limit;
        }

        $funcStr .= "if (\$value <= 0) return array({$orig_colors[0][0]}, {$orig_colors[0][1]}, {$orig_colors[0][2]});\n";
        $funcStr .= "if (\$value >= 100) return array({$orig_colors[100][0]}, {$orig_colors[100][1]}, {$orig_colors[100][2]});\n";

        $funcStr .= "\n";
        if ($use_cache) {
            $funcStr .= "\$c = \"\$a_\$b_\$c\";\n";
            $funcStr .= "if (array_key_exists(\$c, \$cache)) {\n";
            $funcStr .= "  \$a = \$cache[\$c][0]; \$b = \$cache[\$c][1]; \$c = \$cache[\$c][2];\n";
            $funcStr .= "} else {\n";
        }

        if ('yuv' == $colorspace) {
            $funcStr .= "\$y = \$a; \$u = \$b; \$v = \$c;\n";
            $funcStr .= "\$a = \$y + 1.403 * \$v;\n";
            $funcStr .= "\$b = \$y - 0.344 * \$u - 0.714 * \$v;\n";
            $funcStr .= "\$c = \$y + 1.770 * \$u;\n";
        }
        else if ('hsv' == $colorspace) {
            $funcStr .= "\$h = \$a; \$s = \$b; \$v = \$c;\n";
            $funcStr .= "\$a = \$b = \$c = 0;\n";
            $funcStr .= "if (0 == \$s) { \$a = \$b = \$c = \$v; }\n";
            $funcStr .= "else {\n";
            $funcStr .= "  \$h /= 60; \$i = floor(\$h); \$f = \$h-\$i; \$p=255*\$v*(1-\$s);\n";
            $funcStr .= "  \$q=255*\$v*(1-(\$s*\$f)); \$t=255*\$v*(1-\$s*(1-\$f)); \$v*=255;\n";
            $funcStr .= "  switch(\$i) {\n";
            $funcStr .= "    case 0: \$a = \$v; \$b = \$t; \$c = \$p; break;\n";
            $funcStr .= "    case 1: \$a = \$q; \$b = \$v; \$c = \$p; break;\n";
            $funcStr .= "    case 2: \$a = \$p; \$b = \$v; \$c = \$t; break;\n";
            $funcStr .= "    case 3: \$a = \$p; \$b = \$q; \$c = \$v; break;\n";
            $funcStr .= "    case 4: \$a = \$t; \$b = \$p; \$c = \$v; break;\n";
            $funcStr .= "    default: \$a = \$v; \$b = \$p; \$c = \$q; break;\n";
            $funcStr .= "  }\n";
            $funcStr .= "}\n";
        }

        if ($use_cache) {
            $funcStr .= "  \$cache[\$c] = array(\$a, \$b, \$c);\n";
            $funcStr .= "}\n";
        }

        $funcStr .= "\n";
        $funcStr .= "return array(intval(\$a), intval(\$b), intval(\$c));\n";

        $this->cache = array();
        $this->gradientFunc = create_function('$value,$cache', $funcStr);
    }

    function getColorArray($value) {
        return call_user_func($this->gradientFunc, $value, $this->cache);
    }

    function getColorWeb($value) {
        $r = $this->getColorArray($value);
        return sprintf('#%02X%02X%02X', $r[0], $r[1], $r[2]);
    }

    function getColorGD($value, $image) {
        $r = $this->getColorArray($value);
        return imagecolorallocate($image, $r[0], $r[1], $r[2]);
    }
}
