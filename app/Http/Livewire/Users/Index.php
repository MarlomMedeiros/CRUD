<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.users.index', [
            'users' => User::query()->paginate(10),
        ]);
    }

    public function delete($id): void
    {
        $user = User::query()->find($id);
        $user?->delete();
    }
}
