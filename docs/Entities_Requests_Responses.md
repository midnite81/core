# Entities, Requests, Responses

**Class:** Midnite81\Core\Entities\BaseEntity
**Class:** Midnite81\Core\Requests\BaseRequest
**Class:** Midnite81\Core\Responses\BaseResponse

The BaseEntity is an abstract class that provides common methods for processing and converting data. This class is
intended to be used as a base for creating concrete entities in an application. BaseRequest and BaseResponse inherit
from BaseEntity to provide a more normal naming convention.

Entities, Requests and Responses allow you to have strongly typed properties which provide a better experience when 
you want type safety. To get a better sense of entities, it maybe worth looking at the 
[Entity Test Fixture classes](../tests/Entities/TestHelpers/)

## Methods

- `__construct`: Constructs the entity and performs initial checks.
- `process`: An empty method that can be overridden by child classes to perform additional processing.
- `toArray`: Returns the initialised properties of the entity as an array.
- `toLimitedArray`: Returns a limited array with the keys passed.
- `toJson`: Returns the initialised properties of the entity as a JSON string.
- `toQueryString`: Returns the initialised properties of the entity as a query string.
- `map`: Maps data to the entity.
- `getPublicProperties`: Returns an array of public properties in the entity.
- `getInitialisedProperties`: Returns an array of initialised public properties.
- `allPropertiesInitialised`: Checks that all public properties have been initialised.
- `checkRequiredPropertiesAreFilled`: Checks that all required properties have been filled.
- `checkForIdenticalPropertyNameAttributeNames`: Checks that no two properties have the same PropertyName attribute name.

## Exceptions

- DuplicatePropertyNameException: Thrown when two properties have the same PropertyName attribute name.
- PropertiesMustBeInitialisedException: Thrown when all public properties are not initialised and the entity has the PropertiesMustBeInitialised attribute.
- PropertyIsRequiredException: Thrown when a required property is not filled.
