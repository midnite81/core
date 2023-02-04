# Commands

midnite81/core ships with a number of useful laravel artisan commands. By default, they are not auto included to
prevent additional commands being added in to the application. However, a commands service provider has been added to
this package which you can register in your `config/app.php` file under the `providers` array.

```php
'providers' => [
//   ...
    \Midnite81\Core\CoreCommandServiceProvider::class,
//   ...
]
```

## Available Artisan Commands

| Command                                                                  | Signature       | Description                                               |
|--------------------------------------------------------------------------|-----------------|-----------------------------------------------------------|
| [BackupDatabase](Commands/BackupDatabase.md)                             | database:backup | Backups the a mysql database                              |
| [FireScriptsCommand](Commands/FireScriptsCommand.md)                     | run:scripts*    | Runs sequential command line, artisan and bespoke scripts |
| [QuickFireScriptCommand](Commands/QuickFireScriptsCommand.md)            | run:quick*      | Offers a quick way to run the run:scripts command         |
| [ChangeEnvironmentVariable](Commands/ChangeEnvironmentVariable.md)       | env:set         | Changes an env value                                      |
| [CreateBlankCopyOfEnvironment](Commands/CreateBlankCopyOfEnvironment.md) | env:copy        | Creates a blank copy of the .env file                     |
| [GetEnvironmentVariable](Commands/GetEnvironmentVariable.md)             | env:get         | Gets the value of an env key                              |                              

*signature depends on configuration settings
