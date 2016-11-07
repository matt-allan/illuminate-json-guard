<?php

namespace Yuloh\JsonGuard\Illuminate;

use Illuminate\Http\Request;
use Laravel\Lumen\Application;
use Laravel\Lumen\Routing\Controller;
use Yuloh\JsonGuard\Illuminate\Http\ValidatesJsonRequests;

class ValidatesJsonRequestsTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidRequest()
    {
        $app = new Application(__DIR__ . '/fixtures');
        $app->register(LumenServiceProvider::class);
        $app->post('/users', UsersController::class . '@show');
        $response = $app->handle(Request::create('/users', 'POST', [], [], [], [], json_encode([
            'name' => []
        ])));
        $response = json_decode($response->getContent(), true);
        $this->assertSame('Value [] is not a(n) "string"', $response['errors'][0]['title']);
    }
}

class UsersController extends Controller {

    use ValidatesJsonRequests;

    public function show(Request $req)
    {
        $this->validateJson($req, '/definitions/user');
        return ['name' => $req->json('name')];
    }
}
