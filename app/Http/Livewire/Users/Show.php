<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class Show extends Component
{
    public User $user;

    public function render(): View
    {
        return view('livewire.users.show', [
            'user' => $this->user,
        ]);
    }
}
