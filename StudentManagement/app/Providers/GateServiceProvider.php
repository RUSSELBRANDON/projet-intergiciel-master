<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Gate;

class GateServiceProvider extends AuthServiceProvider
{
    public function boot()
    {
        $this->defineGates();
    }
    
    protected function defineGates()
    {
        Gate::define('isAdmin', function ($user) {
            return $user['role'] == 'admin';
        });
        
        Gate::define('isTeacher', function ($user) {
            return $user['role'] == 'teacher';
        });
    }
}
