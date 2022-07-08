<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Delete extends Component
{
    public User $user;

    public function destroy(): void
    {
        $this->user->delete();

        $this->user->address()->delete();

        $this->emitUp('userDeleted');
    }

    public function render(): View
    {
        return view('livewire.users.delete');
    }
}
