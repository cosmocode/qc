<?php

$lang['intro_h']       = 'Seiten-Analyse';

$lang['g_created']     = 'Angelegt:';
$lang['g_modified']    = 'Zuletzt geändert:';
$lang['g_words']       = 'Wörter:';
$lang['g_chars']       = 'Zeichen:';
$lang['g_changes']     = 'Änderungen:';
$lang['g_authors']     = 'Top Autoren:';

$lang['anonymous']     = 'Anonym';

$lang['i_qcscore']     = 'Qualität:';

$lang['errorsfound_h'] = 'Mögliche Qualitätsprobleme identifiziert';
$lang['errorsfound']   = 'Beim Analysieren der Seitenstruktur wurden einige mögliche Probleme identifiziert, die die Les- und Nutzbarkeit der Seite behindern könnten. Bitte überprüfen Sie die untenstehenden Punkte. Bitte denken Sie daran, dass dies eine automatische Überrüfung ist - Sie müssen selbst entscheiden ob die Probleme tatsächlich korrigiert werden müssen.';

$lang['fixme_h']       = '%d FIXME(s)';
$lang['fixme']         = 'Die Seite enthält Markierungen die fehlende oder falsche Inhalte kennzeichnen. Sie sollten die FIXMEs durch korrigierte Inhalte ersetzen.';

$lang['noh1_h']        = 'Keine Hauptüberschrift';
$lang['noh1']          = 'Eine Seite sollte immer mit einer Ebene 1 Überschrift beginnen. Die Überschrift sollte den Inhalt der Seite sinnvoll beschreiben.';

$lang['manyh1_h']      = '%d Hauptüberschriften';
$lang['manyh1']        = 'Die Seite enthält mehrere Ebene 1 Überschriften. Eine Seite sollte exakt eine Hauptüberschrift enthalten die das Thema der Seite beschreibt. Wenn Ihre Seite mehrere Themen enthält, sollten Sie erwägen sie in mehrere Seiten aufzuteilen.';

$lang['headernest_h']  = 'Falsch verschachtelte Abschnitte';
$lang['headernest']    = 'Die Seite enhält Abschnitte die eine oder mehrere Ebenen überspringen. Das kann die Strukturierung und Lesbarkeit beeinträchtigen. Erwägen Sie das Hinzufügen der fehlenden Zwischenüberschriften oder verschieben Sie die entsprechenden Abschnitte, durch Anpassen der Überschriften, in die richtige Ebene.';

$lang['manyhr_h']      = 'Viele horizontale Linien';
$lang['manyhr']        = 'Die Seite enthält eine große Anzahl horizontaler Linien (<code>----</code>). Horizontale Linien sollten nur sehr sparsam eingesetzt werden da sie die Struktur und Lesbarkeit eines Dokuments beeinträchtigen. Restrukturieren Sie die Seite unter Verwendung von Abschnitten und Absätzen.';

$lang['manybr_h']      = 'Viele erzwungene Zeilenumbrüche';
$lang['manybr']        = 'Die Seite enthält eine große Zahl an erzwungenen Zeilenumbrüchen (<code>\\\\ </code>). Zeilenumbrüche stören den Lesefluss des Textes. Verwenden Sie stattdessen Absätze, um den Text anhand seines Inhaltes zu strukturieren. Um einen Absatz zu erzeugen fügen Sie eine leere Zeile in Ihren Text.';

$lang['deepquote_h']   = 'Stark verschachtelte Zitate';
$lang['deepquote']     = 'Die Seite enthält einige sehr verschachtelte Zitate (<code>&gt;</code>). Dies deutet auf eine Diskussion hin. Es ist empfehlenswert die Ergebnisse der Diskussion in den eigentlichen Text der seite einfließen zu lassen und die Diskussion zu entfernen.';

$lang['singleauthor_h'] = 'Nur ein Autor';
$lang['singleauthor'] = 'Die Seite wurde bisher nur von einem einzigen Nutzer bearbeitet. Andere Nutzer sollten die Seite auf Korrektheit und Lesbarkeit überprüfen.';

$lang['toosmall_h'] = 'Sehr kleines Dokument';
$lang['toosmall'] = 'Diese Seite scheint ungewöhlich klein zu sein und ist möglicherweise ein Platzhalter. Erwägen Sie die Seite zu ergänzen. Eventuell ist es auch sinnvoll die Seite ganz zu löschen.';

$lang['toolarge_h'] = 'Sehr großes Dokument';
$lang['toolarge'] = 'Diese Seite ist ungewöhnlich groß. Lange Seiten sind auf einem Monitor nur schwer zu lesen. Eventuell macht es Sinn die Seite in mehrere kleinere Artikel aufzuteilen.';

$lang['manyheaders_h'] = 'Viele Überschriften';
$lang['manyheaders'] = 'Im Vergleich zur Gesamtlänge, enthält diese Seite ungewöhnlich viele Zwischenüberschriften. Zuviel Strukturierung ohne wirklichen Inhalt schmälert die Les- und Nutzbarkeit der Seite';

$lang['fewheaders_h'] = 'Wenig Überschriften';
$lang['fewheaders'] = 'Im Vergleich zur Gesamtlänge, enthält diese Seite ungewöhnlich wenig Zwischenüberschriften. Die Strukturierung eines Textes durch Zwischenüberschriften macht es dem Leser einfacher den Text zu überfliegen.';

$lang['nolink_h'] = 'Keine Wiki Links';
$lang['nolink'] = 'Alle Seiten innerhalb eines Wikis sollten miteinander verlinkt sein. Diese Seite scheint keine Links zu einer anderen Seite des Wikis zu enthalten. Erwägen Sie das Verlinken verwandter Wikiseiten.';

$lang['brokenlink_h'] = 'Viele Links auf nicht-existierende Seiten';
$lang['brokenlink'] = 'Diese Seite enthälte mehrere Links auf Wikiseiten die (noch) nicht angelegt wurden. Das ist normal bei neuen Themen oder einem Wiki im Aufbau, Sie sollten jedoch sicherstellen, dass die entsprechenden Seiten irgendwann angelegt werden. Sie sollten die Links zudem auf Tippfehler prüfen.';

$lang['manyformat_h'] = 'Sehr viele Textformatierungen';
$lang['manyformat'] = 'Im Vergleich zur Gesamtlänge des Texts, enthält diese Seite sehr viele Textformatierungen (wie fett, kursiv oder unterstrichen). Solcherlei Formatierungen sollten nur sparsam eingesetzt werden, da sonst die Lesbarkeit des Textes leidet.';

$lang['longformat_h'] = 'Lange formatierte Passagen';
$lang['longformat'] = 'Diese Seite enthält einige sehr lange Passagen die formatiert wurden (wie fett, kursiv oder unterstrichen). Solcherlei Formatierungen sollten nur sparsam eingesetzt werden, da sonst die Lesbarkeit des Textes leidet.';

$lang['multiformat_h'] = 'Mehrfach formatierter Text';
$lang['multiformat'] = 'Diese Seite enthält Text der mit mehreren, unterschiedlichen Formatierungen (wie fett, kursiv oder unterstrichen) ausgezeichnet wurde. Das Kombinieren mehrerer Formatierungen ist typografisch schlechter Stil und behindert die Lesbarkeit.';

$lang['nobacklink_h'] = 'Keine Rückverweise';
$lang['nobacklink'] = 'Es scheint, dass keine andere Seite im Wiki zu dieser Seite verlinkt. Das heisst normalerweise, dass die Seite nur über die Suche und die Übersicht aufzufinden ist. Das mag nicht der Fall sein, wenn Sie Plugins verwenden die automatisch Seiten auflisten. Versuchen Sie diese Seite von einer anderen Seite aus sinnvoll zu verlinken.';


/*
$lang['_h'] = '';
$lang[''] = '';
*/

