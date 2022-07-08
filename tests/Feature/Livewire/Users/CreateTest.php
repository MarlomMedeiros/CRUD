<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\Create;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);
    }

    /** @test */
    public function it_should_render_the_component(): void
    {
        Livewire::test(Create::class)
            ->assertStatus(200);
    }

    /** @test */
    public function it_should_be_able_create_a_new_user(): void
    {
        Livewire::test(Create::class)
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
            ->set('password', '12345678')
            ->call('create')
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

    /**
     * @test
     * @dataProvider validationErrors
     */
    public function it_should_return_validation_errors($field, $error, $value = ''): void
    {
        User::factory()->create([
            'email' => 'TestTest2@gmail.com',
            'cpf' => '99999999999',
        ]);

        Livewire::test(Create::class)
            ->set($field, $value)
            ->call('create')
            ->assertHasErrors([$field => $error]);
    }


    public function validationErrors(): array
    {
        return [
            'name required' => ['user.name', 'required', ''],
            'name string' => ['user.last_name', 'string', 1234],
            'name max' => ['user.name', 'max:80', Str::random(81)],
            'cpf string' => ['user.cpf', 'string', 1234],
            'cpf max' => ['user.cpf', 'max', Str::random(256)],
            'cpf unique' => ['user.cpf', 'unique', '99999999999'],
            'phone string' => ['user.phone', 'string', 1234],
            'phone max' => ['user.phone', 'max', Str::random(256)],
            'email required' => ['user.email', 'required', ''],
            'email string' => ['user.email', 'string', 1234],
            'email max' => ['user.email', 'max', Str::random(256)],
            'email unique' => ['user.email', 'unique', 'TestTest2@gmail.com'],
            'birthday required' => ['user.birthday', 'required', ''],
            'birthday date' => ['user.birthday', 'date', '1234'],
            'password required' => ['password', 'required', ''],
            'address country string' => ['address.country', 'string', 1234],
            'address country max' => ['address.country', 'max', Str::random(256)],
            'address address string' => ['address.address', 'string', 1234],
            'address address max' => ['address.address', 'max', Str::random(256)],
            'address city string' => ['address.city', 'string', 1234],
            'address city max' => ['address.city', 'max', Str::random(256)],
            'address state string' => ['address.state', 'string', 1234],
            'address state max' => ['address.state', 'max', Str::random(256)],
            'address zip string' => ['address.zip', 'string', 1234],
            'address zip max' => ['address.zip', 'max', Str::random(256)],
        ];
    }
}
