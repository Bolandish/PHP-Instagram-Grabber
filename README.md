# Get instagram images by hashtag and user id!
A workaround for the new Instagram policy to get images by hashtag and user id.
No need for accesstoken :)

There is [WordPress wrapper plugin](#plugins) made out of this workaround.

## Include
```php
include 'instagram.php';
```

## Get by hashtag
```php
getImagesByHashtag("nofilter", 16);
```

## Get by user id
```php
getImagesByUserID(12345, 16);
```

If something missing in the response, please open an issue to report :)

## Plugins
* [Image hashtag feed](https://github.com/digitoimistodude/image-hashtag-feed) plugin for WordPress, _by Digitoimisto Dude_

Help me build this better! Thanks! :)
