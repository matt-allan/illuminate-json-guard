# Json Schema Validation For Laravel And Lumen

Laravel/Lumen integration for league/json-guard.

This package is experimental and could break at any time.

## Install

Via Composer

``` bash
$ composer require yuloh/illuminate-json-guard
```

### Register The Service Provider

Add the following line to `app/boostrap.php`:

```php
$app->register(Yuloh\JsonGuard\Illuminate\LumenServiceProvider::class);
```

### Publish The Config File

As Lumen does not ship with a publish command, you will have to copy the config file manually.

```bash
cp ./vendor/league/illuminate-json-guard/config/json-guard.php ./config/json-guard.php
```

## Usage

### Controller Validation

You can use the provided `ValidatesJsonRequests` trait to easily validate requests against a JSON Schema.

The trait provides a `validateJson` method.  Simply call the method with the current request and the name of the schema you would like to use, and the request body will be validated against the schema.

if validation fails, the method will throw a `JsonSchemaValidationException`.  The exception will be converted into a JSON response will all of the relevant error messages.

``` php
use Yuloh\JsonGuard\Illuminate\Http\ValidatesJsonRequests;

class UsersController extends Controller
{
    use ValidatesJsonRequests;

    public function show(Request $request, int $id)
    {
        $this->validateJson($request, 'user.json');
        
        return User::find($id);
    }
}
```

### Route Middleware

A route middleware is also included.  The route middleware takes the name of the schema you would like to use the as the only parameter.  If validation fails the middleware will return a JSON response of the errors instead of passing through to your handler.

```php
$app->post('/users', ['middleware' => 'json-schema:user.json', function () {
    // 
}]);
```

### Loading Schemas

@todo

### Localization

@todo

### Customizing The Error Response

@todo

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
