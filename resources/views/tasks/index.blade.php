@extends('layouts.app')

@section('content')
<!-- Title Added (At the top of the page) -->
<h1 class="mb-4 text-center text-black">My Notes List</h1>

<!-- New Note Form (Visible from the Start) -->
<form method="POST" action="/tasks" class="mb-4">
    @csrf
    <div class="input-group">
        <!-- New Note Input with Border -->
        <input type="text" name="name" class="form-control border-dark" placeholder="New Note" required style="border-radius: 30px; border: 1px solid #343a40;">
        <button class="btn btn-dark" style="border-radius: 30px; font-weight: bold;">Add Note</button>
    </div>
</form>

<!-- Task List -->
<ul class="list-group">
    @foreach($tasks as $task)
    <li class="list-group-item d-flex justify-content-between align-items-center mb-3 p-3 shadow-sm rounded bg-dark text-white">
        
        <!-- Task Name Display (Default State) -->
        <span id="task-name-{{ $task->id }}" class="task-name h5" style="font-weight: 500;">{{ $task->name }}</span>

        <!-- Edit Task Form (Initially Hidden) -->
        <form method="POST" action="/tasks/{{ $task->id }}" class="d-inline" id="edit-form-{{ $task->id }}" style="display: none;">
            @csrf
            @method('PUT')
            <!-- Input Field for Editing -->
            <input type="text" name="name" class="form-control d-inline-block" id="task-input-{{ $task->id }}" required style="visibility: hidden; border-radius: 30px;">
        </form>

        <!-- Action Buttons -->
        <div class="btn-group" id="button-group-{{ $task->id }}">
            <!-- Edit Button -->
            <button class="btn btn-warning btn-sm" id="edit-button-{{ $task->id }}" onclick="editTask({{ $task->id }})" style="border-radius: 30px;">
                <i class="fas fa-edit"></i> Edit
            </button>

            <!-- Update and Cancel Buttons -->
            <button type="button" class="btn btn-success btn-sm" id="update-button-{{ $task->id }}" onclick="updateTask({{ $task->id }})" style="display: none; border-radius: 30px;">
                <i class="fas fa-save"></i> Update
            </button>
            <button type="button" class="btn btn-secondary btn-sm" id="cancel-button-{{ $task->id }}" onclick="cancelEdit({{ $task->id }})" style="display: none; border-radius: 30px;">
                <i class="fas fa-times"></i> Cancel
            </button>

            <!-- Delete Button -->
            <form method="POST" action="/tasks/{{ $task->id }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" style="border-radius: 30px;">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
            </form>
        </div>
    </li>
    @endforeach
</ul>

<!-- Include FontAwesome for Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<script>
    // Function to start editing the task
    function editTask(taskId) {
        // Hide task name and edit button
        document.getElementById('task-name-' + taskId).style.display = 'none';
        document.getElementById('edit-button-' + taskId).style.display = 'none';

        // Show input field for editing and update/cancel buttons
        let inputField = document.getElementById('task-input-' + taskId);
        let taskName = document.getElementById('task-name-' + taskId).innerText;

        inputField.value = taskName;  // Set the current task name into the input field
        document.getElementById('edit-form-' + taskId).style.display = 'inline-block';
        inputField.style.visibility = 'visible';  // Make the input field visible
        document.getElementById('update-button-' + taskId).style.display = 'inline-block';
        document.getElementById('cancel-button-' + taskId).style.display = 'inline-block';
    }

    // Function to update the task
    function updateTask(taskId) {
        document.getElementById('edit-form-' + taskId).submit();
    }

    // Function to cancel editing
    function cancelEdit(taskId) {
        // Revert to original state
        document.getElementById('task-name-' + taskId).style.display = 'inline-block';  // Show task name again
        document.getElementById('edit-button-' + taskId).style.display = 'inline-block';  // Show edit button again
        document.getElementById('edit-form-' + taskId).style.display = 'none';  // Hide the form
        document.getElementById('task-input-' + taskId).style.visibility = 'hidden';  // Hide the input field
        document.getElementById('update-button-' + taskId).style.display = 'none';  // Hide update button
        document.getElementById('cancel-button-' + taskId).style.display = 'none';  // Hide cancel button
    }
</script>

@endsection
