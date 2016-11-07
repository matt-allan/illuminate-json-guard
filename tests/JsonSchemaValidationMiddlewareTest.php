<?php

namespace Yuloh\JsonGuard\Illuminate;

use Illuminate\Http\Request;
use Laravel\Lumen\Application;

class JsonSchemaValidationMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    public function testValidRequest()
    {
        $app = new Application(__DIR__ . '/fixtures');
        $app->register(LumenServiceProvider::class);
        $app->post('/users', ['middleware' => 'json-schema:/definitions/user', function (Request $req) {
            return ['name' => $req->json('name')];
        }]);

        $response = $app->handle(Request::create('/users', 'POST', [], [], [], [], json_encode([
            'name' => 'Matt'
        ])));
        $response = json_decode($response->getContent(), true);
        $this->assertSame(['name' => 'Matt'], $response);
    }

    public function testInvalidRequest()
    {
        $app = new Application(__DIR__ . '/fixtures');
        $app->register(LumenServiceProvider::class);
        $app->post('/users', ['middleware' => 'json-schema:/definitions/user', function (Request $req) {
            return ['name' => $req->json('name')];
        }]);

        $response = $app->handle(Request::create('/users', 'POST', [], [], [], [], json_encode([
            'name' => []
        ])));
        $response = json_decode($response->getContent(), true);
        $this->assertSame('Value [] is not a(n) "string"', $response['errors'][0]['title']);
        $this->assertSame('/name', $response['errors'][0]['source']['pointer']);
        $this->assertSame('[]', $response['errors'][0]['meta']['context']['value']);
        $this->assertSame('"string"', $response['errors'][0]['meta']['context']['type']);
    }
}
