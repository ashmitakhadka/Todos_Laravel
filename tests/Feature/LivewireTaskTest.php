<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireTaskTest extends TestCase
{
    use RefreshDatabase;

    // 1. User can create a task
    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user);

        Livewire::test('pages::tasks.create')
            ->set('title', 'Learn Livewire')
            ->set('description', 'Practice Livewire testing')
            ->call('save');

        $this->assertDatabaseHas('todos', [
            'user_id' => $user->id,
            'title' => 'Learn Livewire',
            'description' => 'Practice Livewire testing',
        ]);
    }

    // 2. Title is required
    public function test_title_is_required_when_creating_task(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user);

        Livewire::test('pages::tasks.create')
            ->set('title', '')
            ->set('description', 'Task without title')
            ->call('save')
            ->assertHasErrors(['title']);
    }

    // 3. User can edit their own task
    public function test_user_can_edit_own_task(): void
    {
        $user = User::factory()->create();

        $todo = Todo::create([
            'user_id' => $user->id,
            'title' => 'Old Title',
            'description' => 'Old Description',
            'completed' => false,
        ]);

        Livewire::actingAs($user);

        Livewire::test('pages::tasks.edit', [
            'todo' => $todo->id,
        ])
            ->set('title', 'Updated Title')
            ->set('description', 'Updated Description')
            ->call('update');

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'user_id' => $user->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);
    }

    // 4. User can complete their own task
    public function test_user_can_complete_own_task(): void
    {
        $user = User::factory()->create();

        $todo = Todo::create([
            'user_id' => $user->id,
            'title' => 'Complete this task',
            'description' => 'Test completion',
            'completed' => false,
            'completed_at' => null,
        ]);

        Livewire::actingAs($user);

        Livewire::test('pages::tasks.show', [
            'todo' => $todo->id,
        ])
            ->call('toggleComplete');

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'completed' => true,
        ]);
    }

   
}