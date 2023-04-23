<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //Email Verification
//         $this->registerPolicies();
//    Verify Email for API
//        VerifyEmail::createUrlUsing(function ($notifiable) {
//            return url('/api/email/verify/' . $notifiable->getKey() . '/' . sha1($notifiable->getEmailForVerification()));
//        });
//        VerifyEmail::toMailUsing(function ($notifiable, $url) {
//            return (new MailMessage)
//                ->subject('Verify Email Address')
//                ->line('Please click the button below to verify your email address.')
//                ->action('Verify Email Address', $url);
//        });
    }
}
