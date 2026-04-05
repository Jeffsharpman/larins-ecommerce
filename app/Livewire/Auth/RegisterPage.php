<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register')]
class RegisterPage extends Component
{
    #[Rule('required|min:2|max:255')]
    public $name;

    #[Rule('required|email|unique:users|email:rfc,dns')]
    public $email;

    #[Rule('required|min:8|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/')]
    public $password;

    public function save()
    {
        $this->validate();

        $key = 'register:'.$this->email;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            session()->flash('error', 'Too many registration attempts. Please try again later.');

            return;
        }

        RateLimiter::hit($key, 60);

        $user = User::create([
            'name' => strip_tags($this->name),
            'email' => strtolower(trim($this->email)),
            'password' => Hash::make($this->password),
        ]);

        $user->notify(new CustomVerifyEmail);

        RateLimiter::clear($key);

        session()->flash('success', 'Registration successful! Please check your email to verify your account.');

        auth()->login($user);

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.register-page')->layout('components.layouts.app');
    }
}
