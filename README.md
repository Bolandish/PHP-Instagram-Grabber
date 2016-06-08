# Get instagram images by hashtag and user id!
A workaround for the new Instagram policy to get images by hashtag and user id.
No need for accesstoken :)

There is [WordPress wrapper plugin](#plugins) made out of this workaround.

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
Bolandish\Instagram::getMediaByHashtag(460563723, 10);
```

If something missing in the response, please open an issue to report :)

## Plugins
* [Image hashtag feed](https://github.com/digitoimistodude/image-hashtag-feed) plugin for WordPress, _by Digitoimisto Dude_

Help me build this better! Thanks! :)
