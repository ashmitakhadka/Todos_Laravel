<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;

class LivewireRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        Livewire::test('pages::auth.register')
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('save')
            ->assertRedirect('/livewire/login');

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    public function test_duplicate_email_is_rejected(): void
{
    User::factory()->create([
        'email' => 'test@example.com',
    ]);

    Livewire::test('pages::auth.register')
        ->set('name', 'Another User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('save')
        ->assertHasErrors(['email']);
}
public function test_invalid_email_is_rejected(): void
{
    Livewire::test('pages::auth.register')
        ->set('name', 'Test User')
        ->set('email', 'not-an-email')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('save')
        ->assertHasErrors(['email']);
}
public function test_name_is_required(): void
{
    Livewire::test('pages::auth.register')
        ->set('name', '')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('save')
        ->assertHasErrors(['name']);
}
public function test_short_password_is_rejected(): void
{
    Livewire::test('pages::auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', '12345')
        ->set('password_confirmation', '12345')
        ->call('save')
        ->assertHasErrors(['password']);
}

public function test_password_confirmation_must_match(): void
{
    Livewire::test('pages::auth.register')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'different123')
        ->call('save')
        ->assertHasErrors(['password']);
}
}