<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;


use App\Models\Diploma;
use App\Models\Skill;
use App\Models\Category;
use App\Models\Profession;
use App\Models\Role;
use App\Models\Language;
use App\Models\Project;

use App\Observers\SkillObserver;
use App\Observers\DiplomaObserver;
use App\Observers\CategoryObserver;
use App\Observers\RoleObserver;
use App\Observers\ProfessionObserver;
use App\Observers\LanguageObserver;
use App\Observers\ProjectObserver;



class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Skill::observe(SkillObserver::class);
        Diploma::observe(DiplomaObserver::class);
        Category::observe(CategoryObserver::class);
        Role::observe(RoleObserver::class);
        Profession::observe(ProfessionObserver::class);
        Language::observe(LanguageObserver::class);
        Project::observe(ProjectObserver::class);
    }
}
