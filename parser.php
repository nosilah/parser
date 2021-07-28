<?php
error_reporting(0);
ini_set('display_errors', 0);



$info = [];



$pages = generateUrl('http://www.zernovoz.su/cargo/pages_1', '/html/body/div/div/div[@id="pages"]/a', 'http://www.zernovoz.su/cargo/pages_');

// echo '<pre>';

// print_r($pages);
// echo '</pre>';


for ($i = 0; $i < count($pages); $i++) {
    $dom = new DOMDocument();

    $dom->loadHTMLFile($pages[$i]);

    $xpath = '/html/body/div/div/div/a';
    $DomXpath = new DOMXPath($dom);
    $elements = $DomXpath->query($xpath);


    for ($a = 0; $a < 30; $a++) {
        $number = $DomXpath->query($xpath . '/div/div[@class="number hidden-xs hidden-sm"]');
        $date = $DomXpath->query($xpath . '/div/div[@class="date"]');
        $dist = $DomXpath->query($xpath . '/div/span[@class="dist"]');
        $timing = $DomXpath->query($xpath . '/div[@class="col-md-1 col-xs-2 hidden-xs hidden-sm date-row"]');
        $loading_place = $DomXpath->query($xpath . '/div[@class="col-md-2 col-xs-4"][1]');
        $unloading_place = $DomXpath->query($xpath . '/div[@class="col-md-2 col-xs-4"][2]');
        $price = $DomXpath->query($xpath . '/div[@class="col-md-2 col-xs-3 price-row hidden-xs hidden-sm"]');
        $contacts = $DomXpath->query($xpath . '/div[@class="col-md-2 col-xs-12 contact-row"]');

        $row = new row($number->nodeValue, $date->nodeValue, $dist->nodeValue, $timing->nodeValue, $loading_place->nodeValue, $unloading_place->nodeValue, $cargo->nodeValue, $price->nodeValue, $contacts->nodeValue);

        $row = new row(
            $number->item($a)->nodeValue,
            $date->item($a)->nodeValue,
            $dist->item($a)->nodeValue,
            $timing->item($a)->nodeValue,
            $loading_place->item($a)->nodeValue,
            $unloading_place->item($a)->nodeValue,
            $price->item($a)->nodeValue,
            $contacts->item($a)->nodeValue
        );

        array_push($info, $row);
    }

    
}







echo '<pre>';

print_r($info);
echo '</pre>';

function generateUrl($mainUrl, $xpathPaganations, $url)
{

    $pagesNum = [];
    $urlPages = [];

    $dom = new DOMDocument();

    $dom->loadHTMLFile($mainUrl);


    $DomXpath = new DOMXPath($dom);
    $paginations = $DomXpath->query($xpathPaganations);

    foreach ($paginations as $page) {
        array_push($pagesNum, $page->textContent);
    }

    for ($i = 1; $i <= max($pagesNum); $i++) {

        array_push($urlPages, $url . $i);
    }

    return $urlPages;
}




class row
{
    public $number = '';
    public $date = '';
    public $dist = '';
    public $timing = '';
    public $loading_place = '';
    public $unloading_place = '';
    public $price = '';
    public $contacts = '';

    function __construct($number, $date, $dist, $timing, $loading_place, $unloading_place, $price, $contacts)
    {
        $this->number = $number;
        $this->date = $date;
        $this->dist = $dist;
        $this->timing = $timing;
        $this->loading_place = $loading_place;
        $this->unloading_place = $unloading_place;
        $this->price = $price;
        $this->contacts = $contacts;
    }
}


