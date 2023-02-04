# Exceptions

Although some of these exceptions can be tied to functionality contained within midnite81/core, I shall list the core
exceptions out as they can be used in your own applications, rather than having to reinvent them.

## Method Not Implemented Exception

**Exception:** \Midnite81\Core\Exceptions\MethodNotImplementedException

This throws an exception where a method is not implemented. Useful if you have an abstract class which needs a method
to be defined.

## File Not Found Exception

**Exception:** \Midnite81\Core\Exceptions\General\FileNotFoundException

This exception is thrown when a file is not found. You can add your own message to this exception, however there is a
default of "File Not Found"

## Record Not Found Exception

**Exception:** \Midnite81\Core\Exceptions\General\FileNotFoundException

This custom exception is thrown when a record is not found in the database. It provides a more specific error message
for when a record is missing compared to a generic exception.

The constructor takes three parameters:

- `$id`: The id of the record that was not found, which can be an integer or string.
- `$code`: An optional integer parameter for the error code. The default value is 0.
- `$previous`: An optional parameter for a previous exception if one exists.

The constructor creates a message using `sprintf` that says "Record with id [$id] was not found". This message, along
with the error code and previous exception, is passed to the parent class' constructor (Exception) to be available when
the exception is caught.

Usage:
Use this exception in a try-catch block to handle missing record errors. Catch this specific exception to take action
specific to record not found errors.

Example:
try {
// code that may throw a RecordNotFoundException
} catch (RecordNotFoundException $e) {
// handle the record not found error
}

## Class inheritance exceptions

### ClassMustInheritFromException

**Exception:** \Midnite81\Core\Exceptions\General\ClassMustInheritFromException

The ClassMustInheritFromException class is thrown when a class does not extend from a specified class.

The class constructor has two parameters:

- $class: The class that should implement from the specified class.
- $extendClass: The specified class that the class should extend from.

The exception message is generated based on the two parameters, where the exception message would be "$class must
extend from $extendClass".

### ClassMustImplementFromException

**Exception:** \Midnite81\Core\Exceptions\General\ClassMustImplementFromException;

The ClassMustInheritFromException class is thrown when a class does not implement from a specified class.

The class constructor has two parameters:

- $class: The class that should implement from the specified class.
- $inheritFromClass: The specified class that the class should implement from.

The exception message is generated based on the two parameters, where the exception message would be "$class must
implement from $extendClass".
