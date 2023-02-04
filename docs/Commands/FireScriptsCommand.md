# FireScriptCommand

_This command allows you to predefine a series of command line, artisan commands, and extended script classes to 
run in order with a prompt asking if you wish to run that item, though you have the option to silence the prompt_

## Example Usage
```php
php artisan scripts:run {arguments} --profile=default [--silent] [--abortOnFailure] [--options="delay|3"] [--options="colour|blue"]
```
```php
php artisan scripts:run --shortcut=shortcutKey
```
```php
php artisan scripts:run feature/calendar-section --profile="switch branches and install" --options"new"
```
__Please note; as you can change the command from run:quick to anything of your choosing, if you have changed the
command name you will need to replace run:quick with whatever you've specified in the config file__

## Installation and setup

If you haven't already, you will need to publish the config file which you can do with the following command;

```bash
php artisan vendor:publish --provider="Midnite81\Core\CoreServiceProvider" --tag=config
```

This will install the [config/core-ignition.php](../../config/core-ignition.php) config file to your `config` folder.
You should take a few moments to review this file. 



