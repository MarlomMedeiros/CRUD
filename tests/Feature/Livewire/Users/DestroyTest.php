<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\Delete;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $userAuth = User::factory()->create();

        $this->actingAs($userAuth);
    }

    /** @test */
    public function it_should_render_the_component()
    {
        Livewire::test(Delete::class)->assertStatus(200);
    }

    /** @test */
    public function it_should_able_delete_user()
    {

        $user = User::factory(['email' => 'Test1@gmail.com'])->hasAddress()->create();

        $this->assertDatabaseHas('users', [
            'email' => 'Test1@gmail.com',
        ]);

        Livewire::test(Delete::class, ['user' => $user])
            ->call('destroy');

        $this->assertDatabaseMissing('users', [
            'email' => 'Test1@gmail.com',
        ]);
    }
}
