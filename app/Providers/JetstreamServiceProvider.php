<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    //check user email, password and allow only type doctor login
//         Fortify::authenticateUsing(function(Request $request) {
//             $user = User::where('email', $request->email)->first();
//             if($user && Hash::check($request->password, $user->password) && $user->type == 'doctor'){
//                 return $user;
//             }
//         });
            Fortify::authenticateUsing(function(LoginRequest $request) {
                $user = User::where('email', $request->email)->first();

                if (!$user || !Hash::check($request->password, $user->password)) {
                    return null; // Return null if user not found or password does not match
                }

                if ($user->type !== 'doctor') {
                    return null; // Return null if user type is not 'doctor'
                }

                return $user; // Return the authenticated user
            });

        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
