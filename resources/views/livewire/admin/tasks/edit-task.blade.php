<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Content</label>
            <input type="text"
                   class="form-control @error('content') is-invalid @enderror" wire:model.defer="content" required>
            @error('content')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>Description</label>
            <input type="text"
                   class="form-control @error('description') is-invalid @enderror" wire:model.defer="description" required>
            @error('description')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text"
                   class="form-control @error('phone') is-invalid @enderror" wire:model.defer="phone" required>
            @error('phone')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <label>User</label>
        <select class="form-control @error('user_id') is-invalid @enderror" wire:model.defer="user_id" required>
            <option value=""></option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_id')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" wire:click.prevent="update_task()">Save changes</button>
    </div>
</div>
