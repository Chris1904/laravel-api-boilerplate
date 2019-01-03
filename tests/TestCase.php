<?php

namespace Tests;

use App\Models\Store;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Assert;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    protected $user = null;
    protected $headers = ['Accept' => 'application/json'];
    protected $baseUrl = 'http://localhost';

    public function setUp()
    {
        parent::setUp();

        TestResponse::macro('assertValidationErrors', function($field) {
            return Assert::assertArrayHasKey($field, $this->decodeResponseJson()['error']['errors']);
        });

        TestResponse::macro('assertJsonHasStatus', function($status) {
            return Assert::assertEquals($status, $this->decodeResponseJson()['error']['status_code']);
        });
    }

    public function signIn($user = null)
    {
        if(is_null($user)) {
            $user = factory('App\Models\User')->create();
        }

        $this->user = $user;

        $token = JWTAuth::fromUser($this->user);
        $this->headers['Authorization'] = 'Bearer '.$token;
        JWTAuth::setToken($token);
        Auth::login($user);

        return $this;
    }

    public function getException($response)
    {
        dd(json_decode($response->getContent(), true)['error']);
    }
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Create store user.
     *
     * @return \App\Models\User
     */
    public function createUser($permission = null)
    {
        $store = factory(Store::class)->create();
        $user = $store->owner;
        $user->fill(['store_id' => $store->id])
            ->save();

        if ($permission) {
            $user->givePermissionTo($permission);
        }

        return $user;
    }
}
