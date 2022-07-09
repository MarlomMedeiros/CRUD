<?php

namespace App\Http\Livewire\Users;

use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class Edit extends Component
{
    use WithFileUploads;

    use Actions;

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


    protected function validationAttributes(): array
    {
        return [
            'user.name'       => __('Name'),
            'user.last_name'  => __('Last Name'),
            'user.cpf'        => __('CPF'),
            'user.phone'      => __('Phone Number'),
            'address.country' => __('Country'),
            'address.address' => __('Address'),
            'address.city'    => __('City'),
            'address.state'   => __('State'),
            'address.zip'     => __('Zip Code'),
        ];
    }

    public function mount(): void
    {
        $this->address = $this->user->address;
    }

    public function save(): void
    {
        $this->validate();

        $this->user->save();

        $this->user->address()->save($this->address);

        if (isset($this->photo)) {
            $this->user->updateProfilePhoto($this->photo);
        }

        $this->emit('saved');

        $this->redirect(route('users'));

        $this->notification()->send([
            'title'       => __('User successfully updated'),
            'description' => __('User :name has been updated successfully', ['name' => $this->user->name]),
            'icon'        => 'success',
        ]);
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
