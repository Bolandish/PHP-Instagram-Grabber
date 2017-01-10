<?php
namespace Bolandish;

class Instagram {
    /**
     * @var array
     */
    protected static $curlProxy = array();

    public static function setCurlProxy(array $config) {
        foreach ($config as $k => $v) {
            if ((in_array($k, array(CURLOPT_HTTPPROXYTUNNEL)) && is_bool($v))
                || (in_array($k, array(CURLOPT_PROXYAUTH, CURLOPT_PROXYPORT, CURLOPT_PROXYTYPE)) && is_int($v))
                || (in_array($k, array(CURLOPT_PROXY, CURLOPT_PROXYUSERPWD)) && is_string($v))
            ) {
                self::$curlProxy[$k] = $v;
            }
        }
    }

    protected static function getContentsFromUrl($parameters) {
        if (!function_exists('curl_init')) {
            return false;
        }
        $random = self::generateRandomString();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/query/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'q='.$parameters);
        foreach (self::$curlProxy as $k => $v) {
            curl_setopt($ch, $k, $v);
        }
        $headers = array();
        $headers[] = "Cookie:  csrftoken=$random;";
        $headers[] = "X-Csrftoken: $random";
        $headers[] = "Referer: https://www.instagram.com/";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($ch);
        curl_close($ch);



        return $output;
    }
    protected static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

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
        $media = json_decode(static::getContentsFromUrl($parameters), ($assoc || $assoc == "array"));
        if($assoc == "array")
            $media = $media["media"]["nodes"];
        elseif (isset($media->media->nodes))
            $media = $media->media->nodes;
        else
            $media = array();
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
        $media = json_decode(static::getContentsFromUrl($parameters),($assoc || $assoc == "array"));
        if($assoc == "array")
            $media = $media["media"]["nodes"];
        elseif (isset($media->media->nodes))
            $media = $media->media->nodes;
        else
            $media = array();

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

        $media = json_decode(static::getContentsFromUrl($parameters),($assoc || $assoc == "array"));
        if($assoc == "array")
            $media = $media["media"]["nodes"];
        elseif (isset($media->media->nodes))
            $media = $media->media->nodes;
        else
            $media = array();

        return $media;
    }

    public static function getCommentsByMediaShortcode($media_shortcode = null, $count = 16, $assoc = false)
    {

        $comments = "comments.last($count) {           count,           nodes {             id,             created_at,             text,             user {               id,               profile_pic_url,               username             }           },           page_info         }";

        $parameters = urlencode("ig_shortcode({$media_shortcode}) { $comments }");
        $comments = json_decode(static::getContentsFromUrl($parameters),($assoc || $assoc == "array"));
        if($assoc == "array")
            $comments = $comments["comments"]["nodes"];
        elseif (isset($comments->comments->nodes))
            $comments = $comments->comments->nodes;
        else
            $comments = array();
        return $comments;
    }

    public static function getCommentsBeforeByMediaShortcode($media_shortcode = null, $max_id, $count = 16, $assoc = false)
    {

        $comments = "comments.before($max_id, $count) {           count,           nodes {             id,             created_at,             text,             user {               id,               profile_pic_url,               username             }           },           page_info         }";

        $parameters = urlencode("ig_shortcode({$media_shortcode}) { $comments }");
        $comments = json_decode(static::getContentsFromUrl($parameters),($assoc || $assoc == "array"));
        if($assoc == "array")
            $comments = $comments["comments"]["nodes"];
        elseif (isset($comments->comments->nodes))
            $comments = $comments->comments->nodes;
        else
            $comments = array();
        return $comments;
    }
}