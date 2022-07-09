<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public User $user;

    public function destroy(): void
    {
        $this->user->delete();

        $this->user->address()->delete();

        $this->emitUp('userDeleted');

        $this->notification()->send([
            'title'       => __('User deleted successfully'),
            'description' => __('User has been deleted successfully', ['name' => $this->user->name]),
            'icon'        => 'success',
        ]);
    }

    public function render(): View
    {
        return view('livewire.users.delete');
    }
}
