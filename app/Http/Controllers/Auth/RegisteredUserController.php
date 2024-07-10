<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;



class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($request->password),
            'role' => 'customer'
        ]);

        try {
            event(new Registered($user));

            Auth::login($user);

            $this->syncUserCart($request);
            return redirect(RouteServiceProvider::HOME)->withCookie(cookie('products', '', -1));
        } catch (\Swift_TransportException $e) {
            dd($e);
        }
    }

    private function syncUserCart(Request $request)
    {
        $cart = json_decode($request->cookie('products'), true);
        if (!$cart)
            return;

        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $userCart = $user->carts()->firstOrCreate(['status' => 'N']);
        foreach ($cart as $id => $quantity) {
            $userCart->products()->attach($id, ['quantity' => $quantity, 'discount' => 0]);
        }
    }


    public function create_vendor()
    {
        return view('auth.register_vendor');
    }

    public function store_vendor(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'intro' => ['nullable','string', 'max:255'],
            'mobile' => ['required', 'string', 'max:15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'intro' => $validated['intro'] ?? '',
            'mobile' => $validated['mobile'],
            'password' => Hash::make($request->password),
            'role' => 'vendor',
            'admin' => 1
        ]);

        try {
            event(new Registered($user));

            Auth::login($user);

            $this->syncUserCart($request);
            return redirect(RouteServiceProvider::HOME)->withCookie(cookie('products', '', -1));
        } catch (\Swift_TransportException $e) {
            dd($e);
        }
    }
}
