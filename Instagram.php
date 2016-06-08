<?php
function getImagesByHashtag($hashtag, $ran_count= 16){
    $crawl = file_get_contents("https://www.instagram.com/explore/tags/$hashtag/");

    $crawl = (str_replace("window._sharedData = ", "", strstr($crawl, "window._sharedData =")));

    $crawl = substr($crawl, 0, strpos($crawl, ';</script>'));

    $crawl = json_decode($crawl);

    $end_cursor = ($crawl->entry_data->TagPage[0]->tag->media->page_info->end_cursor);

    $images = $crawl->entry_data->TagPage[0]->tag->media->nodes;

    $more = array();

    if($ran_count > 16) {
        $count = $ran_count-16;
        $url = "https://www.instagram.com/query/?q=ig_hashtag($hashtag) { media.after($end_cursor, $count) {   count,   nodes {     caption,     code,     comments {       count     },     date,     dimensions {       height,       width     },     display_src,     id,     is_video,     likes {       count     },     owner {       id,       username     },     thumbnail_src,     video_views   },   page_info }  }&ref=tags%3A%3Ashow";
        $url = "https://www.instagram.com/query/?q=ig_hashtag($hashtag)+%7B+media.after($end_cursor%2C+$count)+%7B%0A++count%2C%0A++nodes+%7B%0A++++caption%2C%0A++++code%2C%0A++++comments+%7B%0A++++++count%0A++++%7D%2C%0A++++date%2C%0A++++dimensions+%7B%0A++++++height%2C%0A++++++width%0A++++%7D%2C%0A++++display_src%2C%0A++++id%2C%0A++++is_video%2C%0A++++likes+%7B%0A++++++count%0A++++%7D%2C%0A++++owner+%7B%0A++++++id%0A++++%7D%2C%0A++++thumbnail_src%2C%0A++++video_views%0A++%7D%2C%0A++page_info%0A%7D%0A+%7D&ref=tags%3A%3Ashow";
        $more = json_decode(file_get_contents($url));
        $more = $more->media->nodes;
    }

    return array_merge($images, $more);

}
?>

