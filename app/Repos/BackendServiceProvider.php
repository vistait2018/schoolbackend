<?php
namespace App\Repos;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'App\Repo\IUser',
            'App\Repos\UserRepo'
        );
        $this->app->bind(
            'App\Repo\IRole',
            'App\Repos\RoleRepo'
              );
        $this->app->bind(
            'App\Repo\ISchool',
            'App\Repos\SchoolRepo'
        );
        $this->app->bind(
            'App\iRepo\iTerm',
            'App\Repos\MyTermRepo'
        );
        $this->app->bind(
            'App\iRepo\ISchoolSession',
            'App\Repos\SchoolSessionRepo'
        );
        $this->app->bind(
            'App\iRepo\IUser',
            'App\Repos\UserRepo'
        );
        $this->app->bind(
            'App\iRepo\IDepartment',
            'App\Repos\DepartmentRepo'
        );
        $this->app->bind(
            'App\iRepo\ICategory',
            'App\Repos\CategoryRepo'
        );

        $this->app->bind(
            'App\iRepo\ISchoolClass',
            'App\Repos\ISchoolClassRepo'
        );
    }
}