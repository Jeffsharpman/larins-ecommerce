<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register')]
class RegisterPage extends Component
{
    #[Rule('required|min:5|max:255')]
    public $name;

    #[Rule('required|email|unique:users')]
    public $email;

    #[Rule('required|min:5|max:255')]
    public $password;

    public function save()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        auth()->login($user);

        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.register-page')->layout('components.layouts.app');
    }
}
