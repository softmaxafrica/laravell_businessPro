<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        \Log::info('Login request received:', $request->all());

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return $this->redirectAfterLogin();
        }

        return redirect('login')->withErrors('Login details are not valid');
    }

    public function register(Request $request)
    {
        \Log::info('Register request received:', $request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('register')->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return $this->redirectAfterLogin();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }

    // Custom method to redirect after login based on business and stock availability
    private function redirectAfterLogin()
    {
        $user = Auth::user();

        // Check if the user owns any business
        if ($user->business()->exists()) {
            $business = $user->business;

            // Check if there are any stocks associated with the business
            if ($business->stocks()->exists()) {
                return redirect('sales'); // Redirect to sales page if stocks exist
            } else {
                return redirect('stock'); // Redirect to stock management page if no stocks
            }
        } else {
            return redirect('business'); // Redirect to business creation page if no business
        }
    }
}
