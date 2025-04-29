<?php

   namespace App\Livewire;

   use App\Models\Project;
   use App\Models\Task;
   use Livewire\Component;
   use Livewire\Attributes\Validate;

   class TaskManager extends Component
   {
       public $projectId;

       #[Validate('required|string|max:255')]
       public $title = '';

       #[Validate('nullable|string')]
       public $description = '';

       #[Validate('required|in:pending,in_progress,completed')]
       public $status = 'pending';

       #[Validate('required|in:low,medium,high')]
       public $priority = 'medium';

       #[Validate('nullable|date')]
       public $due_date = '';

       public $editingId = null;

       public function mount($projectId)
       {
           $this->projectId = $projectId;
       }

       public function create()
       {
           $this->validate();
           Task::create([
               'project_id' => $this->projectId,
               'title' => $this->title,
               'description' => $this->description,
               'status' => $this->status,
               'priority' => $this->priority,
               'due_date' => $this->due_date,
           ]);
           $this->resetForm();
           session()->flash('message', 'Task created successfully.');
       }

       public function edit($id)
       {
           $task = Task::findOrFail($id);
           $this->editingId = $id;
           $this->title = $task->title;
           $this->description = $task->description;
           $this->status = $task->status;
           $this->priority = $task->priority;
           $this->due_date = $task->due_date ? $task->due_date->format('Y-m-d') : '';
       }

       public function update()
       {
           $this->validate();
           $task = Task::findOrFail($this->editingId);
           $task->update([
               'title' => $this->title,
               'description' => $this->description,
               'status' => $this->status,
               'priority' => $this->priority,
               'due_date' => $this->due_date,
           ]);
           $this->resetForm();
           session()->flash('message', 'Task updated successfully.');
       }

       public function delete($id)
       {
           Task::findOrFail($id)->delete();
           session()->flash('message', 'Task deleted successfully.');
       }

       public function cancelEdit()
       {
           $this->resetForm();
       }

       private function resetForm()
       {
           $this->title = '';
           $this->description = '';
           $this->status = 'pending';
           $this->priority = 'medium';
           $this->due_date = '';
           $this->editingId = null;
       }

       public function render()
       {
           $project = Project::with('tasks')->findOrFail($this->projectId);
           return view('livewire.task-manager', compact('project'));
       }
   }
