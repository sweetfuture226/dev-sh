<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Email</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->email }}</td>
                <td class="text-right">
                    <a href="#"
                       data-toggle="modal"
                       data-target="#ModalEditUser"
                       wire:click.prevent="$emitTo('admin.edit-user', 'edit_user', {{ $user->id }});"
                       class="btn btn-xs btn-info">Edit</a>
                    <a href="#"
                       wire:click.prevent="$emit('confirm_delete', {{ $user->id }});"
                       class="btn btn-xs btn-warning">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @push('scripts')
        <script>
            Livewire.on('confirm_delete', function (user_id) {
                if (window.confirm('Are you sure you want to delete the user?')) {
                @this.call('delete_user', user_id);
                }
            })
        </script>
    @endpush
</div>
