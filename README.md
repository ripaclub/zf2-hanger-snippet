# HangerSnippet

This ZF2 Module aims to provide a fast way to configure and append code snippeds for JS libraries.

## Rationale

Often happens to have to set up a Javascript library and many times it would be nice to have a place where you can configure them
and perhaps with the ability to override the configuration rather than throw them in the view.


## Examples

### Google Analytics

**In your configuration**

```php
return array(
    'ga' => array(
        'monitoring_id' => 'UA-XXXXXXXX-X',
        'domain'        => 'yourdomain.com'
     ),

    'hanger_snippet' => array(
        'snippets' => array(
            'google-analytics' => array(
                'config_key' => 'ga', //the config node in the global config, if any
                'values' => array(
                    //other values for the template
                ),
            )
        )
    ),
);
```

### Facebook JavaScript SDK

**In your configuration**

```php
return array(
    'facebook' => array(
           'appId' => '....',
    ),

    'hanger_snippet' => array(
        'snippets' => array(
            'facebook-sdk' => array(
                'config_key' => 'facebook', //the config node in the global config, if any
                'values' => array(
                    'status' => true,
                    'xfbml'  => true,
                ),
            )
        )
    ),
);
```


**In your layout before the body closing tag**

```php
<?php echo $this->hangerSnippet();?>
```
