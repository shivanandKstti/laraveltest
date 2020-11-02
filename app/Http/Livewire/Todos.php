<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Todos extends Component
{
    public $todos, $title, $description, $todo_id;
    public $isOpen = 0;

    public function render()
    {
        $this->todos = Todo::all();
        return view('livewire.todos');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModel();
    }

    public function openModel()
    {
        $this->isOpen = true;
    }

    public function closeModel()
    {
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->title = '';
        $this->description = '';
        $this->todo_id = '';
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        Todo::updateOrCreate(
            ['id' => $this->todo_id],
            ['title' => $this->title],
            ['description' => $this->description]);

        session()->flash('message',
            $this->todo_id ? 'Todo updated successfully' : 'Todo created successfully');

        $this->closeModel();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $Todo = Todo::findOrFail($id);
        $this->todo_id = $id;
        $this->title = $Todo->title;
        $this->description = $Todo->description;
     
        $this->openModal();
    }
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Todo::find($id)->delete();
        session()->flash('message', 'Todo Deleted Successfully.');
    }
}
