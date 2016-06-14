<?php
namespace Bolandish;

class Instagram {
    public static function getMediaByHashtag($hashtag = null, $count = 16, $assoc = false, $comment_count = false)
    {
        if ( empty($hashtag) || !is_string($hashtag) )
        {
            return false;
        }
        if($comment_count){
            $comments = "comments.last($comment_count) {           count,           nodes {             id,             created_at,             text,             user {               id,               profile_pic_url,               username             }           },           page_info         }";
        }else{
            $comments = "comments {       count     }";
        }
        $hashtag = strtolower($hashtag);
        $parameters = urlencode("ig_hashtag($hashtag) { media.first($count) {   count,   nodes {     caption,     code,   $comments,     date,     dimensions {       height,       width     },     display_src,     id,     is_video,     likes {       count     },     owner {       id,       username,       full_name,       profile_pic_url,     biography     },     thumbnail_src,     video_views,     video_url   },   page_info }  }");
        $url = "https://www.instagram.com/query/?q=$parameters&ref=tags%3A%3Ashow";
        $media = json_decode(file_get_contents($url), ($assoc || $assoc == "array"));
        if($assoc == "array")
            $media = $media["media"]["nodes"];
        else
            $media = $media->media->nodes;
        return $media;
    }

    public static function getMediaByUserID($user = null, $count = 16, $assoc = false, $comment_count = false)
    {
        if ( empty($user) || !(is_string($user) || is_int($user)) )
        {
            return false;
        }
        if($comment_count){
            $comments = "comments.last($comment_count) {           count,           nodes {             id,             created_at,             text,             user {               id,               profile_pic_url,               username             }           },           page_info         }";
        }else{
            $comments = "comments {       count     }";
        }
        $parameters = urlencode("ig_user($user) { media.first($count) {   count,   nodes {     caption,     code,     $comments,     date,     dimensions {       height,       width     },     display_src,     id,     is_video,     likes {       count     },     owner {       id,       username,       full_name,       profile_pic_url,     biography     },     thumbnail_src,     video_views,     video_url   },   page_info }  }");
        $url = "https://www.instagram.com/query/?q=$parameters&ref=tags%3A%3Ashow";
        $media = json_decode(file_get_contents($url),($assoc || $assoc == "array"));
        if($assoc == "array")
            $media = $media["media"]["nodes"];
        else
            $media = $media->media->nodes;
        return $media;
    }

    public static function getMediaAfterByUserID($user = null, $min_id, $count = 16, $assoc = false, $comment_count = false)
    {
        if ( empty($user) || !(is_string($user) || is_int($user)) )
        {
            return false;
        }
        if($comment_count){
            $comments = "comments.last($comment_count) {           count,           nodes {             id,             created_at,             text,             user {               id,               profile_pic_url,               username             }           },           page_info         }";
        }else{
            $comments = "comments {       count     }";
        }

        $parameters = urlencode("ig_user($user) { media.after($min_id,$count) {   count,   nodes {     caption,     code,    $comments,   date,     dimensions {       height,       width     },     display_src,     id,     is_video,     likes {       count     },     owner {       id,       username,       full_name,       profile_pic_url,     biography     },     thumbnail_src,     video_views,     video_url   },   page_info }  }");

        $url = "https://www.instagram.com/query/?q=$parameters&ref=tags%3A%3Ashow";
        $media = json_decode(file_get_contents($url),($assoc || $assoc == "array"));
        if($assoc == "array")
            $media = $media["media"]["nodes"];
        else
            $media = $media->media->nodes;

        return $media;
    }
}



?>

