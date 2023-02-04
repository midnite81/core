# HtmlLinks

This class provides support for adding `target="_blank" rel="noopener noreferrer"` to external links.

## Usage

```php

$html = '<h1>Hello World. Have you seen <a href="https://google.com">Google</a> today?</h1>';
$string = HtmlLinks::targetBlank($html);

// returns:
// <h1>Hello World! Have you seen <a target="_blank" rel="noopener noreferrer" href="https://google.com">Google</a> today?</h1>
```
