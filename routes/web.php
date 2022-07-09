<?php

use App\Http\Livewire\Users\Create;
use App\Http\Livewire\Users\Edit;
use App\Http\Livewire\Users\Index;
use App\Http\Livewire\Users\Show;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login/{driver}/redirect', function ($driver) {

    Validator::validate(compact('driver'), ['driver' => 'required|in:google,github']);

    return Socialite::driver($driver)->redirect();

})->name('login.social.redirect');


Route::get('/auth/{driver}/callback', function ($driver) {
    $socialiteUser = Socialite::driver($driver)->stateless()->user();

    $user = User::query()->firstOrCreate(['email' => $socialiteUser->email], [
        'name' => $socialiteUser->name,
        'last_name' => $driver == 'google' ? $socialiteUser->user['family_name'] : '',
        'password' => Hash::make(Str::random(8)),
    ]);

    if ($user->wasRecentlyCreated) {
        Address::query()->create([
            'user_id' => $user->id
        ]);
    }

    auth()->login($user);

    return redirect()->route('dashboard');

});

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/users', Index::class)->name('users');
    Route::get('/users/create', Create::class)->name('users.create');
    Route::get('/users/edit/{user}', Edit::class)->name('users.edit');
    Route::get('/users/{user}', Show::class)->name('users.show');
});
