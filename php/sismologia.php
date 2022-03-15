<?php
// SimpleXML and namespaces
// https://www.sitepoint.com/simplexml-and-namespaces/
header("Content-Type: application/json;charset=utf-8");
header('Access-Control-Allow-Origin: *');

$xml = simplexml_load_file('http://www.ign.es/ign/RssTools/sismologia.xml');

$result = array();

foreach ($xml->channel->item as $item) {
    $arr = array();

    $title = $item->title;

    $title = str_replace("-Info.terremoto: ", "", $title);

    $arr["date"] = substr($title, 0, 10);
    $arr["time"] = substr($title, 11);

    $arr["link"] = (string)$item->link;

    $description = (string)$item->description;
    $arr["description"] = $description;

    $arr["magnitude"] = substr($description, strpos($description, "magnitud") + 9, 3);
    $location = substr($description, strpos($description, "en") + 3);
    $location = substr($location, 0, strpos($location, "en") - 1);
    $arr["location"] = $location;

    // namespace geo
    $ns_geo = $item->children('http://www.w3.org/2003/01/geo/wgs84_pos#');
    $arr["lat"] = (string)$ns_geo->lat;
    $arr["long"] = (string)$ns_geo->long;

    $result[] = $arr;
}
/*
 echo "<pre>";
 print_r($result);
 echo "</pre>";
 */
echo json_encode($result);
