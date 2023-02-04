# Human Readable Number
**Class:** \Midnite81\Core\Transformers\HumanReadableNumber

The HumanReadableNumber class is a utility class for transforming numbers into human-readable formats. It supports
converting large or small numbers into abbreviated formats using the standard International System of Units (SI)
prefixes.

## Class Properties

- `number (int|float|null)` - the number to be transformed. This can be null, an integer or a floating-point number.

## Class Methods

`__construct`
This is the constructor method for the HumanReadableNumber class. It accepts a number as an argument and sets it to the
number property.

`make`
This is a static factory method for creating a new instance of the HumanReadableNumber class. It accepts an integer or
floating-point number as an argument, creates a new instance of the class, and returns it.

`of`
This method sets the number property of an existing instance of the HumanReadableNumber class. It accepts an integer or
floating-point number as an argument, sets it to the number property, and returns the instance.

`humanReadable`
This method returns a human-readable version of the number property. The returned value is a string representation of
the number abbreviated using standard SI prefixes. The method also accepts an optional argument numberOfDecimals that
specifies the number of decimal places to be shown in the abbreviated value.

`tryHumanReadable`
This method attempts to return a human-readable version of the number property. If an error is thrown during the
conversion process, it will return the original number property as a string.

`getExponentAbbreviations`
This is a protected method that returns an array of <exponent, abbreviation> pairs for standard SI prefixes.

`checkReady`
This is a protected method that checks if the number property is set. If it is not set, it will throw a
NumberCannotBeNullException.

`getNumberOfDecimals`
This is a protected method that calculates the number of decimal places to be shown in the abbreviated value. The
calculation is based on the exponent and the displayNumber passed to the method as arguments.

## Exception

`NumberCannotBeNullException` - this exception is thrown when the number property is not set (i.e., is null) when
calling the humanReadable method.

## Example Usage

```php
use Midnite81\Core\Transformers\HumanReadableNumber;

$number = 123456789.987654321;
$readable = HumanReadableNumber::make($number)->humanReadable(2);

// $readable will be equal to "123.46M"
```
