<div class="row">
  <div class="col-md-1 form-group mb-3">
    {{$index+1}}
  </div>
  <div class="col-md-4 form-group mb-3">
    <input
        class="form-control border-0 fs-6 form-control-lg"
        wire:model="milestones.{{$key}}.name"
        placeholder="Description">
    <x-input-error for="milestones.{{$key}}.name" class="mt-2" />
  </div>
  <div class="col-md-3 form-group mb-3">
    <input
        class="form-control border-0 fs-6 form-control-lg sdatepicker"
        wire:model="milestones.{{$key}}.due_to"
        id="date-{{$index}}"
        onchange="this.dispatchEvent(new InputEvent('input'))"
        placeholder="Due To">
    <x-input-error for="milestones.{{$key}}.due_to" class="mt-2" />
  </div>
  <div class="col-md-3 form-group mb-3">
    <input
        class="form-control border-0 fs-6 form-control-lg"
         min="1"
         type="number"
        wire:model="milestones.{{$key}}.budget"
        placeholder="Budget">
    <x-input-error for="milestones.{{$key}}.budget" class="mt-2" />
  </div>
  <div class="col-md-1 form-group mb-3">
    @if($index > 0)
    <button class="btn btn-danger" wire:click="removeMilestone({{$key}})">
      <span class="fa fa-trash"></span>
    </button>
    @endif
  </div>
</div>
<script type="text/javascript">
    $('#date-{{$index}}').datepicker({
      'format' : 'yyyy-mm-d',
      'startDate' : '+0'
    });
</script>
