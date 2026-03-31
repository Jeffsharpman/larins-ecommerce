<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Forgot Password')]
class ForgetPage extends Component
{
    #[Rule('required|email|exists:users,email|max:255')]
    public $email;

    public function save()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Password reset link has been sent to your email address');
            $this->email = '';
            // No redirect needed here, Livewire will stay on page and show the flash
        } else {
            // Handle cases where email doesn't exist or link can't be sent
            $this->addError('email', __($status));
        }
    }

    public function render()
    {
        return view('livewire.auth.forget-page')->layout('components.layouts.app');
    }
}
