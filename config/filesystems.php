<?php
// this is only required for tests

return [
    'default' => 'local', // or any other disk you prefer
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
        // Other disk configurations go here if needed
    ],
];
