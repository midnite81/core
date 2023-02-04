# QuickFireScriptCommand

_This command allows you to execute a predefined shortcut (under the shortcuts key in config/core-ignition.php)
You should not that you cannot pass any additional arguments to run:quick as arguments and options should be
defined within the shortcuts section of the config_

_To understand the QuickFireScriptCommand better, it is worth reading through 
[FireScriptsCommand.md](FireScriptsCommand.md)_

## Usage

```php
php artisan scripts:quick {script_name} {arguments}
```
_replace {script_name} with the actual script name_

__Please note; as you can change the command from run:quick to anything of your choosing, if you have changed the 
command name you will need to replace run:quick with whatever you've specified in the config file__

## Setup 

In your [config/core-ignition.php](../../config/core-ignition.php) file you will need to have a profile already set up.
If you have not done this yet, please read reading through [FireScriptsCommand.md](FireScriptsCommand.md). 

From this point forward, this example will assume you understand profiles. In our example, our profile will run 
composer install and npm install

```php
 'profiles' => [
        'composer-and-npm-install' => [
            'Do you wish to composer install?' => 'composer install',
            'Do you wish to npm install' => 'npm i',
        ],
],
```

As we'll run this command a lot we will make a shortcut so we don't have to specify all the arguments and options that 
will be necessary, however if you need to you can pass arguments on the command line, but no options. In this example 
we'll be setting up a shortcut to run the profile adding in the silent option so we don't even have to confirm each 
stage and we also want it to abort on failure. 

Under the shortcuts key in [config/core-ignition.php](../../config/core-ignition.php) we'll create a new shortcut with
the key of `composer-npm`, which we'll later use to do `php artisan run:quick composer-npm`. The value of 
`composer-npm` will be the arguments and options which get passed to the FireScriptsCommand. We'll pass through a 
profile for the command to use, in this case it's `composer-and-npm-install` which we've defined already in the 
profiles section of the config. We are also going to pass two options though, the silent option and abortOnFailure 
option.

```php
'shortcuts' => [
    'composer-npm' => [
        '--profile' => 'composer-and-npm-install',
        '--silent' => '--silent',
        '--abortOnFailure',
    ],

```

Now this is in place we can simply run `php artisan run:quick composer-npm` rather than using 
`php artisan run:script --profile="composer-and-npm-install" --silent --abortOnFailure`
