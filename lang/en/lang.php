<?php

$lang['menu']           = 'Quality Summary';
$lang['admin_headline'] = 'Quality Summary';
$lang['admin_desc']     = 'Here are shown the %d pages with the most FIXMEs and worst quality scoring. Click on the title of a cell to order it. The summary is updated daily.';
$lang['admin_page']     = 'Page';
$lang['admin_quality']  = 'Quality';
$lang['admin_fixme']    = 'Fixme';

$lang['intro_h']       = 'Page Analysis';

$lang['g_created']     = 'Created:';
$lang['g_modified']    = 'Last Modified:';
$lang['g_words']       = 'Words:';
$lang['g_chars']       = 'Characters:';
$lang['g_changes']     = 'Number of Edits:';
$lang['g_authors']     = 'Top Authors:';

$lang['anonymous']     = 'Anonymous';

$lang['i_qcscore']     = 'Quality:';

$lang['errorsfound_h'] = 'Possible Quality Problems Identified';
$lang['errorsfound']   = 'After analyzing the page structure, a few possible problems about the readability and usability of the page were identified. Please have a look at the points below and see if you can correct them. Keep in mind that this was an automatic analysis - you need to judge yourself if it is correct.';

$lang['fixme_h']       = '%d FIXME(s)';
$lang['fixme']         = 'The page contains markers about missing or incorrect content. You should replace the FIXME markers with corrected content.';

$lang['noh1_h']        = 'No Main Headline';
$lang['noh1']          = 'A page should always start with a level 1 headline. This headline should reflect the main topic of the page.';

$lang['manyh1_h']      = '%d Main Headlines';
$lang['manyh1']        = 'The page contains multiple level 1 headlines. A page should always contain exactly one level 1 headline reflecting the main topic of the page. If your page contains multiple main topics, consider splitting the page into several pages.';

$lang['headernest_h']  = 'Incorrectly Nested Sections';
$lang['headernest']    = 'The page contains sections that skip section levels. This hinders readability and structure. A section should only directly contain the next subsection levels. Consider adding missing sub section headlines or move up your existing sub sections to the correct level.';

$lang['manyhr_h']      = 'Many Horizontal Rules';
$lang['manyhr']        = 'The page contains multiple horizontal rules (<code>----</code>). Horizontal rules should be used very rarely as they hinder readability and structure of a document. Consider restructuring the page using sections and paragraphs instead.';

$lang['manybr_h']      = 'Many Forced Line Breaks';
$lang['manybr']        = 'The page contains multiple forced line breaks (<code>\\\\ </code>). Line breaks should be avoided as much as possible because they hinder the flow and readability of the text. Instead the page should be formatted using paragraphs to support the content\'s message. To create a paragraph just insert an empty line into your text.';

$lang['deepquote_h']   = 'Deeply Nested Quotes';
$lang['deepquote']     = 'Your page contains deeply nested quotes, this might indicate a discussion style page. Discussions are hard to read after while. It is recommended to refactor them into proper documentation, incorpoorating all the facts that were mentioned in the discussion before.';

$lang['singleauthor_h'] = 'Single Author Only';
$lang['singleauthor'] = 'The page was only edited by a single author so far. Others should recheck the page for correctness and readability.';

$lang['toosmall_h'] = 'Very Small Document';
$lang['toosmall'] = 'This page seems to be irrationally small and is probably a stub. Consider extending the content, or maybe remove the page alltogether.';

$lang['toolarge_h'] = 'Very Large Document';
$lang['toolarge'] = 'This page is very large. Long pages are hard to read on a monitor. Consider splitting it into multiple pages instead.';

$lang['manyheaders_h'] = 'Many Headlines';
$lang['manyheaders'] = 'Compared to the overall length, this page has a lot of headlines. Too much structure without any real content might hinder readability and usefulness of the page.';

$lang['fewheaders_h'] = 'Few Headlines';
$lang['fewheaders'] = 'Compared to the overall length, this page doesn\'t have many headlines. Structuring texts with subsection makes it easier to overview the content and helps readers to better understand the text. ';

$lang['nolink_h'] = 'No Wiki Links';
$lang['nolink'] = 'All pages in a wiki should be linked with each other. This page seems not to contain a single link to another wiki page. Maybe you can link to some related pages?';

$lang['brokenlink_h'] = 'Many links to non-existing pages';
$lang['brokenlink'] = 'This page contains several links to pages that do not exist. This is normal for new topics or while creating a new wiki. You just should make sure these pages get created. Also check if you maybe mistyped the linked page names.';

$lang['manyformat_h'] = 'Too much Text Formatting';
$lang['manyformat'] = 'Compared to the overall length, this page contains a lot of text formatting (like bold, italics or underline). Such formatting should only be used very sparingly or the readability suffers.';

$lang['longformat_h'] = 'Long Formatted Passages';
$lang['longformat'] = 'This page contains some longer passages that are formatted (like bold, italics or underlined). Such formatting should only be used very sparingly or the readability suffers.';

$lang['multiformat_h'] = 'Overly Formatted Text';
$lang['multiformat'] = 'This page contains some text that is formatted with multiple different markups (like bold, italics or underlined). Combining formatting is considered typographically bad style and hinders the readability.';

$lang['nobacklink_h'] = 'No Backlinks';
$lang['nobacklink'] = 'It seems like no other page is linking to this page. This usually means it can\'t be found by other means than the search or the index. This might not be true, if you\'re using automatic page listing plugins. See if you can link to this page from somewhere else in the wiki.';

/*
$lang['_h'] = '';
$lang[''] = '';
*/

