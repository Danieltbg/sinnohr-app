<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Http\Responses\FilamentLoginResponse;
use App\Models\ActivityPlan;
use App\Models\EmployeeConfigurationEntry;
use App\Models\EmployeeSkill;
use App\Models\MasterDepartment;
use App\Models\MasterTeam;
use App\Models\RecruitmentApplicant;
use App\Models\RecruitmentCandidate;
use App\Models\RecruitmentJobPosition;
use App\Models\Role;
use App\Models\SettingsCompany;
use App\Models\SettingsCustomField;
use App\Models\User;
use App\Policies\ActivityPlanPolicy;
use App\Policies\EmployeeConfigurationEntryPolicy;
use App\Policies\EmployeeSkillPolicy;
use App\Policies\MasterDepartmentPolicy;
use App\Policies\MasterTeamPolicy;
use App\Policies\RecruitmentApplicantPolicy;
use App\Policies\RecruitmentCandidatePolicy;
use App\Policies\RecruitmentJobPositionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SettingsCompanyPolicy;
use App\Policies\SettingsCustomFieldPolicy;
use App\Policies\UserPolicy;
use Filament\Auth\Http\Responses\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginResponseContract::class, FilamentLoginResponse::class);

        $this->app->bind(Authenticatable::class, User::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Web requests only — do not cap CLI daemons such as `artisan serve`.
        if ($this->app->environment('local') && ! $this->app->runningInConsole()) {
            ini_set('max_execution_time', '120');
        }

        JsonResource::withoutWrapping();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(MasterDepartment::class, MasterDepartmentPolicy::class);
        Gate::policy(EmployeeSkill::class, EmployeeSkillPolicy::class);
        Gate::policy(ActivityPlan::class, ActivityPlanPolicy::class);
        Gate::policy(EmployeeConfigurationEntry::class, EmployeeConfigurationEntryPolicy::class);
        Gate::policy(RecruitmentJobPosition::class, RecruitmentJobPositionPolicy::class);
        Gate::policy(RecruitmentApplicant::class, RecruitmentApplicantPolicy::class);
        Gate::policy(RecruitmentCandidate::class, RecruitmentCandidatePolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(SettingsCompany::class, SettingsCompanyPolicy::class);
        Gate::policy(SettingsCustomField::class, SettingsCustomFieldPolicy::class);
        Gate::policy(MasterTeam::class, MasterTeamPolicy::class);
    }
}
