<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Overrides\DebugResponseFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerValidatorExtensions();
        $this->registerViewExtensions();
    }

    protected function registerValidatorExtensions() {
        Validator::extend('alpha_spaces', function($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);
        });
    }
    protected function registerViewExtensions() {
        View::addExtension('html', 'php');
    }
}
