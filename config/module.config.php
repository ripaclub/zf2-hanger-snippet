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
    'hanger_snippet' => [
        'snippets' => [
            'google-recaptcha-2-0' => [
                'placement' => 'google-recaptcha-2-0',
            ],
        ],
    ],
];
