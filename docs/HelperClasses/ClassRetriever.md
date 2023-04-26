# Class Retriever

## Introduction

The ClassRetriever class is a helper class that allows you to retrieve information about a PHP class, interface, or
trait from a file. It provides two static methods, `make($filepath)` and `fromSplFileInfo($filepath)`, which take a
filename or an instance of `SplFileInfo` respectively, and return a ClassRetrieverResponse object containing information
about the class.

Usage

To use the ClassRetriever class, you can either create a new instance of the class and call the `parseFile()` method, or
use one of the static methods `make($filepath)` or `fromSplFileInfo($filepath)`.

```php
use Midnite81\Core\Helpers\ClassRetriever;

// Via instantiation
$classRetriever = new ClassRetriever('/path/to/MyClass.php');
$response = $classRetriever->parseFile();

// Via static method
$response = ClassRetriever::make('/path/to/MyClass.php');

// Via static method with SplFileInfo
$splFileInfo = new SplFileInfo('/path/to/MyClass.php');
$response = ClassRetriever::fromSplFileInfo($splFileInfo);

// Access the information from the response object
echo $response->name; // MyNamespace\MyClass
echo $response->type; // class
echo $response->extends; // MyNamespace\MyParentClass
print_r($response->implements); // Array ( [0] => MyNamespace\MyInterface )
print_r($response->traits); // Array ( [0] => MyNamespace\MyTrait )
print_r($response->isAbstract) // Bool (false)
```

## ClassRetrieverResponse Object

The ClassRetrieverResponse object returned by the ClassRetriever class contains the following properties:

- name (string): The fully-qualified name of the class, interface, or trait.
- type (string): The type of the class, either "class", "interface", or "trait".
- extends (string): The fully-qualified name of the class that the current class extends, or an empty string if the
  class does not extend any other class.
- implements (array): An array of fully-qualified interface names that the current class implements.
- traits (array): An array of fully-qualified trait names that the current class uses.
- isAbstract (bool): Whether the class is abstract.
