<?php
$text = <<<TXT
<p class="big">
	Год основания:<b>1589 г.</b> Волгоград отмечает день города в <b>2-е воскресенье сентября</b>. <br>В <b>2023 году</b> эта дата - <b>10 сентября</b>.
</p>
<p class="float">
	<img src="https://www.calend.ru/img/content_events/i0/961.jpg" alt="Волгоград" width="300" height="200" itemprop="image">
	<span class="caption gray">Скульптура «Родина-мать зовет!» входит в число семи чудес России (Фото: Art Konovalov, по лицензии shutterstock.com)</span>
</p>
<p>
	<i><b>Великая Отечественная война в истории города</b></i></p><p><i>Важнейшей операцией Советской Армии в Великой Отечественной войне стала <a href="https://www.calend.ru/holidays/0/0/1869/">Сталинградская битва</a> (17.07.1942 - 02.02.1943). Целью боевых действий советских войск являлись оборона  Сталинграда и разгром действовавшей на сталинградском направлении группировки противника. Победа советских войск в Сталинградской битве имела решающее значение для победы Советского Союза в Великой Отечественной войне.</i>
</p>
TXT;

// функция для обрезки текста до указанного количества слов
function truncate_html($html, $word_limit) {
    $doc = new DOMDocument();
    @$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    $body = $doc->getElementsByTagName('body')->item(0);

    $word_count = 0;
    $truncate = false;

    // рекурсивная функция обхода нодов
    $walker = function (DOMNode $node) use (&$walker, &$word_count, $word_limit, &$truncate) {
        if ($truncate) {
            return;
        }
        if ($node->nodeType === XML_TEXT_NODE) {
            $words = preg_split('/\s+/u', $node->nodeValue, -1, PREG_SPLIT_NO_EMPTY);
            $word_count += count($words);
            if ($word_count > $word_limit) {
                $truncate = true;
                $remaining_words = $word_limit - ($word_count - count($words));
                $node->nodeValue = implode(' ', array_slice($words, 0, $remaining_words)) . '...';
            }
        } elseif ($node->hasChildNodes()) {
            foreach (iterator_to_array($node->childNodes) as $child) {
                $walker($child);
            }
        }
    };

    $walker($body);
    return $doc->saveHTML();
}

// применение функции обрезки текста
$truncated_text = truncate_html($text, 29);
// вывод текста
echo $truncated_text;
?>