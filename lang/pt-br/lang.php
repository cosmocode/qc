<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author Alexandre Belchior <alexbelchior@gmail.com>
 */
$lang['menu']                  = 'Resumo de qualidade';
$lang['admin_headline']        = 'Resumo de qualidade';
$lang['admin_desc']            = 'Aqui são mostradas as % d páginas com o maior número de FIXMEs e a pior pontuação de qualidade. Clique no título de uma célula para encomendá-lo. O resumo é atualizado diariamente.';
$lang['admin_page']            = 'Página';
$lang['admin_quality']         = 'Qualidade';
$lang['admin_fixme']           = 'Fixme';
$lang['intro_h']               = 'Análise de Página';
$lang['g_created']             = 'Criado:';
$lang['g_modified']            = 'Última modificação:';
$lang['g_words']               = 'Palavras:';
$lang['g_chars']               = 'Caracteres:';
$lang['g_changes']             = 'Número de edições:';
$lang['g_authors']             = 'Top autores:';
$lang['anonymous']             = 'Anônimos';
$lang['i_qcscore']             = 'Qualidade:';
$lang['errorsfound_h']         = 'Possíveis problemas de qualidade identificados';
$lang['errorsfound']           = 'Depois de analisar a estrutura da página, foram identificados alguns possíveis problemas sobre a legibilidade e usabilidade da página. Por favor, dê uma olhada nos pontos abaixo e veja se você pode corrigi-los. Tenha em mente que esta foi uma análise automática - você precisa decidir se está correto.';
$lang['fixme_h']               = '%d FIXME(s)';
$lang['fixme']                 = 'A página contém marcadores sobre conteúdo ausente ou incorreto. Você deve substituir os marcadores FIXME pelo conteúdo corrigido.';
$lang['noh1_h']                = 'Nenhum título principal';
$lang['noh1']                  = 'Uma página deve sempre começar com um título de nível 1. Este título deve refletir o tópico principal da página.';
$lang['manyh1_h']              = '%d Títulos principais';
$lang['manyh1']                = 'A página contém vários títulos de nível 1. Uma página deve sempre conter exatamente um título de nível 1, refletindo o tópico principal da página. Se sua página contém vários tópicos principais, considere dividir a página em várias páginas.';
$lang['headernest_h']          = 'Seções aninhadas incorretamente';
$lang['headernest']            = 'A página contém seções que ignoram níveis de seção. Isso dificulta a legibilidade e a estrutura. Uma seção deve conter apenas os próximos níveis de subseção. Considere acrescentar títulos de sub-seções ausentes ou subir suas sub-seções existentes para o nível correto.';
$lang['manyhr_h']              = 'Muitas regras horizontais';
$lang['manyhr']                = 'A página contém várias regras horizontais (<code> ---- </ code>). Regras horizontais devem ser usadas muito raramente, pois dificultam a legibilidade e a estrutura de um documento. Considere reestruturar a página usando seções e parágrafos.';
$lang['manybr_h']              = 'Muitas quebras de linha forçada';
$lang['manybr']                = 'A página contém várias quebras de linha forçadas (<code> \\ </ code>). As quebras de linha devem ser evitadas o máximo possível, porque impedem o fluxo e a legibilidade do texto. Em vez disso, a página deve ser formatada usando parágrafos para suportar a mensagem do conteúdo. Para criar um parágrafo, basta inserir uma linha vazia no seu texto.';
$lang['deepquote_h']           = 'Citações profundamente aninhadas';
$lang['deepquote']             = 'Sua página contém citações profundamente aninhadas, isso pode indicar uma página de estilo de discussão. As discussões são difíceis de ler depois de um tempo. Recomenda-se refatorá-los em documentação apropriada, incorporando todos os fatos que foram mencionados na discussão anterior.';
$lang['singleauthor_h']        = 'Único Autor Apenas';
$lang['singleauthor']          = 'A página foi editada apenas por um único autor até o momento. Outros devem reavaliar a página para correção e legibilidade.';
$lang['toosmall_h']            = 'Documento muito pequeno';
$lang['toosmall']              = 'Esta página parece ser irracionalmente pequena e é provavelmente um esboço. Considere estender o conteúdo ou talvez remover a página.';
$lang['toolarge_h']            = 'Documento muito grande';
$lang['toolarge']              = 'Esta página é muito grande. Páginas longas são difíceis de ler em um monitor. Considere dividir em várias páginas.';
$lang['manyheaders_h']         = 'Muitos títulos';
$lang['manyheaders']           = 'Em comparação com o tamanho total, esta página tem muitos títulos. Demasiada estrutura sem qualquer conteúdo real pode dificultar a legibilidade e utilidade da página.';
$lang['fewheaders_h']          = 'Poucos títulos';
$lang['fewheaders']            = 'Em comparação com o tamanho total, esta página não tem muitos títulos. A estruturação de textos com subseções facilita a visão geral do conteúdo e ajuda os leitores a entender melhor o texto.';
$lang['nolink_h']              = 'Sem Winki Links';
$lang['nolink']                = 'Todas as páginas de um wiki devem estar linkadas entre si. Esta página parece não conter um único link para outra página da wiki. Talvez você possa linkar para algumas páginas relacionadas?';
$lang['brokenlink_h']          = 'Muitos links para páginas que não existem';
$lang['brokenlink']            = 'Esta página contém vários links para páginas que não existem. Isso é normal para novos tópicos ou ao criar um novo wiki. Você só deve se certificar de que essas páginas sejam criadas. Verifique também se você talvez tenha digitado errado os nomes das páginas vinculadas.';
$lang['manyformat_h']          = 'Demasiada formatação de texto';
$lang['manyformat']            = 'Em comparação com o tamanho total, esta página contém muita formatação de texto (como negrito, itálico ou sublinhado). Essa formatação deve ser usada apenas com parcimônia ou a legibilidade é prejudicada.';
$lang['longformat_h']          = 'Passagens Formatadas Longas';
$lang['longformat']            = 'Esta página contém algumas passagens mais longas formatadas (como negrito, itálico ou sublinhado). Essa formatação deve ser usada apenas com parcimônia ou a legibilidade é prejudicada.';
$lang['multiformat_h']         = 'Texto excessivamente formatado';
$lang['multiformat']           = 'Esta página contém algum texto formatado com várias marcações diferentes (como negrito, itálico ou sublinhado). A combinação de formatação é considerada um estilo tipograficamente ruim e dificulta a legibilidade.';
$lang['nobacklink_h']          = 'Nenhum backlink';
$lang['nobacklink']            = 'Parece que nenhuma outra página está vinculanda a esta página. Isso geralmente significa que não pode ser encontrado por outros meios que não a pesquisa ou o índice. Isso pode não ser verdade, se você estiver usando plug-ins de listagem de páginas automáticas. Veja se você pode linkar para esta página de algum outro lugar no wiki.';
