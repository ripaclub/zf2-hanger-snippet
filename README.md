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
       "ripaclub/zf2-hanger-snippet": "v1.0.0"
   }
}
```

## Setup

**In your layout before the body closing tag**

```php
<?php echo $this->hangerSnippet();?>
```

Optionally, if you need to add more placements:

```php
<?php echo $this->hangerSnippet()->render('placementName');?>
```

## Configuration

```php
return array(
    'hanger_snippet' => array(
        'enable_all' => true, //if not specified true by default
        'snippets' => array(
            'snippet-name' => array(
                'config_key'  => '', //config node in the global config, if any, retrivied data will be merged with values then passed to the template
                'template'    => '', //template script path, if not specified 'hanger-snippet/snippet-name' will be used
                'placement'   => '', //placement identifier, if not specified the default placement will be used
                'enabled'     => true, //if not specified 'enable_all' value will be used
                'values' => array(
                    //other values for the template
                ),
            )
        )
    ),
);
```

## Built-in snippets

### Google Analytics

**Configuration**:

```php
return [
    'ga' => [
        'monitoring_id' => 'UA-XXXXXXXX-X',
        'domain'        => 'yourdomain.com',
        'options' => [
            'siteSpeedSampleRate' => 1,
            'sampleRate' => 100
            // check https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference for more options
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

### Google ReCaptcha 2.0

**Configuration**:

```php
return [
    'g-recaptcha2.0' => [
        'api' => 'https://www.google.com/recaptcha/api.js'
        // Optional API parameters - see https://developers.google.com/recaptcha/docs/display
        'parameters' => [
            'render' => 'onload',
            // 'hl' => '...',
            // 'onload' => '...',
        ],
    ],
    
    'hanger_snippet' => [
        'snippets' => [
            'google-recaptcha2.0' => [
                'config_key' => 'g-recaptcha2.0', // the config node in the global config, if any
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
echo $this->hangerSnippet()->render('google-recaptcha2.0');
```

##### NOTE

The string `google-recaptcha2.0` is the default name of the placement for this snippet (see `module.config.php`).

---

Develop: [![Build Status](https://travis-ci.org/ripaclub/zf2-hanger-snippet.svg?branch=develop)](https://travis-ci.org/ripaclub/zf2-hanger-snippet)

[![Analytics](https://ga-beacon.appspot.com/UA-49655829-1/ripaclub/zf2-hanger-snippet)](https://github.com/igrigorik/ga-beacon)
