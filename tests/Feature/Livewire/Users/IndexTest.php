<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\Index;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);
    }

    /** @test */
    public function it_should_render_the_component()
    {
        Livewire::test(Index::class)
            ->assertStatus(200);
    }

    /** @test */
    public function it_should_list_registered_users(): void
    {
        $users = User::factory()
            ->state(new Sequence(
                ['email' => 'Test1@gmail.com'],
                ['email' => 'Test2@gmail.com'],
                ['email' => 'Test3@gmail.com'],
            ))->count(3)->create();
        
        Livewire::test(Index::class)
            ->assertSee($users->pluck('email')->toArray());
    }


}
