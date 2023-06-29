<?php
$fd = fopen("test.xml", 'r') or die("не удалось открыть файл");
$categories = [];
$category = [];
$teasers = [];
$teaser = [];

while(!feof($fd))
{
    $str = trim(fgets($fd));

    if(strpos($str, 'category ')) {
        $category['id'] = get_string_between($str, 'id="', '">');
        $category['title'] = get_string_between($str, '">', '</');
        $categories[] = $category; //insert into db
    }

    if(strpos($str, 'teaser ')) {
        $teaser['id'] = (int) get_string_between($str, 'id="', '" ');
        $teaser['active'] = strpos($str, 'true') ? 1 : 0;
    }

    if(strpos($str, 'categoryId')) {
        $teaser['category_id'] = getWithoutTag('categoryId', $str);
    }

    if(strpos($str, 'url')) {
        $teaser['url'] = getWithoutTag('url', $str);
    }

    if(strpos($str, 'picture')) {
        $teaser['picture'] = getWithoutTag('picture', $str);
    }

    if(strpos($str, 'title')) {
        $teaser['title'] = getWithoutTag('title', $str);
    }

    if(strpos($str, 'vendor')) {
        $teaser['vendor'] = getWithoutTag('vendor', $str);
    }

    if(strpos($str, 'text')) {
        $teaser['text'] = getWithoutTag('text', $str);
    }

    if(strpos($str, '/teaser')) {
        $teasers[] = $teaser;  //insert into db
    }

}
fclose($fd);

echo '<pre>';
print_r($categories);
echo '</pre>';
echo '<pre>';
print_r($teasers);
echo '</pre>';

function getWithoutTag($tag, $string) {
    return str_replace(['<'.$tag.'>', '<'.$tag.'/>'], '', $string);
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
