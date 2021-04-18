<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Respect\Validation\Rules as RespectRules;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('cpf', function($attribute, $value, $parameters, $validator) {
            return (new RespectRules\Cpf())->validate($value);
        });

        Validator::extend('cnpj', function($attribute, $value, $parameters, $validator) {
            return (new RespectRules\Cnpj())->validate($value);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
