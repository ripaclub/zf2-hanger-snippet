# ZF2 Js Appender

This ZF2 Module aims to provide a fast way to configure Javascript libraries.

## Rationale

Often happens to have to set up a Javascript library and many times it would be nice to have a place where you can configure them
and perhaps with the ability to override the configuration rather than throw them in the view.


```
return array(
    'zf2_js_appender' => array(
        'fb' => array(
            'type'   => 'facebook-sdk',
            'values' => array(
                'apikey' => '123'
            ),
        )

    ),
);
```