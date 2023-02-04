# UserAgent

This class provides a number of methods to check if the user agent string matches a specific pattern. Principally,
this is used to check if the user agent string is from Facebook, Twitter or Apple iMessage link previewer. However,
you can use the `matchesPatternInUserAgent` method to check if the user agent string matches a specific pattern.

## Usage

```php
use Midnite81\Core\Helpers\UserAgent;

// Check if the user agent string is from Facebook
$isFacebook = UserAgent::isFacebook();

// Check if the user agent string is from Twitter
$isTwitter = UserAgent::isTwitter();

// Check if the user agent string is from Apple iMessage link previewer
$isAppleIMessageLinkPreviewer = UserAgent::isAppleIMessageLinkPreviewer();

// Check if the user agent string matches a specific pattern
$matchesPattern = UserAgent::matchesPatternInUserAgent('my-pattern');
```
