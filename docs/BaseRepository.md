# Base Repository

The BaseRepository class is an abstract class that provides basic database operations for a Laravel Eloquent Model. The
class provides methods to fetch a single record by ID or by a specific column, and also to fetch multiple records either
with or without a specified column condition. The methods use the Laravel query builder to construct and execute the
database queries. The class also provides a method to sort the results of the database queries. The class is designed to
be used as a base class for more specific repository classes that interact with a single type of Eloquent model.

## Properties:

- model: An instance of the Laravel Eloquent Model that the repository is built for.
- orderBy: An array of arrays that contains the sorting information for the database queries. The sorting information is
  represented as a column name and its direction (ascending or descending).

## Methods:

- `internalTryGetById(int $id)`: This method returns a single record from the database based on the ID of the record. If
  the record is not found, it returns null.
- `internalGetById(int $id)`: This method returns a single record from the database based on the ID of the record. If the
  record is not found, it throws a RecordNotFoundException.
- `internalTryGetByColumn(string $column, string|int $identifier)`: This method returns a single record from the database
  based on a specified column and its value. If the record is not found, it returns null.
- `internalGetByColumn(string $column, string|int $identifier)`: This method returns a single record from the database
  based on a specified column and its value. If the record is not found, it throws a RecordNotFoundException.
- `internalListAll()`: This method returns all records from the database as a Collection of Eloquent models. The results
  can be sorted using the orderBy property.
- `internalListByColumn(string $column, int|string|array $value)`: This method returns all records from the database that
  match a specified condition based on a column and its value. The results can be sorted using the orderBy property.
- `setOrderBy(array $orderBy)`: This method sets the orderBy property to the specified value and returns the repository
  instance.
