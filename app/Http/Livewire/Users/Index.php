<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public string $orderBy = 'name';

    public string $orderDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'page'   => ['except' => 1, 'as' => 'p'],
    ];

    protected $listeners = [
        'userDeleted' => '$refresh'
    ];

    public function orderBy(string $orderBy, string $orderDirection): void
    {
        $this->orderBy        = $orderBy;
        $this->orderDirection = $orderDirection;
    }

    public function render(): View
    {
        return view('livewire.users.index', [
            'users' => User::query()
                ->search($this->search)
                ->orderBy($this->orderBy, $this->orderDirection)
                ->paginate(10),
        ]);
    }
}
