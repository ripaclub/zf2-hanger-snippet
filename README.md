# HangerSnippet

[![Travis](https://img.shields.io/travis/ripaclub/zf2-hanger-snippet.svg?style=flat-square)](https://travis-ci.org/ripaclub/zf2-hanger-snippet)
[![Packagist](https://img.shields.io/packagist/v/ripaclub/zf2-hanger-snippet.svg?style=flat-square)](https://packagist.org/packages/ripaclub/zf2-hanger-snippet)
[![License](https://img.shields.io/packagist/l/ripaclub/zf2-hanger-snippet.svg?style=flat-square)](https://github.com/ripaclub/zf2-hanger-snippet/blob/master/LICENSE.txt)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/ripaclub/zf2-hanger-snippet.svg?style=flat-square)](https://scrutinizer-ci.com/g/ripaclub/zf2-hanger-snippet)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/ripaclub/zf2-hanger-snippet.svg?style=flat-square)](https://scrutinizer-ci.com/g/ripaclub/zf2-hanger-snippet)

This ZF2 Module aims to provide a fast way to configure and append code snippeds for JS libraries.

## Rationale

Often happens to have to set up a Javascript library and many times it would be nice to have a place where you can configure them
and perhaps with the ability to override the configuration rather than throw them in the view.

## Installation

### Via Composer
Add `ripaclub/zf2-hanger-snippet` to your composer.json

```json
{
   "require": {
       "ripaclub/zf2-hanger-snippet": "~1.0.6"
   }
}
```

## Setup

**In your layout before the body closing tag**

```php
<?php echo $this->hangerSnippet(); ?>
```

Optionally, if you need to add more placements:

```php
<?php echo $this->hangerSnippet()->render('placementName'); ?>
```

## Configuration

```php
return [
    'hanger_snippet' => [
        'enable_all' => true, //if not specified true by default
        'snippets' => [
            'snippet-name' => [
                'config_key'  => '', // Config node in the global config, if any, retrivied data will be merged with values then passed to the template
                'template'    => '', // Template script path, if not specified 'hanger-snippet/snippet-name' will be used
                'placement'   => '', // Placement identifier, if not specified the default placement will be used
                'enabled'     => true, // When not specified 'enable_all' value will be used
                'values' => [
                    // Other values for the template
                ],
            ],
        ],
    ],
];
```

Do not forget to add **HangerSnippet** module to you `application.config.php` file.

```php
'modules' => [
        // ...
        'HangerSnippet',
        'Application',
],
```

## Built-in snippets

### Google Analytics

**Configuration**:

```php
return [
    'ga' => [
        'monitoring_id' => 'UA-XXXXXXXX-X',
        'domain'        => 'yourdomain.com',
        'anonymize_ip'  => false, // refer to https://developers.google.com/analytics/devguides/collection/analyticsjs/advanced#anonymizeip for more information
        'options' => [
            'siteSpeedSampleRate' => 1,
            'sampleRate' => 100
            // refer to https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference for more options
        ],
    ],

    'hanger_snippet' => [
        'snippets' => [
            'google-analytics' => [
                'config_key' => 'ga', // the config node in the global config, if any
                'values' => [
                    // other values for the template
                ],
            ],
        ],
    ],
];
```

### Facebook JavaScript SDK

**Configuration**:

```php
return [
    'facebook' => [
           'appId' => '...',
    ],

    'hanger_snippet' => [
        'snippets' => [
            'facebook-sdk' => [
                'config_key' => 'facebook', // the config node in the global config, if any
                'values' => [
                    'async' => false,
                    'status' => true,
                    'xfbml'  => true,
                    'version' => 'v2.2',
                ],
            ],
        ],
    ],
];
```

### Google no CAPTCHA reCAPTCHA

**Configuration**:

```php
return [
    'grecaptcha2.0' => [
        'uri' => 'https://www.google.com/recaptcha/api.js'
        // Optional API parameters - see https://developers.google.com/recaptcha/docs/display
        'parameters' => [
            'render' => 'onload',
            // 'hl' => '...',
            // 'onload' => '...',
        ],
    ],
    
    'hanger_snippet' => [
        'snippets' => [
            'google-nocaptcha-recaptcha' => [
                'config_key' => 'grecaptcha2.0', // the config node in the global config, if any
                'values' => [
                    'sitekey' => '',
                    // Optional configurations - see https://developers.google.com/recaptcha/docs/display
                    'theme' => 'light',
                    'type' => 'image',
                    'callback' => '...',
                    'expiredCallback' => '...'
                ],
            ],
        ],
    ],
];
```

The placement of Google ReCaptcha snippet, unlike the others, needs to be specified (it can not be simply appended to the page).

To place this snippet where you need it ...

```php
<?php echo $this->hangerSnippet()->render('google-nocaptcha-recaptcha'); ?>
```

##### NOTE

The string `google-nocaptcha-recaptcha` is the default name of the placement for this snippet (see `module.config.php`).

---

[![Analytics](https://ga-beacon.appspot.com/UA-49657176-3/zf2-hanger-snippet)](https://github.com/igrigorik/ga-beacon)
