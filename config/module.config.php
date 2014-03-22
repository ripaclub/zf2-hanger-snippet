<?php

return [
    'view_helpers' => [
        'factories' => [
            'hangerSnippet' => 'HangerSnippet\Service\SnippetHelperServiceFactory'
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'hanger-snippet' => __DIR__ . '/../view',
        ],
    ],
];
