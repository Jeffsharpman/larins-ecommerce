<?php

namespace App\Livewire\Auth;

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

        if (! auth()->attempt(['email' => $this->email, 'password' => $this->password], true)) {
            session()->flash('error', 'Invalid credentials');

            return;
        }

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.login-page')->layout('components.layouts.app');
    }
}
