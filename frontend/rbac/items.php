<?php
return [
    'tracker' => [
        'type' => 2,
        'description' => 'Add tracker data',
    ],
    'bulletins' => [
        'type' => 2,
        'description' => 'Manage Bulletins',
    ],
    'cal' => [
        'type' => 2,
        'description' => 'Manage Callender Events',
    ],
    'adminrole' => [
        'type' => 2,
        'description' => 'Admin role',
    ],
    'teacher' => [
        'type' => 1,
        'children' => [
            'tracker',
        ],
    ],
    'extendedteacher' => [
        'type' => 1,
        'children' => [
            'tracker',
            'cal',
            'bulletins',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'tracker',
            'cal',
            'bulletins',
            'adminrole',
        ],
    ],
];
