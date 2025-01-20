
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

class User extends Authenticatable
{
    use HashId;
}
```

2. **Getting the encoded ID in the route**

In your route model binding, you can now use the encoded ID:

```php
Route::get('/user/{user}', function (User $user) {
    return $user;
});
```

This will automatically encode the `id` of your model in URLs.

### Regenerate Configuration Values

If you want to regenerate the encoding values for `prime`, `inverse`, and `random`, you can use the following command:

```
php artisan hashid:regenerate
```

This will update the `hashid.php` configuration file with new values.

## License

MIT License
