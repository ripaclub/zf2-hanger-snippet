# ZF2 Js Appender

This ZF2 Module aims to provide a fast way to configure code snippeds for JS libraries and more.

## Rationale

Often happens to have to set up a Javascript library and many times it would be nice to have a place where you can configure them
and perhaps with the ability to override the configuration rather than throw them in the view.


## Examples

### Google Analytics

**In your configuration**

```php
return array(
    'google-analytics' => array(
   		'monitoring_id' => 'UA-XXXXXXXX-X',
        'domain'        => 'yourdomain.com'
    ),

    'hanger-snippet' => array(
        'google-analytics' => array(
        	'config_key' => 'google-analytics', //the config node in the global config
            'values' => array(
                //other values for the template
            ),
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

    'hanger-snippet' => array(
        'facebook-sdk' => array(
        	'config_key' => 'facebook', //the config node in the global config
            'values' => array(
                'status' => true,
                'xfbml   => true,
            ),
        )

    ),
);
```


**In your layout before the body closing tag**

```php
<?php echo $this->hangerSnippet();?>
```