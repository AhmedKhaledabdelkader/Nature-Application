<?php

namespace App\Providers;

use App\Repositories\Contracts\AwardRepositoryInterface;
use App\Repositories\Contracts\CityRepositoryInterface;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\CountryRepositoryInterface;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Repositories\Contracts\ProvidedServiceRepositoryInterface;
use App\Repositories\Contracts\SponsorRepositoryInterface;
use App\Repositories\Eloquents\AwardRepository;
use App\Repositories\Eloquents\CityRepository;
use App\Repositories\Eloquents\ClientRepository;
use App\Repositories\Eloquents\CountryRepository;
use App\Repositories\Eloquents\ProjectRepository;
use App\Repositories\Eloquents\ProvidedServiceRepository;
use App\Repositories\Eloquents\SponsorRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    $this->app->bind(
    AwardRepositoryInterface::class,
    AwardRepository::class
);



    $this->app->bind(
    CityRepositoryInterface::class,
    CityRepository::class
);



    $this->app->bind(
    ClientRepositoryInterface::class,
    ClientRepository::class
);



    $this->app->bind(
    CountryRepositoryInterface::class,
    CountryRepository::class
);



    $this->app->bind(
    SponsorRepositoryInterface::class,
    SponsorRepository::class
);


 $this->app->bind(
    ProvidedServiceRepositoryInterface::class,
    ProvidedServiceRepository::class
);



 $this->app->bind(
    ProjectRepositoryInterface::class,
    ProjectRepository::class
);






        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
