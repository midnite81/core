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

## Changing the command name

To avoid any potential name clashes, you are able to provide your own command name the 
[FireScriptsCommand.md](FireScriptsCommand.md) and [QuickFireScriptCommand](QuickFireScriptsCommand.md). If you do 
change this in your the [config/core-ignition.php](../../config/core-ignition.php) you will need to 
`php artisan optimize` or `php artisan optimize:clear` (which ever meets your needs), in order to let laravel know
you've changed the name.

## Creating a profile

In this example we're going to create a simple profile which will run composer install and npm i

In our profiles section we'll create a profile with a key of `install`. By default, the user is asked command
by command whether they want to run each script. The key will be the question asked to the user and the value is the 
command you wish to run on the terminal

```php
'profiles' => [
    'install' => [
        'Do you want to composer install' => 'composer install',
        'Do you want to run npm install' => 'npm i',
    ]
],
```

To run this command we just need to let scripts:run know what profile we want to run
```bash
php artisan scripts:run --profile=install
```

We also have a couple of additional options available to us; 

`--silent` allows the user not to be asked the question before the execution of the script   
`--abortOnFailure` by default, the scripts will continue even if the previous on failed, however by adding this flag 
you can abort when the first failure occurs.

```bash
php artisan scripts:run --profile=install --silent --abortOnFailure
```

## Arguments to simple commands

Say we needed to pass an argument to one of the commands, we can use $*, $1, $2, etc.  

```php
'profiles' => [
    'greet' => [
        'Say Hello' => 'echo "Hello $1"',
        'Say Goodbye' => 'echo "Goodbye $*"'
    ]
],
```
```bash
php artisan scripts:run Kyle and George --profile=greet --silent

# This would output:
# Hello Kyle
# Goodbye Kyle and George
```

## More advanced profiles

There are times when you want to be able to create more advanced scripts but to run as part of a series of scripts. 
You can create scripts which extend `Midnite81\Core\CommandScripts\AbstractCommandScript`. The handle method takes care
of running your custom script. The handle method is passed the `FireScriptsCommand $command`, and 
`ExecuteInterface $execute`. The $command allows you access to its public methods and properties, which is useful for
checking if the user wishes the commands to run in silent. For all options see the 
[FireScriptsCommand class](../../src/Commands/Development/FireScriptsCommand.php). The $execute provides wrapped
Execution Commands for the terminal such as `passthru`, `exec` and `system`. 

In this example we're going to upgrade our profile in order to change branches, then run composer install, npm i, and
to finish we're going to run php artisan inspire.

In our profiles section we'll update our profile name with key of `switch-and-install`. Two of the options already look
familiar but now we have our switch branches class there, plus a RunArtisanCommand class. 

```php
'profiles' => [
    'switch-and-install' => [
        \Midnite81\Core\CommandScripts\SwitchBranches::class,
        'Do you want to composer install' => 'composer install',
        'Do you want to run npm install' => 'npm i',
        new \Midnite81\Core\CommandScripts\RunArtisanCommand('inspire')
    ]
],
```

`SwitchBranches` takes advantage of the arguments you can pass when running the script to name the branch name. It 
also take advantage of additional options we can pass to the script, for example we need to know if the branch is a new
branch or an existing one so we'll pass this as an 'extended option' `--option="new"` or since there are no spaces 
`--option=new`. If we need to pass a key pair option, then you can add it with a pipe `--option=color|blue`. The 
SwitchesBranch will pick up the option using the `$command->getExtendedOption('new')` method.

So now we can run 
```bash
php artisan feature/my-new-branch --profile=switch-and-install --option=new 
```

if we needed to pass more than one option we can supply multiple options like this 

```bash
--option=new --option=colour|blue --option=expires|29420
```

## Class based commands

Both extended script classes which inherit from `AbstractCommandScript` and `RunArtisanCommand` have options to 
announce or not to announce before they run using the `shouldAnnounce()` and `shouldNotAnnounce()` methods respectively. 

Equally, you can specify a message for what you want the user to see before running the command using the `withMessage`
method.

```php
'profiles' => [
    'switch-and-install' => [
         (new \Midnite81\Core\CommandScripts\SwitchBranches())->shouldAnnounce()->withMessage('Run switch branches?'),
        'Do you want to composer install' => 'composer install',
        'Do you want to run npm install' => 'npm i',
        (new \Midnite81\Core\CommandScripts\RunArtisanCommand('inspire'))->shouldNotAnnounce()
    ]
],
```

Please note that if using the `--silent` option, any custom script you make will need to make considerations to ensuring
that your script takes account of this. 

## Running artisan commands

As we've seen in the above example, you can run Artisan commands using the `RunArtisanCommand` class, if you need to 
pass arguments or options, you can do this, using the second parameter.

```php
new \Midnite81\Core\CommandScripts\RunArtisanCommand('coffee:make', [
    'type' => 'Americano',
    '--black' => true,
    '--nameOnMug' => 'Midnite'
])
```
