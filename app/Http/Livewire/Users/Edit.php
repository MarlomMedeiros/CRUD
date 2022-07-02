<?php

namespace App\Http\Livewire\Users;

use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public User $user;

    public Address $address;

    public $photo;

    protected array $rules = [
        'user.name' => 'required|string|max:80',
        'user.last_name' => 'required|string|max:80',
        'user.cpf' => 'nullable|string|unique:users,cpf|max:14',
        'user.phone' => 'nullable|string|max:14',
        'user.email' => 'required|string|unique:users,email|max:255',
        'user.birthday' => 'required|date',
        'user.address.country' => 'nullable|string|max:255',
        'user.address.address' => 'nullable|string|max:255',
        'user.address.city' => 'nullable|string|max:255',
        'user.address.state' => 'nullable|string|max:255',
        'user.address.zip' => 'nullable|string|max:255',
    ];
    protected $validationAttributes = [
        'user.name' => 'first name',
        'user.last_name' => 'last name',
        'user.cpf' => 'CPF',
        'user.phone' => 'phone number',
        'user.address.country' => 'country',
        'user.address.address' => 'address',
        'user.address.city' => 'city',
        'user.address.state' => 'state',
        'user.address.zip' => 'zip'
    ];

    public function mount(): void
    {
        $this->address = $this->user->address;
    }

    public function save(): void
    {
        $this->validate();

        $this->user->save();

        $this->user->address->save();

        if (isset($this->photo)) {
            $this->user->updateProfilePhoto($this->photo);
        }

        $this->emit('saved');
    }

    public function deleteProfilePhoto(): void
    {
        $this->user->deleteProfilePhoto();
    }

    public function render(): View
    {
        return view('livewire.users.edit', [
            'user' => $this->user,
        ]);
    }
}
