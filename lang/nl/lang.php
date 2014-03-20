<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * 
 * @author Rene <wllywlnt@yahoo.com>
 */
$lang['menu']                  = 'Kwaliteitssamenvatting';
$lang['admin_headline']        = 'Kwaliteitssamenvatting';
$lang['admin_desc']            = 'Getoond worden de %d paginas met de meeste FIXMEs en laagste kwaliteit score. Klik op een titel van een cel om het te bestellen. De samenvatting wordt dagelijks bijgewerkt.';
$lang['admin_page']            = 'Pagina';
$lang['admin_quality']         = 'Kwaliteit';
$lang['admin_fixme']           = 'Fixme';
$lang['intro_h']               = 'Pagina analyse';
$lang['g_created']             = 'Vervaardigd:';
$lang['g_modified']            = 'Laatst gewijzigd:';
$lang['g_words']               = 'Woorden:';
$lang['g_chars']               = 'Karakters:';
$lang['g_changes']             = 'Aantal wijzigingen:';
$lang['g_authors']             = 'Top auteurs:';
$lang['anonymous']             = 'Anoniem';
$lang['i_qcscore']             = 'Kwaliteit:';
$lang['errorsfound_h']         = 'Geïdentificeerde kwaliteits problemen';
$lang['errorsfound']           = 'Na analyse van de pagina structuur zijn een aantal problemen omtrent leesbaarheid en bruikbaarheid van de pagina vastgesteld. Neem kennis van de onderstaand constateringen en probeer deze te herstellen. Het betreft een automatisch vervaardigde analyse - je moet zelf bepalen of deze correct is.';
$lang['fixme_h']               = '%d FIXME(s)';
$lang['fixme']                 = 'De pagina bevat markeringen over missende of foutieve inhoud. Je moet de FIXME markeringen vervangen met de correctie inhoud.';
$lang['noh1_h']                = 'Geen Bovenste Kopregel';
$lang['noh1']                  = 'Een pagina moet altijd beginnen met een niveau 1 kopregel. Deze kopregel moet het belangrijkste onderwerp van de pagina reflecteren.';
$lang['manyh1_h']              = '%d Bovenste Kopregels';
$lang['manyh1']                = 'De pagina bevat meerdere niveau 1 kopregels. Een pagina moet altijd slechts één niveau 1 kopregel bevatten en moet het belangrijkste onderwerp van de pagina reflecteren. Indien de pagina meerdere hoofdonderwerpen bevat, wordt het aanbevolen om de pagina over meerdere pagina\'s te verdelen.';
$lang['headernest_h']          = 'Foutief geneste secties';
$lang['headernest']            = 'De pagina bevat meerdere secties die sectie niveaus overslaan. Dit beperkt de leesbaarheid en de structuur. Een sectie mag slechts de daarop volgende subsecties bevatten. Overweeg om ontbrekende subsecties toe te voegen of pas bestaande subsecties aan naar het juiste niveau.  ';
$lang['manyhr_h']              = 'Veel horizontale strepen';
$lang['manyhr']                = 'De pagina bevat meerdere horizontale strepen (<code>----</code>).
Horizontale strepen dienen spaarzaam te worden gebruikt omdat zij de leesbaarheid en structuur van een document hinderen. Overweeg daarom secties en paragrafen te gebruiken.';
$lang['manybr_h']              = 'Veel geforceerd regelafbrekingen';
$lang['manybr']                = 'De pagina bevat meerdere regelafbrekingen (<code>\\</code>).
Regelafbrekingen dienen spaarzaam te worden gebruikt omdat zij de leesbaarheid en structuur van een document hinderen. Overweeg daarom paragrafen te gebruiken die de inhoud ondersteunen. Voeg een lege regel in om een paragraaf te vervaardigen.';
$lang['deepquote_h']           = 'Veelvuldig geneste aanhalingen';
$lang['deepquote']             = 'De pagina bevat diep geneste aanhalingen, dit impliceert een discussie achtige pagina. Discussies zijn moeilijk te volgen na verloop van tijd. Het wordt aan bevolen om deze om te vormen tot een correcte documentatie, die alle genoemde feiten uit de discussie bevat.';
$lang['singleauthor_h']        = 'Slechts een auteur';
$lang['singleauthor']          = 'De pagina werd bewerkt door een enkele auteur. Anderen zouden de pagina moeten controleren op juistheid en leesbaarheid.';
$lang['toosmall_h']            = 'Erg klein document';
$lang['toosmall']              = 'Deze pagina lijkt irrationeel smal en is waarschijnlijk een afsplitsing. Overweeg om het document uit te breiden, verwijder de gehele pagina.';
$lang['toolarge_h']            = 'Erg groot document';
$lang['toolarge']              = 'Deze pagina is erg lang. Lange pagina\'s zijn moeilijk te lezen op een beeldscherm. Overweeg om deze in meerdere pagina\'s te splitsen. ';
$lang['manyheaders_h']         = 'Veel kopregels';
$lang['manyheaders']           = 'In verhouding tot de totale lengte bevat deze pagina veel kopregels. Te veel structuur zonder inhoud kan de leesbaarheid en de bruikbaarheid van de pagina verminderen.';
$lang['fewheaders_h']          = 'Weinig kopregels';
$lang['fewheaders']            = 'In verhouding tot de totale lengte bevat deze pagina weinig kopregels. Breng tekst onder in subsecties waardoor het eenvoudiger wordt een overzicht over de inhoud te krijgen hetgeen lezers helpt om de tekst beter te begrijpen.';
$lang['nolink_h']              = 'Geen Wiki links';
$lang['nolink']                = 'Alle pagina\'s in een wiki moeten aan elkaar gelinkt zijn. Deze pagina bevat geen enkele link naar een andere wiki pagina. Misschien kan deze pagina aan andere gelinkt worden.';
$lang['brokenlink_h']          = 'Veel links naar niet bestaande pagina\'s';
$lang['brokenlink']            = 'Deze pagina bevat verschillend links naar niet bestaande pagina\'s. Dit is normaal voor nieuwe onderwerpen of bij het opbouwen van een nieuwe wiki. Controleer of deze pagina\'s worden gecreëerd. Controleer ook eventuele type fouten in de pagina link namen. ';
$lang['manyformat_h']          = 'Te veel opmaak';
$lang['manyformat']            = 'In verhouding tot de totale lengte bevat deze pagina veel opmaak (zoals vet, schuin, onderstreept). Deze formattering moet beperkt worden gebruikt of dit gaat ten koste van de leesbaarheid.';
$lang['longformat_h']          = 'Lang opgemaakte passages';
$lang['longformat']            = 'Deze pagina bevat enkele langere opgemaakte passages (zoals vet, schuin, onderstreept). Deze formattering moet beperkt worden gebruikt of dit gaat ten koste van de leesbaarheid.';
$lang['multiformat_h']         = 'Overdreven opgemaakte tekst';
$lang['multiformat']           = 'Deze pagina bevat tekst met meerdere opmaak formaten (zoals vet, schuin, onderstreept). Het combineren van opmaak wordt typografisch als een slechte stijl beschouwd en gaat ten koste van de leesbaarheid.';
$lang['nobacklink_h']          = 'Geen Backlinks';
$lang['nobacklink']            = 'Het lijkt dat er geen linken zijn naar deze pagina. Dit betekent dat deze niet kan worden gevonden anders dan door zoeken of de index. Dit is waarschijnlijk niet het geval als de pagina geautomatiseerde pagina lijst plugins bevat. Probeer ook elders linken naar deze pagina te maken.';
