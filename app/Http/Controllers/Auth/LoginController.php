<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Socialite;
// use Laravel\Socialite\Facades\Socialite;
use Auth;
// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

/**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        // $user->token;
        $user=User::where('provider_id',$githubUser->getId())->first();

        if(!$user){
            $user=User::create([
                'email'=>$githubUser->getEmail(),
                'name'=>$githubUser->getNickname(),
                'provider_id'=>$githubUser->getId(),
                'avatar'=>$githubUser->avatar,
                'email_verified_at'=>now(),
            ]);
         }   


        Auth::login($user,true);

        return redirect($this->redirectTo);
    }
}
