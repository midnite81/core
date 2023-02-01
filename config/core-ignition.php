<?php

declare(strict_types=1);

use Midnite81\Core\CommandScripts\RunArtisanCommand;

return [
    /*
    |--------------------------------------------------------------------------
    | Script signature names
    |--------------------------------------------------------------------------
    | To avoid any conflicting with other naming conventions, you can specify
    | the name of the FireScriptsCommand and QuickFireScriptCommands.
    |
    */
    'fire-script-command-name' => 'scripts:run',
    'quick-fire-script-command-name' => 'scripts:quick',

    /*
    |--------------------------------------------------------------------------
    | Default setting for Abort on failure
    |--------------------------------------------------------------------------
    | If a script in the sequence fails, should the next scripts continue?
    | If they should, set 'abort-on-failure' to false, however if they
    | should abort on a failed script then set it to true. This is a
    | default setting you can add a flag to turn it on during runtime
    |
    */
    'abort-on-failure' => false,

    /*
    |--------------------------------------------------------------------------
    | Default profile
    |--------------------------------------------------------------------------
    | You can define unlimited number of profiles to use with this command.
    | By providing a default, if you don't specify the profile you wish to
    | run, it will run the default
    |
    */
    'default-profile' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Script Profiles
    |--------------------------------------------------------------------------
    | Here you can set up your profiles of what to run, unless otherwise
    | specified, the user will need to confirm the running of the script.
    | In this array you can specify the question the user will be prompted with
    | and then the command that will be run if they provide a positive response.
    |
    */
    'profiles' => [
        'default' => [
            \Midnite81\Core\CommandScripts\SwitchBranches::class,
            'Do you wish to composer install?' => 'composer install',
            'Do you wish to npm install' => 'npm i',
            'Do you wish to migrate the database' => 'php artisan migrate',
            'Do you wish to compile and watch the application?' => 'vite',
        ],
        'jokes' => [
            'Shall I tell you a joke?' => 'echo "Q. How does a computer get drunk? A. It takes screenshots."'
        ],
        'inspire' => [
            new RunArtisanCommand('inspire'),
        ]
     ],

    /*
    |--------------------------------------------------------------------------
    | Scripts
    |--------------------------------------------------------------------------
    | These are shortcuts to running profiles. The key is the name of the
    | shortcut the array value is the arguments and options sent to the
    | fire scripts command
    |
    */
    'scripts' => [
        'default quiet' => [
            '--profile' => "default",
            '--silent' => '--silent',
            '--abortOnFailure'
        ],
        'jokes' => [
            '--profile' => 'jokes',
        ]
    ]
];
