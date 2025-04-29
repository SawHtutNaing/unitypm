<?php

namespace Tests\Feature\Livewire;

use App\Livewire\TaskManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TaskManagerTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(TaskManager::class)
            ->assertStatus(200);
    }
}
