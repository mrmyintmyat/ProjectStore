<?php
namespace App\Providers;

use App\Auth\PhonePasswordBroker;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Password;

class AuthServiceProvider extends ServiceProvider
{
    // ...

    public function boot()
    {
        $this->registerPasswordBroker();
    }

    protected function registerPasswordBroker()
    {
        Password::broker('users', function ($app) {
            return new PhonePasswordBroker(
                $app->make('auth.password.tokens'),
                $app->make('mailer'),
                $app->make('view'),
                $app->make('translator')
            );
        });
    }

    // ...
}
