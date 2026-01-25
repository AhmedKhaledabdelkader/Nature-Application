<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Repositories\Contracts\AwardRepositoryInterface;
use App\Repositories\Contracts\CityRepositoryInterface;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\ClientSectionRepositoryInterface;
use App\Repositories\Contracts\CountryRepositoryInterface;
use App\Repositories\Contracts\ProjectMetricRepositoryInterface;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Repositories\Contracts\ProvidedServiceRepositoryInterface;
use App\Repositories\Contracts\SectionRepositoryInterface;
use App\Repositories\Contracts\ServiceV2RepositoryInterface;
use App\Repositories\Contracts\SponsorRepositoryInterface;
use App\Repositories\Contracts\StepRepositoryInterface;
use App\Repositories\Contracts\TestimonialRepositoryInterface;
use App\Repositories\Contracts\TestimonialSectionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquents\AwardRepository;
use App\Repositories\Eloquents\CityRepository;
use App\Repositories\Eloquents\ClientRepository;
use App\Repositories\Eloquents\ClientSectionRepository;
use App\Repositories\Eloquents\CountryRepository;
use App\Repositories\Eloquents\ProjectMetricRepository;
use App\Repositories\Eloquents\ProjectRepository;
use App\Repositories\Eloquents\ProvidedServiceRepository;
use App\Repositories\Eloquents\SectionRepository;
use App\Repositories\Eloquents\ServiceV2Repository;
use App\Repositories\Eloquents\SponsorRepository;
use App\Repositories\Eloquents\StepRepository;
use App\Repositories\Eloquents\TestimonialRepository;
use App\Repositories\Eloquents\TestimonialSectionRepository;
use App\Repositories\Eloquents\UserRepository;
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


 $this->app->bind(
    StepRepositoryInterface::class,
    StepRepository::class
);



 $this->app->bind(
    UserRepositoryInterface::class,
    UserRepository::class
);


$this->app->bind(
    TestimonialRepositoryInterface::class,
    TestimonialRepository::class
);



$this->app->bind(
    ProjectMetricRepositoryInterface::class,
    ProjectMetricRepository::class
);


$this->app->bind(
    ClientSectionRepositoryInterface::class,
    ClientSectionRepository::class
);

$this->app->bind(
    TestimonialSectionRepositoryInterface::class,
    TestimonialSectionRepository::class
);


$this->app->bind(
    ServiceV2RepositoryInterface::class,
    ServiceV2Repository::class
);


$this->app->bind(
    SectionRepositoryInterface::class,
    SectionRepository::class
);


        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
           User::observe(UserObserver::class);


    }
}
