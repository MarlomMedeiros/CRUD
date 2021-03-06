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
            'user.name'       => __('name'),
            'user.last_name'  => __('last name'),
            'user.cpf'        => __('CPF'),
            'user.phone'      => __('phone number'),
            'address.country' => __('country'),
            'address.address' => __('address'),
            'address.city'    => __('city'),
            'address.state'   => __('state'),
            'address.zip'     => __('zip code'),
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

        $this->notification()->send([
            'title'       => __('User successfully updated'),
            'description' => __('User :name has been updated successfully', ['name' => $this->user->name]),
            'icon'        => 'success',
        ]);


        $this->redirect(route('users.index'));
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
