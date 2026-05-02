<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        if (Session::get('authenticated')) {
            return $this->redirectByRole();
        }
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check database users
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password) && $user->status === 'active') {
            // Store user data in session
            Session::put('user', [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'role' => $user->role,
                'phone' => $user->phone,
                'status' => $user->status,
                'created_at' => $user->created_at->format('M d, Y'),
                'updated_at' => $user->updated_at->format('M d, Y \a\t g:i A'),
            ]);
            
            Session::put('authenticated', true);
            
            return $this->redirectByRole();
        }

        return back()->withErrors([
            'email' => 'Invalid credentials or account is inactive.',
        ])->onlyInput('email');
    }

    /**
     * Redirect user based on their role
     */
    public function redirectByRole()
    {
        $user = Session::get('user');
        
        if (!$user) {
            return redirect('/login');
        }

        switch ($user['role']) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'supervisor':
                return redirect('/supervisor/dashboard');
            case 'housekeeper':
                return redirect('/housekeeper/dashboard');
            default:
                return redirect('/login');
        }
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Session::flush();
        return redirect('/login')->with('success', 'Logged out successfully');
    }
}
