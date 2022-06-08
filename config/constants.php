<?php

return [
    'company' => [
        'name' => 'kapkara',
        'logo' => 'kapkara.svg',
        'link' => 'https://kapkara.one',
        'motto' => 'simplicity in action',
        'title' => 'web technologies | design house',
    ],

    'app' => [
        'name' => 'k-library',
        'title' => 'Personal Digital Library',
        'welcome_header' => 'Personal Digital Library - PDL',
        'welcome_subtitle' => 'Private, Only for You',
        'description' => 'Description here',
        'app_header_logo' => 'app_header_logo.svg',
        'app_footer_logo' => 'app_footer_logo.svg',
        'version' => '2022.04.08',
        'copyright' => '© 2022 All Rights Reserved',
    ],

    'favicon' => '/images/tensor_favicon.svg',

    'icons' => [
        'size' => '24',
        'color' => [
            'light' => 'hsl(0, 0%, 100%)',
            'dark' => 'hsl(0, 0%, 4%)',
            'active' => 'hsl(217, 71%, 53%)',
            'inactive' => 'hsl(0, 0%, 71%)',
            'danger' => 'hsl(348, 86%, 43%)',
        ],
    ],

    'thumbnail' => [
        'max_dimension' => 200,
    ],

    'table' => [
        'cols_per_row' => 5,
        'no_of_results' => 6,
        'no_of_thumbnails' => 20,
    ],

    'asset_types' => [
        [
            'title' => 'Images-Pictures',
            'type' => 'image',
            'image' => 'type_image.svg',
            'hilight' => false,
        ],
        [
            'title' => 'Videos-Movies',
            'type' => 'video',
            'image' => 'type_video.svg',
            'hilight' => false,
        ],

        [
            'title' => 'Music',
            'type' => 'music',
            'image' => 'type_music.svg',
            'hilight' => false,
        ],

        [
            'title' => 'Books',
            'type' => 'book',
            'image' => 'type_book.svg',
            'hilight' => false,
        ],

        [
            'title' => 'Other - Any Type',
            'type' => 'file',
            'image' => 'type_file.svg',
            'hilight' => false,
        ],
    ],
];
