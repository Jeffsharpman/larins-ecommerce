<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Reset Password')]
class ResetPage extends Component
{
    #[Rule('required|email')]
    public $email;

    #[Rule('required|min:5|max:255|confirmed')]
    public $password;

    public $password_confirmation;

    #[Rule('required')]
    public $token;

    public function mount($token)
    {
        $this->token = $token;
        // Tip: Auto-fill email if it's in the URL
        $this->email = request()->query('email');
    }

    public function save()
    {
        $this->validate();

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password), // Removed the semicolon from inside here
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user)); // Added the semicolon here
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('success', 'Password reset successfully.');

            return redirect('/login');
        }

        // Using __($status) translates the error (e.g., "This password reset token is invalid.")
        session()->flash('error', __($status));
    }

    public function render()
    {
        return view('livewire.auth.reset-page')->layout('components.layouts.app');
    }
}
