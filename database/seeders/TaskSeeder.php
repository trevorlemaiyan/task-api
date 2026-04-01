<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Task::create(['title' => 'Review API Assessment', 'due_date' => Carbon::now()->addDays(2)->toDateString(), 'priority' => 'high', 'status' => 'pending']);
        Task::create(['title' => 'Test Vue Frontend', 'due_date' => Carbon::now()->addDays(5)->toDateString(), 'priority' => 'medium', 'status' => 'in_progress']);
        Task::create(['title' => 'Deploy to Render', 'due_date' => Carbon::now()->subDays(1)->toDateString(), 'priority' => 'low', 'status' => 'done']);
    }
}