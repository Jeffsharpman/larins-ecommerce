<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Render Layout
    |---------------------------------------------------------------------------
    */

    'layout' => 'components.layouts.app',

    /*
    |---------------------------------------------------------------------------
    | Livewire Assets
    |---------------------------------------------------------------------------
    */

    'asset_url' => null,
    'app_url' => null,
    'middleware_group' => 'web',

    /*
    |---------------------------------------------------------------------------
    | Temporary File Uploads (This fixes that S3 message you saw)
    |---------------------------------------------------------------------------
    */

    'temporary_file_upload' => [
        'disk' => 'local',        // Change this to 'local' specifically
        'rules' => 'file|max:12288',
        'directory' => null,
        'middleware' => null,
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'jpg', 'jpeg', 'webp',
        ],
    ],
];
