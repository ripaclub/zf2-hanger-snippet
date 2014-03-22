<?php

return [
    'view_helpers' => [
        'invokables' => [
            'js_appender' => 'ZF2JsAppender\View\Helper\AppenderHelper'
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'zf2_js_appender' => __DIR__ . '/../view',
        ],
    ],
];
