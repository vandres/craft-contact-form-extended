# Development

## `composer.json`

```json
"require": {
  "vandres/craft-contact-form-extended": "*",
}
```
```json
"minimum-stability": "dev",
```
```json
"repositories": [
    {
        "type": "path",
        "url": "plugins/contact-form-extended"
    },
    {
        "type": "composer",
        "url": "https://composer.craftcms.com",
        "canonical": false
    }
]
```

## `.env`

```php
# Plugin development
VANDRES_PLUGIN_DEVSERVER=1
```
