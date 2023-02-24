<div class="row">
  <div class="col-md-6 form-group mb-3">
      <input
          class="form-control border-0 fs-6 form-control-lg datepicker"
          value=""
          name="content"
          wire:model="start_at"
          onchange="this.dispatchEvent(new InputEvent('input'))"
          placeholder="Start At">
    <x-input-error for="start_at" class="mt-2" />
  </div>
  <div class="col-md-6 form-group mb-3">
      <input
          class="form-control border-0 fs-6 form-control-lg"
          value=""
          name="content"
          type="number" min="1"
          wire:model="duration"
          placeholder="Duration / Days">
      <x-input-error for="duration" class="mt-2" />
  </div>
  <div class="col-md-12 form-group mb-3">
      <x:select-list multiple wire:model="participants" id="participants" name="participants" :messages="$users" select-type="label"/>
      <x-input-error for="participants" class="mt-2" />
  </div>
  <div class="col-md-12 form-group mb-3">
    <div class="form-check">
      <input class="form-check-input" type="radio"
      wire:model="type"
      name="type" id="per_task" value="task" checked>
      <label class="form-check-label" for="per_task">
        By Task
      </label>
      </div>
      <div class="form-check">
      <input class="form-check-input" type="radio"
       wire:model="type"
       name="type" id="milestone" value="milestone">
      <label class="form-check-label" for="milestone">
        By Milestones
      </label>
      </div>
  </div>
  @if($type == 'task')
  <div class="col-md-12 form-group mb-3">
    <input
        class="form-control border-0 fs-6 form-control-lg"
        value=""
        name="content"
        type="number" min="1"
        wire:model="budget"
        placeholder="Total Budget">
    <x-input-error for="budget" class="mt-2" />
  </div>
  @else
  <div class="col-md-12 form-group mb-3">
    @foreach($milestones as $key => $mileston)
    <x-mileston key="{{$key}}" index="{{$loop->index}}" name="{{data_get($mileston, 'name')}}"/>
    @endforeach
  </div>

  <div class="col-md-12 form-group mb-3">
    <button class="btn btn-transparent"> <span class="fa fa-plus" wire:click="addNewMileston"> Add Milestone </button>
  </div>
  @endif

  <div class="col-md-12 form-group mb-3 text-right">
    <button class="btn btn-success float-right btn-lg" wire:click="save"> Submit</button>
  </div>
</div>
