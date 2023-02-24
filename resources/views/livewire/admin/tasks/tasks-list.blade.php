<div class="table-responsive">
    <a href="#" class="btn btn-sm btn-warning mb-2" id="delete-button" onclick="deleteSelected()">Delete Selected</a>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Select</th>
            <th>Content</th>
            <th>Author</th>
            <th>Phone</th>
            <th>Created At</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td><input type="checkbox" onchange="selectTask(event)" value="{{$task->id}}"></td>
                <td>{{ $task->content }}</td>
                <td>{{ $task->user->name }}</td>
                <td>{{ $task->phone }}</td>
                <td>{{ $task->created_at }}</td>
                <td class="text-right">
                    <a href="#"
                       data-toggle="modal"
                       data-target="#ModalEditTask"
                       wire:click.prevent="$emitTo('admin.tasks.edit-task', 'edit_task', {{ $task->id }});"
                       class="btn btn-xs btn-info">Edit</a>
                    <a href="#"
                       wire:click.prevent="$emit('confirm_delete', {{ $task->id }});"
                       class="btn btn-xs btn-warning">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @push('scripts')
        <script>
            Livewire.on('confirm_delete', function (task_id) {
                if (window.confirm('Are you sure you want to delete the task?')) {
                @this.call('delete_task', task_id);
                }
            })


            let selectedTasks = [];

            function selectTask($event) {
                let id = $event.target.value;

                if (selectedTasks.includes(id)) {
                    const index = selectedTasks.indexOf(2);
                    selectedTasks.splice(index, 1)
                } else {
                    selectedTasks.push(id);
                }

                showDeleteButton();
            }

            function showDeleteButton() {
                let elem = document.getElementById('delete-button');

                if (selectedTasks.length) {
                    elem.style.display = 'inline-block';
                } else {
                    elem.style.display = 'none'
                }
            }

            function deleteSelected() {
                if (selectedTasks.length) {
                    if (window.confirm('Are you sure you want to delete the selected tasks?')) {
                    @this.call('delete_selected_tasks', selectedTasks);
                    }
                }
            }
        </script>
    @endpush

    <style>
        #delete-button {
            display: none;
        }
    </style>
</div>
