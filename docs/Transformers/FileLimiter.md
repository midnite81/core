# File Limiter
**Class:** \Midnite81\Core\Transformers\FileLimiter

The FileLimiter class is a PHP class that allows you to read specific lines from a file.

## Class Properties

- `$lines`: An array that stores the lines from the document.
- `$fileResource`: A file resource for the input file.
- `$index`: An integer that stores the current reading index.

## Constructor

The constructor of the class takes a single string parameter $filename, representing the name of the file to be read. If
the file does not exist, a RuntimeException is thrown with a message "File could not be found". If the file is not a
resource, a RuntimeException is thrown with a message "File is not a resource".

## Methods

- `make(string $filename)`: A factory method that creates a new instance of the FileLimiter class.
- `readFirstLines(int $numberOfLines = 5)`: Reads the first $numberOfLines from the file and stores it in the $lines
  property.
- `readLastLines(int $numberOfLines = 5)`: Reads the last $numberOfLines from the file and stores it in the $lines
  property.
- `readSpecificLines(array $lineNumbers)`: Reads the specific lines indicated in the $lineNumbers array and stores it in
  the $lines property.
- `toString()`: Returns the contents of the $lines property as a string.
- `toArray()`: Returns the contents of the $lines property as an array.
- `toJson()`: Returns the contents of the $lines property as a JSON object.

## Example

```php
$fileLimiter = FileLimiter::make('test.txt');
$fileLimiter->readFirstLines();

$lines = $fileLimiter->toArray();
```

In this example, a new instance of the FileLimiter class is created using the make method and reading the first 5 lines
of the test.txt file. The contents of the file are then returned as an array using the toArray method.



