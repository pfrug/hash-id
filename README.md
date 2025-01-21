
# HashId Laravel Package

A simple trait for Laravel to encode IDs in URLs, providing a secure and obfuscated way to expose model identifiers.

## Installation

To install the package, run the following command:

```bash
composer require pfrug/hash-id
```

### Configuration

To publish the configuration file, use:

```
php artisan vendor:publish --tag="hashid-config"
```

This will create the `hashid.php` configuration file in the `config` directory.

## Usage

1. To use the `HashId` trait, simply include it in your model:

```php
use Pfrug\HashId;

class Post extends Model
{
    use HashId;
}
```

2. **Getting the encoded ID in the route**

In your route model binding, you can now use the encoded ID:

```php
Route::get('/post/{post}', function (Post $post) {
    return $post;
});
```

This will automatically encode the `id` of your model in URLs.

### Regenerate Configuration Values

If you want to regenerate the encoding values for `prime`, `inverse`, and `random`, you can use the following command:

```
php artisan hashid:regenerate
```

This will update the `hashid.php` configuration file with new values.

## Running Tests

To run the tests for the package, use the following command:

```bash
vendor/bin/phpunit --configuration "phpunit.xml" --filter=HashIdTest
```

## License

MIT License
