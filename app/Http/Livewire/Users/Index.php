<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = [
        'userDeleted' => '$refresh'
    ];

    public function render(): View
    {
        return view('livewire.users.index', [
            'users' => User::query()->paginate(10),
        ]);
    }
}
