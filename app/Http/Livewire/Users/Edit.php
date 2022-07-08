<?php

namespace App\Http\Livewire\Users;

use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public User $user;

    public Address $address;

    public $photo;

    public function rules(): array
    {
        return [
            'user.name'       => 'required|string|max:80',
            'user.last_name'  => 'required|string|max:80',
            'user.cpf'        => 'nullable|string|max:14|unique:users,cpf,' . $this->user->id,
            'user.phone'      => 'nullable|string|max:14',
            'user.email'      => 'required|string|max:255|unique:users,email,' . $this->user->id,
            'user.birthday'   => 'required|date',
            'address.country' => 'nullable|string|max:255',
            'address.address' => 'nullable|string|max:255',
            'address.city'    => 'nullable|string|max:255',
            'address.state'   => 'nullable|string|max:255',
            'address.zip'     => 'nullable|string|max:255',
        ];
    }

    protected $validationAttributes = [
        'user.name'       => 'first name',
        'user.last_name'  => 'last name',
        'user.cpf'        => 'CPF',
        'user.phone'      => 'phone number',
        'address.country' => 'country',
        'address.address' => 'address',
        'address.city'    => 'city',
        'address.state'   => 'state',
        'address.zip'     => 'zip'
    ];

    public function mount(): void
    {
        $this->address = $this->user->address;
    }

    public function save(): RedirectResponse|Redirector
    {
        $this->validate();

        $this->user->save();

        $this->user->address()->save($this->address);

        if (isset($this->photo)) {
            $this->user->updateProfilePhoto($this->photo);
        }

        $this->emit('saved');

        return redirect()->route('users');
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
