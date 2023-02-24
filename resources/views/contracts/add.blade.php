@extends('layouts.app')

@section('ex_css')
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <style>
  .btn-transparent {
    color: #3b8754;
    background-color: transparent;
    border-color: transparent;
  }
  </style>
@endsection
@section('content')

    <div class="card p-0 p-md-5 border-light">
        <div class="card-body">
            <div class="row">
                <div class="d-none d-md-block col-md-12 mb-3">
                    <a href="{!! route('home') !!}" style="color:  #C8C5C5;" class="text-uppercase small">
                        <i class="fa fa-chevron-left" style="color: #C8C5C5"></i> Back To HOME PAGE
                    </a>
                </div>

                <div class="col-md-12">
                    <h2>
                        Create Contract For  [{{$task->content}}]
                    </h2>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="row py-0">
                        <div class="col-12">
                          <livewire:contract :task="$task" :users="$users">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('ex_js')
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$('.datepicker').datepicker({
  'format' : 'yyyy-mm-d',
  'startDate' : '+0'
});
</script>
@endsection
