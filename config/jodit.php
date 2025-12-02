<?php

return [
    'need_auth' => env('JODIT_FILE_BROWSER_NEED_AUTH', true),

    /*
     * Relative path to filebrowser directory
     */
    'root' => env('JODIT_FILE_BROWSER_ROOT', 'filebrowser'),

    /*
     * Root directory name, without spaces
     */
    'root_name' => env('JODIT_FILE_BROWSER_ROOT_NAME', 'default'),

    /*
     * digits after decimal point in file size
     */
    'file_size_accuracy' => env('JODIT_FILE_BROWSER_FILE_SIZE_ACCURACY', 3),

    /*
     * Allowed to upload Image types
     */
    'mimetypes' => [
        'images' => [
            'jpeg',
            'jpg',
            'gif',
            'png',
            'bmp',
            'svg'
        ]
    ],

    'thumb' => [
        'dir_url' => env('JODIT_THUMB_DIR_URL', env('APP_URL') . '/assets/images/jodit/'),

        'mask' => env('JODIT_THUMB_MASK', 'thumb-%s.svg'),

        'unknown_extension' => env('JODIT_THUMB_UNKNOWN_EXTENSION', 'thumb-unknown.svg'),

        /*
         * In case the icons are located on another server
         */
        'exists' => explode(
            ',',
            env('JODIT_THUMB_EXTENSION_EXISTS', '')
        ),

    ],

    'auth_token_parameter' => env('JODIT_FILE_BROWSER_AUTH_TOKEN_PARAMETER', 'access_token'),

    /*
     * Directory nesting limit
     */
    'nesting_limit' => env('JODIT_FILE_BROWSER_NESTING_LIMIT', 3),

    /*
     * List of file types that jodit editor renames on upload
     */
    'jodit_broken_extension' => explode(
        ',',
        env('JODIT_BROKEN_EXTENSION', 'vnd,plain,msword')
    ),

    'cache' => [
        'key' => env('JODIT_FILE_BROWSER_CACHE_KEY', 'filebrowser'),

        'duration' => env('JODIT_FILE_BROWSER_CACHE_DURATION', 3600),
    ],

    'middlewares' => [
        Do6po\LaravelJodit\Http\Middleware\JoditAuthMiddleware::class
    ],

    'routes' => [
        'middleware' => env('JODIT_FILE_BROWSER_MIDDLEWARE', 'api'),

        'prefix' => env('JODIT_FILE_BROWSER_PATH_PREFIX'),

        'upload_path' => env('JODIT_FILE_BROWSER_UPLOAD_PATH', 'jodit/upload'),
        'browse_path' => env('JODIT_FILE_BROWSER_BROWSE_PATH', 'jodit/browse'),

        'upload_name' => env('JODIT_FILE_BROWSER_UPLOAD_ROUTE_NAME', 'jodit.upload'),
        'browse_name' => env('JODIT_FILE_BROWSER_BROWSE_ROUTE_NAME', 'jodit.browse'),

    ],

    'upload_actions' => [
        Do6po\LaravelJodit\Actions\FileUploadAction::class,
    ],

    'file_actions' => [
        Do6po\LaravelJodit\Actions\Files::class,
        Do6po\LaravelJodit\Actions\FileRename::class,
        Do6po\LaravelJodit\Actions\FileMove::class,
        Do6po\LaravelJodit\Actions\FileRemove::class,
        Do6po\LaravelJodit\Actions\Folders::class,
        Do6po\LaravelJodit\Actions\FolderCreate::class,
        Do6po\LaravelJodit\Actions\FolderMove::class,
        Do6po\LaravelJodit\Actions\FolderRemove::class,
        Do6po\LaravelJodit\Actions\FolderRename::class,
        Do6po\LaravelJodit\Actions\Permissions::class,
    ],
];
