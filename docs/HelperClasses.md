# Helper Classes

## Arrays

A class for array manipulation. It includes functions for sorting arrays, imploding arrays, renaming keys in arrays,
and more. [View the documentation](HelperClasses/Arrays.md)

## Attempts

A class for matching a pattern in a given string using regular expressions. 
[View the documentation](HelperClasses/Attempt.md)

## ClassRetriever 

A class for retrieving information about a PHP class, interface, or trait from a file.
[View the documentation](HelperClasses/ClassRetriever.md)

## HtmlLinks

This class provides support for adding `target="_blank" rel="noopener noreferrer"` to external links.
[View the documentation](HelperClasses/HtmlLinks.md)

## Matches

This class add a wrapper around the regular expression functions in php.
[View the documentation](HelperClasses/Matches.md)

## Strings

This class provides a constant to reference a blank string. 

Example:

```php
use Midnite81\Core\Helpers\Strings;

if ($string === Strings::EMPTY_STRING) {
    echo ('Your string is empty');
}
```


## UserAgent

This class provides a number of methods to check if the user agent string matches a specific pattern.
[View the documentation](HelperClasses/UserAgent.md)
