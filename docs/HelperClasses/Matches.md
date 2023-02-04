# Class: Matches

A class for matching a pattern in a given string using regular expressions.

## Method: match

### Parameters:

- $pattern (string): The regular expression pattern to be matched against the string.
- $string (string): The string to be searched for matches.
- $global (bool, optional): A flag to indicate if all matches should be returned or just the first one. Defaults to
  false (returns only the first match).
- $flags (int, optional): A set of flags for the regular expression pattern. Defaults to 0.
- $offset (int, optional): The starting position for the search in the string. Defaults to 0.

### Returns:

MatchEntity: An instance of the MatchEntity class, representing the result of the match.
This method uses the preg_match or preg_match_all function from the pcre library to match the pattern against the
string. The result of the match is stored in an instance of the MatchEntity class, which is then returned by the method.

### Usage

```php
$pattern = "/\w+/";
$string = "The quick brown fox jumps over the lazy dog.";
$result = Matches::match($pattern, $string, true);

$result->matched // returns if there were any matches
$result->matches // returns a collection of the matches
```
