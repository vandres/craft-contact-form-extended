# Contact Form Extended

Adds functionality to the Contact Form plugin

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
    'secondsSpentOnForm' => 3, // 0 to disable
];

```

## Roadmap

- simple spam protection via "time spent on form"

## Support my work

PayPal: https://www.paypal.com/donate/?hosted_button_id=3WDU85HZCKMPA

Buy me a coffee: https://buymeacoffee.com/vandres
