<?php
function getImagesByHashtag($hashtag, $count = 16)
{
    $hashtag = strtolower($hashtag);
    $parameters = urlencode("ig_hashtag($hashtag) { media.first($count) {   count,   nodes {     caption,     code,     comments {       count     },     date,     dimensions {       height,       width     },     display_src,     id,     is_video,     likes {       count     },     owner {       id,       username     },     thumbnail_src,     video_views,     video_url   },   page_info }  }");
    $url = "https://www.instagram.com/query/?q=$parameters&ref=tags%3A%3Ashow";
    $more = json_decode(file_get_contents($url));
    $more = $more->media->nodes;
    return $more;
}

?>

