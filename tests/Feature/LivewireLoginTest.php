<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->get('/livewire/login')
            ->assertOk();

        Livewire::test('pages::auth.login')
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->call('login')
            ->assertRedirect('/livewire/tasks');

        $this->assertAuthenticated();
    }
}