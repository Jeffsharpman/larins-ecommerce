<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login')]
class LoginPage extends Component
{
    #[Rule('required|email')]
    public $email;

    #[Rule('required|min:5|max:255')]
    public $password;

    public function save()
    {
        $this->validate();

        $key = 'login:'.$this->email;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            session()->flash('error', 'Too many login attempts. Please try again in '.ceil($seconds / 60).' minute(s).');

            return;
        }

        RateLimiter::hit($key, 60);

        $user = User::where('email', $this->email)->first();

        if (! $user) {
            session()->flash('error', 'Invalid credentials');

            return;
        }

        if (! $user->hasVerifiedEmail()) {
            session()->flash('error', 'Please verify your email address first.');

            return;
        }

        if (! auth()->attempt(['email' => $this->email, 'password' => $this->password], true)) {
            session()->flash('error', 'Invalid credentials');

            return;
        }

        RateLimiter::clear($key);

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.login-page')->layout('components.layouts.app');
    }
}
