# HangerSnippet
[![Build Status](https://travis-ci.org/ripaclub/zf2-hanger-snippet.svg?branch=master)](https://travis-ci.org/ripaclub/zf2-hanger-snippet)
[![Latest Stable Version](https://poser.pugx.org/ripaclub/zf2-hanger-snippet/version.png)](https://packagist.org/packages/ripaclub/zf2-hanger-snippet)
[![License](https://poser.pugx.org/ripaclub/zf2-hanger-snippet/license.png)](https://packagist.org/packages/ripaclub/zf2-hanger-snippet)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ripaclub/zf2-hanger-snippet/badges/quality-score.png?s=49203bee92a5f7076db32e2a5427a97f416a4894)](https://scrutinizer-ci.com/g/ripaclub/zf2-hanger-snippet/)
[![Code Coverage](https://scrutinizer-ci.com/g/ripaclub/zf2-hanger-snippet/badges/coverage.png?s=60b6fe5e6c6ce65ddc23ecd98cf9e8c988fc4f1f)](https://scrutinizer-ci.com/g/ripaclub/zf2-hanger-snippet/)

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

**In your configuration**

```php
return array(
    'ga' => array(
        'monitoring_id' => 'UA-XXXXXXXX-X',
        'domain'        => 'yourdomain.com',
        'options' => [
            'siteSpeedSampleRate' => 1,
            'sampleRate' => 100
            //check https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference for more options
        ]
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
                    'async' => false,
                    'status' => true,
                    'xfbml'  => true,
                    'version' => 'v2.2',
                ),
            )
        )
    ),
);
```


Develop: [![Build Status](https://travis-ci.org/ripaclub/zf2-hanger-snippet.svg?branch=develop)](https://travis-ci.org/ripaclub/zf2-hanger-snippet)

[![Analytics](https://ga-beacon.appspot.com/UA-49655829-1/ripaclub/zf2-hanger-snippet)](https://github.com/igrigorik/ga-beacon)
