24-11-2016 : Instagram closed the endpoint. We are trying figure out a new way to get access to it.

# Get instagram images by hashtag and user id!
A workaround for the new Instagram policy to get images by hashtag and user id.
No need for accesstoken :)
Use at your own risk.

By [Vassardish](https://github.com/Vassard) and [Bolandish](https://github.com/Bolandish)
##Install

### Via Composer
```shell
composer require bolandish/instagram-grabber
```

### Via Include
```php
require_once '/vendor/autoload.php';
```

##Usage

### Get by hashtag
```php
Bolandish\Instagram::getMediaByHashtag("nofilter", 10);
```

### Get by user id
```php
Bolandish\Instagram::getMediaByUserID(460563723, 10);
```

### Get after a specific post by user id
```php
Bolandish\Instagram::getMediaAfterByUserID(460563723, 1060728019300790746, 10);
```

If something missing in the response, please open an issue to report :)

## Plugins
* [Image hashtag feed](https://github.com/digitoimistodude/image-hashtag-feed) plugin for WordPress, _by Digitoimisto Dude_

Help me build this better! Thanks! :)
