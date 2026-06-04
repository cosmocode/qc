<?php

/**
 * @license    GPL 2 (https://www.gnu.org/licenses/gpl.html)
 *
 * @author Wizzard <wizzardsk@gmail.com>
 */
$lang['menu']                  = 'Súhrn kvality';
$lang['admin_headline']        = 'Súhrn kvality';
$lang['admin_desc']            = 'Tu sa zobrazuje %d stránok s najviac FIXME značkami a najhorším skóre kvality. Kliknutím na titulok bunky ich zoradíte. Súhrn sa aktualizuje denne.';
$lang['admin_page']            = 'Stránka';
$lang['admin_quality']         = 'Kvalita';
$lang['admin_fixme']           = 'Fixme';
$lang['intro_h']               = 'Analýza stránky';
$lang['g_created']             = 'Vytvorené:';
$lang['g_modified']            = 'Naposledy upravené:';
$lang['g_words']               = 'Slová:';
$lang['g_chars']               = 'Znaky:';
$lang['g_changes']             = 'Počet úprav:';
$lang['g_authors']             = 'Hlavní autori:';
$lang['anonymous']             = 'Anonym';
$lang['i_qcscore']             = 'Kvalita:';
$lang['errorsfound_h']         = 'Identifikované možné problémy kvality';
$lang['errorsfound']           = 'Po analýze štruktúry stránky bolo identifikovaných niekoľko možných problémov s čitateľnosťou a použiteľnosťou stránky. Pozrite si body nižšie a skúste ich opraviť. Majte na pamäti, že ide o automatickú analýzu – či je správna, musíte posúdiť sami.';
$lang['fixme_h']               = '%d FIXME značiek';
$lang['fixme']                 = 'Stránka obsahuje značky chýbajúceho alebo nesprávneho obsahu. FIXME značky by ste mali nahradiť opraveným obsahom.';
$lang['noh1_h']                = 'Chýba hlavný nadpis';
$lang['noh1']                  = 'Stránka by mala vždy začínať nadpisom 1. úrovne. Tento nadpis by mal vystihovať hlavnú tému stránky.';
$lang['manyh1_h']              = '%d hlavných nadpisov';
$lang['manyh1']                = 'Stránka obsahuje viacero nadpisov 1. úrovne. Stránka by mala vždy obsahovať presne jeden nadpis 1. úrovne vystihujúci hlavnú tému stránky. Ak stránka obsahuje viacero hlavných tém, zvážte jej rozdelenie na viacero stránok.';
$lang['headernest_h']          = 'Nesprávne vnorené sekcie';
$lang['headernest']            = 'Stránka obsahuje sekcie, ktoré preskakujú úrovne sekcií. To zhoršuje čitateľnosť a štruktúru. Sekcia by mala priamo obsahovať iba sekcie nasledujúcej úrovne. Zvážte doplnenie chýbajúcich nadpisov podsekcií alebo posunutie existujúcich podsekcií na správnu úroveň.';
$lang['manyhr_h']              = 'Veľa horizontálnych čiar';
$lang['manyhr']                = 'Stránka obsahuje viacero horizontálnych čiar (<code>----</code>). Horizontálne čiary by sa mali používať veľmi zriedkavo, pretože zhoršujú čitateľnosť a štruktúru dokumentu. Zvážte reštrukturalizáciu stránky pomocou sekcií a odsekov.';
$lang['manybr_h']              = 'Veľa vynútených zalomení riadkov';
$lang['manybr']                = 'Stránka obsahuje viacero vynútených zalomení riadkov (<code>\\ </code>). Zalomeniam riadkov sa treba čo najviac vyhýbať, pretože narúšajú tok a čitateľnosť textu. Stránka by mala byť namiesto toho formátovaná odsekmi. Odsek vytvoríte vložením prázdneho riadku do textu.';
$lang['deepquote_h']           = 'Hlboko vnorené citácie';
$lang['deepquote']             = 'Stránka obsahuje hlboko vnorené citácie, čo môže naznačovať diskusný štýl stránky. Diskusie sa po čase ťažko čítajú. Odporúča sa prepracovať ich na riadnu dokumentáciu so zahrnutím všetkých faktov spomenutých v diskusii.';
$lang['singleauthor_h']        = 'Iba jeden autor';
$lang['singleauthor']          = 'Stránku zatiaľ upravoval iba jeden autor. Ostatní by mali stránku skontrolovať z hľadiska správnosti a čitateľnosti.';
$lang['toosmall_h']            = 'Veľmi malý dokument';
$lang['toosmall']              = 'Táto stránka sa zdá byť neprimerane malá a pravdepodobne ide o pahýľ. Zvážte rozšírenie obsahu alebo úplné odstránenie stránky.';
$lang['toolarge_h']            = 'Veľmi veľký dokument';
$lang['toolarge']              = 'Táto stránka je veľmi veľká. Dlhé stránky sa na monitore ťažko čítajú. Zvážte jej rozdelenie na viacero stránok.';
$lang['manyheaders_h']         = 'Veľa nadpisov';
$lang['manyheaders']           = 'V pomere k celkovej dĺžke má táto stránka veľa nadpisov. Priveľa štruktúry bez skutočného obsahu môže zhoršovať čitateľnosť a užitočnosť stránky.';
$lang['fewheaders_h']          = 'Málo nadpisov';
$lang['fewheaders']            = 'V pomere k celkovej dĺžke nemá táto stránka veľa nadpisov. Štruktúrovanie textov podsekciami uľahčuje prehľad obsahu a pomáha čitateľom lepšie porozumieť textu. ';
$lang['nolink_h']              = 'Žiadne wiki odkazy';
$lang['nolink']                = 'Všetky stránky vo wiki by mali byť navzájom prepojené. Táto stránka zrejme neobsahuje ani jeden odkaz na inú wiki stránku. Možno by ste mohli odkázať na súvisiace stránky?';
$lang['brokenlink_h']          = 'Veľa odkazov na neexistujúce stránky';
$lang['brokenlink']            = 'Táto stránka obsahuje viacero odkazov na stránky, ktoré neexistujú. Pri nových témach alebo pri vytváraní novej wiki je to normálne. Mali by ste sa však uistiť, že tieto stránky budú vytvorené. Skontrolujte tiež, či ste sa nepomýlili v názvoch odkazovaných stránok.';
$lang['manyformat_h']          = 'Priveľa formátovania textu';
$lang['manyformat']            = 'V pomere k celkovej dĺžke obsahuje táto stránka veľa formátovania textu (tučné, kurzíva alebo podčiarknutie). Takéto formátovanie by sa malo používať veľmi striedmo, inak trpí čitateľnosť.';
$lang['longformat_h']          = 'Dlhé formátované pasáže';
$lang['longformat']            = 'Táto stránka obsahuje dlhšie formátované pasáže (tučné, kurzíva alebo podčiarknuté). Takéto formátovanie by sa malo používať veľmi striedmo, inak trpí čitateľnosť.';
$lang['multiformat_h']         = 'Nadmerne formátovaný text';
$lang['multiformat']           = 'Táto stránka obsahuje text formátovaný viacerými rôznymi značkami naraz (tučné, kurzíva alebo podčiarknuté). Kombinovanie formátovania sa považuje za typograficky zlý štýl a zhoršuje čitateľnosť.';
$lang['nobacklink_h']          = 'Žiadne spätné odkazy';
$lang['nobacklink']            = 'Zdá sa, že na túto stránku neodkazuje žiadna iná stránka. To zvyčajne znamená, že sa nedá nájsť inak než vyhľadávaním alebo cez index. Nemusí to platiť, ak používate pluginy na automatické zoznamy stránok. Skúste na túto stránku odkázať z iného miesta wiki.';
