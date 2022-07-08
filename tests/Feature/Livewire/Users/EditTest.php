<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\Edit;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Livewire\WithFileUploads;
use Tests\TestCase;

class EditTest extends TestCase
{
    use WithFileUploads;

    protected function setUp(): void
    {
        parent::setUp();

        $userAuth = User::factory()->create();

        $this->user = User::factory()->hasAddress()->create();

        $this->actingAs($userAuth);
    }

    /** @test */
    public function it_should_render_the_component()
    {
        Livewire::test(Edit::class, ['user' => $this->user])
            ->assertStatus(200);
    }

    /** @test */
    public function it_should_delete_photo_profile()
    {
        $this->user->updateProfilePhoto(UploadedFile::fake()->image('photo.jpg'));

        Livewire::test(Edit::class, ['user' => $this->user])
            ->call('deleteProfilePhoto');

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'profile_photo_path' => null,
        ]);
    }


    /** @test */
    public function it_should_be_able_edit_a_user()
    {
        Livewire::test(Edit::class, ['user' => $this->user])
            ->set('user.name', 'Test')
            ->set('user.last_name', 'Test2')
            ->set('user.email', 'TestTest2@gmail.com')
            ->set('user.birthday', '2020-01-01')
            ->set('user.cpf', '99999999999')
            ->set('user.phone', '9999999999')
            ->set('photo', UploadedFile::fake()->image('photo.jpg'))
            ->set('address.country', 'Brasil')
            ->set('address.address', 'Rua. Brazil')
            ->set('address.city', 'Rio de Janeiro')
            ->set('address.state', 'Rio de Janeiro')
            ->set('address.zip', '48834169')
            ->call('save')
            ->assertRedirect(route('users'));

        $this->assertDatabaseHas('users', [
            'name' => 'Test',
            'last_name' => 'Test2',
            'email' => 'TestTest2@gmail.com',
            'birthday' => '2020-01-01',
            'cpf' => '99999999999',
            'phone' => '9999999999',
        ]);

        $this->assertDatabaseHas('addresses', [
            'country' => 'Brasil',
            'address' => 'Rua. Brazil',
            'city' => 'Rio de Janeiro',
            'state' => 'Rio de Janeiro',
            'zip' => '48834169',
        ]);
    }
}
