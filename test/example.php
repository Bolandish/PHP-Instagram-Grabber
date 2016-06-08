<?php
require_once __DIR__ . '/../vendor/autoload.php';

//Its getting 10 images/videoes from instagram with the hastag #nofilter
$media = Bolandish\Instagram::getMediaByHashtag("nofilter", 10);
print_r($media);

//Its getting 10 images/videoes from Selena Gomezs instagram.. mmhh..
$media = Bolandish\Instagram::getMediaByHashtag(460563723, 10);
print_r($media);

//Display square images only
$media = Bolandish\Instagram::getMediaByHashtag("wildlife", 20);
foreach($pics as $key=>$value){
  if ($pics[$key]->dimensions->width === $pics[$key]->dimensions->height){
    echo '<img src="'.$pics[$key]->display_src.'"/>';
  }
}
