# Contact Form Extended

Adds functionality to the Contact Form plugin.

## Feature Overview

- adds an additional simple spam check
  - it checks the time spent on a form
  - configure your logging

## Requirements

This plugin requires Craft CMS 5.1.0 or later, and PHP 8.2 or later.

## Installation

You can install this plugin from the Plugin Store or with Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel and search for “Contact Form Extended”. Then press “Install”.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require vandres/craft-contact-form-extended

# tell Craft to install the plugin
./craft plugin/install contact-form-extended
```

## Configuration

You can use the settings dialog in the control panel. But I would recommend creating a `contact-form-extended.php` in your config folder.

```php
return [
    'secondsSpentOnFormThreshold' => 3, // 0 to disable
    'logSpam' => false,
    'logAll' => false,
];

```

## Usage

Just add the following `prepareSubmission()` call somewhere in the form template. Example:

```twig
<form sprig s-method="post" s-action="contact-form/send" accept-charset="UTF-8">
    {# prepare form submission check #}
    {{ craft.form.service.prepareSubmission() }} 
    {{ hiddenInput('fromName', title ) }}

    {% if page is defined and page %}
        {{ redirectInput(page.url) }}
    {% endif %}
</form>
```

If you forget that call, all submissions might be marked as spam!

### Edge Case

If you cache the contact form, the `prepareSubmission()` might not be called and the form would misbehave.

This is out of the scope of this plugin. I would recommend not caching contact forms or using some kind of AJAX solution. My preference is a combination of the plugins "No-Cache" and "Sprig".

## Roadmap

- ~~simple spam protection via "time spent on form"~~
- ~~write filtered submissions to log (configurable)~~ 

## Support my work

PayPal: https://www.paypal.com/donate/?hosted_button_id=3WDU85HZCKMPA

Buy me a coffee: https://buymeacoffee.com/vandres

## Supporter

1. [Ambition Creative](https://www.ambitioncreative.co.uk/): Icons
