<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Name</label>
            <input type="text"
                   class="form-control @error('name') is-invalid @enderror" wire:model.defer="name" required>
            @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email"
                   class="form-control @error('email') is-invalid @enderror" wire:model.defer="email" required>
            @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>Role</label>
            <select class="form-control @error('role') is-invalid @enderror" wire:model.defer="role" required>
                <option value=""></option>
                @foreach(\App\Models\User::ROLES as $key=>$val)
                <option value="{{ $key }}">{{ $val }}</option>
                @endforeach
            </select>
            @error('role')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror" wire:model.defer="password" required>
                    @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password"
                           class="form-control" wire:model.defer="password_confirmation" required>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" wire:click.prevent="add_user()">Save changes</button>
    </div>
</div>
