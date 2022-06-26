<?php

namespace App\Http\Livewire\Users;

use App\Models\Addresses;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Laravel\Jetstream\Features;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public User $user;

    public Addresses $address;

    public $photo;

    protected array $rules = [
        'user.name'            => 'required|string|max:80',
        'user.last_name'       => 'required|string|max:80',
        'user.cpf'             => 'nullable|string|size:11',
        'user.phone'           => 'nullable|string|size:10',
        'user.email'           => 'required|string|max:255',
        'user.birthday'        => 'required|date',
        'user.address.country' => 'nullable|string|max:255',
        'user.address.address' => 'nullable|string|max:255',
        'user.address.city'    => 'nullable|string|max:255',
        'user.address.state'   => 'nullable|string|max:255',
        'user.address.zip'     => 'nullable|string|max:255',
    ];
    protected $validationAttributes = [
        'user.name'            => 'first name',
        'user.last_name'       => 'last name',
        'user.cpf'             => 'CPF',
        'user.phone'           => 'phone number',
        'user.address.country' => 'country',
        'user.address.address' => 'address',
        'user.address.city'    => 'city',
        'user.address.state'   => 'state',
        'user.address.zip'     => 'zip'
    ];

    public function mount()
    {
        $this->address = $this->user->address;
    }

    public function save()
    {
        $this->validate();

        $this->user->save();

        $this->user->address->save();

        if (isset($this->photo)) {
            $this->user->updateProfilePhoto($this->photo);
        }

        $this->emit('saved');
    }

    public function deleteProfilePhoto()
    {
        if (!Features::managesProfilePhotos()) {
            return;
        }

        if (is_null($this->user->profile_photo_path)) {
            return;
        }

        Storage::disk(config('jetstream.profile_photo_disk', 'public'))->delete($this->user->profile_photo_path);

        $this->user->forceFill([
            'profile_photo_path' => null,
        ])->save();
    }

    public function render(): View
    {
        return view('livewire.users.edit', [
            'user' => $this->user,
        ]);
    }
}
