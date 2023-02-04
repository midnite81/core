# Base Action

**Class:** Midnite81\Core\Store\Actions\BaseAction

This is an abstract class that provides basic functionality for managing data stored in an Eloquent Model.

## Properties

- model (Model) The model which the action is based upon, to be set at the extended class level.
  
## Methods
  - `internalStore(array $data)`: Store data to the model.
  - `internalUpdate(Model $model, array $data)`: Update data to the passed model.
  - `internalUpdateOrCreate(array $attributes, array $data)`: Updates or creates a record.


