<?php
require_once __DIR__ . '/../vendor/autoload.php';

//Its getting 10 images/videoes from instagram with the hastag #nofilter
$media = Bolandish\Instagram::getMediaByHashtag("nofilter", 10);
print_r($media);

//Its getting 10 images/videoes from Selena Gomezs instagram.. mmhh..
$media = Bolandish\Instagram::getMediaByHashtag(460563723, 10);
print_r($media);

//Get 10 images/videos after the media with the id 1060728019300790746 from Selena Gomex
$media = Bolandish\Instagram::getMediaAfterByHashtag(460563723,1060728019300790746, 10);


//Display square images only
$media = Bolandish\Instagram::getMediaByHashtag("wildlife", 20);
foreach($media as $value){
  if ($value->dimensions->width === $value->dimensions->height){
    echo '<img src="' .$value->display_src. '" alt="' .$value->caption. '" />';
  }
}

//Make images clickable and link to instagram post
foreach($media as $key=>$value){
  if ($media[$key]->dimensions->width === $media[$key]->dimensions->height){
		echo '<a href="'.'https://www.instagram.com/p/'.$media[$key]->code.'" target="_blank"><img src="'.$media[$key]->display_src.'" alt="'.$media[$key]->caption.'" /></a>';
  }
}
