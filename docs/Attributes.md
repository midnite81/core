# Attributes

The following attributes have been designed to enhance the functionality of the midnite81/core system. However, you can
also use them in your own projects as needed. Keep in mind that these are simply attributes and you will need to
implement their behavior in your application.

## IgnoreProperty Attribute

**Usage:** Used with `BaseEntity`  
**Target:** Properties

This attribute allows you to ignore a property when outputting properties in methods such as `toArray()`. The property
will not be disclosed to the public.

```php
#[\Midnite81\Core\Attributes\IgnoreProperty]
protected Carbon $startDate;
```

## PropertiesMustBeInitialised Attribute

**Usage:** Used with `BaseEntity`  
**Target:** Classes

This attribute ensures that all properties in a class have been initialized before using a method such as toArray().

The use of this attribute it to check all properties on a class have been initialised before using a method such as
`toArray()`.

```php
#[\Midnite81\Core\Attributes\PropertiesMustBeInitialised]
class MyEntity 
{ 
}

```

## PropertyName Attribute

**Usage:** Used with `BaseEntity`  
**Target:** Properties

This attribute allows you to assign a different name to a property than its actual name when using a method such as
toArray(). For example, you may have a property named $startDate but when returning it as an array, you need it to be
listed as start_date.

```php
#[\Midnite81\Core\Attributes\PropertyName('start_date')]
protected Carbon $startDate;
```

## RequiredProperty Attribute

**Usage:** Used with `BaseEntity`  
**Target:** Properties

This attribute ensures that a property has been initialized, as it is required, before using methods such as `toArray()`.

```php
#[\Midnite81\Core\Attributes\RequiredProperty]
protected string $name;
```

