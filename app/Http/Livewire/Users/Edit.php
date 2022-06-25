<?php

namespace App\Http\Livewire\Users;

use App\Models\Addresses;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public User $user;
    public Addresses $address;

    protected array $rules = [
        'user.name' => 'required|string|max:80',
        'user.last_name' => 'required|string|max:80',
        'user.cpf' => 'required|string|size:11',
        'user.email' => 'required|string|max:255',
        'user.birthday' => 'required|date',
        'user.address.address' => 'required|string|max:255',
        'user.address.city' => 'required|string|max:255',
        'user.address.state' => 'required|string|max:255',
        'user.address.zip' => 'required|string|max:255',

    ];

    public function mount()
    {
        $this->address = $this->user->address;
    }

    public function save()
    {
        $this->validate();

        $this->user->save();
    }

    public function render()
    {
        return view('livewire.users.edit', [
            'user' => $this->user,
        ]);
    }
}
