<?php

   namespace App\Livewire;

   use App\Models\Project;
use Carbon\Carbon;
use Livewire\Component;
   use Livewire\Attributes\Validate;

   class ProjectManager extends Component
   {
       #[Validate('required|string|max:255')]
       public $title = '';

       #[Validate('nullable|string')]
       public $description = '';

       #[Validate('nullable|date')]
       public $due_date = '';

       #[Validate('required|in:pending,in_progress,completed')]
       public $status = 'pending';

       public $editingId = null;

       public function create()
       {
           $this->validate();
           Project::create([
               'title' => $this->title,
               'description' => $this->description,
               'due_date' => $this->due_date,
               'status' => $this->status,
           ]);
           $this->resetForm();
           session()->flash('message', 'Project created successfully.');
       }

       public function edit($id)
       {
           $project = Project::findOrFail($id);
           $this->editingId = $id;
           $this->title = $project->title;
           $this->description = $project->description;
           $this->due_date = $project->due_date ? Carbon::parse($project->due_date)->format('Y-m-d') : '';
           $this->status = $project->status;
       }

       public function update()
       {
           $this->validate();
           $project = Project::findOrFail($this->editingId);
           $project->update([
               'title' => $this->title,
               'description' => $this->description,
               'due_date' => $this->due_date,
               'status' => $this->status,
           ]);
           $this->resetForm();
           session()->flash('message', 'Project updated successfully.');
       }

       public function delete($id)
       {
           Project::findOrFail($id)->delete();
           session()->flash('message', 'Project deleted successfully.');
       }

       public function cancelEdit()
       {
           $this->resetForm();
       }

       private function resetForm()
       {
           $this->title = '';
           $this->description = '';
           $this->due_date = '';
           $this->status = 'pending';
           $this->editingId = null;
       }

       public function render()
       {
           $projects = Project::latest()->get();
           return view('livewire.project-manager', compact('projects'));
       }
   }
