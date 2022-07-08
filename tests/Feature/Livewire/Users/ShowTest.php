<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\Show;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $userAuth = User::factory()->create();

        $this->actingAs($userAuth);

        $this->user = User::factory()->hasAddress()->create();
    }

    /** @test */
    public function it_should_render_the_component()
    {
        Livewire::test(Show::class, ['user' => $this->user])
            ->assertStatus(200);
    }

    /** @test */
    public function it_should_render_a_user()
    {
        Livewire::test(Show::class, ['user' => $this->user])
            ->assertStatus(200);
    }

}
