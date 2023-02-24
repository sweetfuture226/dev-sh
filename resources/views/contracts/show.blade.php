@extends('layouts.app')

@section('ex_css')

@endsection
@section('content')

<div class="card p-0 p-md-5 border-light">
  <div class="card-body">
    <div class="row">
      <div class="col-12 p-0 mb-5">
        <a href="{{route('home')}}"> <img alt="" src="{{asset('images/arrow-right.svg')}}" width="48"> </a>
      </div>

      <div class="col-md-12 p-15 task-list-box summary-list">
        <div class="item">
          <h3>Task</h3>
          <div class="d-block">
            {!! $contract->task->description !!}
          </div>
        </div>
        @if($contract->milestones->count() > 0)
        <div class="item">
          <h3>Milestones</h3>
          <ul>
            @foreach($contract->milestones as $mileston)
            <li class="color-{{$mileston->status}}"> {{ucfirst($mileston->status)}} [{{$mileston->due_to->format('Y-m-d')}}] {{$mileston->name}}  - {{$mileston->budget}}$

            </li>
            @endforeach
          </ul>
        </div>
        @endif


        <div class="timeline item">
          <h3>Timeline of the Project</h3>

          <div class="d-flex">
            <div class="col-6">
              <h4>Start Date</h4>
            </div>

            <div class="col-6">
              {{$contract->start_at->format('d M Y')}}
            </div>
          </div>


          <div class="d-flex">
            <div class="col-6">
              <h4> Execution Time </h4>
            </div>

            <div class="col-6">
              {{$contract->duration}} Hours
            </div>
          </div>

          <div class="d-flex">
            <div class="col-6">
              <h4> Specialist </h4>
            </div>

            <div class="col-6">
              {{$contract->task->user->name}}
            </div>
          </div>
          <div class="d-flex">
            <div class="col-6">
              <h4> Developer </h4>
            </div>

            <div class="col-6">
              @foreach($contract->participants->filter( function($p) use ($contract) { return $p->id != $contract->task->user->id;}) as $participant)
                {{$participant->name}}
                @if(!$loop->last), @endif
              @endforeach
            </div>
          </div>


        </div>

        <div class="item row budget">

          <div class="col-sm-12 col-md-4 total-budget">
            <h3> Total Buget </h3>
            <div class="total mt-4">
              ${{$contract->budget}}
            </div>
          </div>

          <div class="col-sm-12 text-right col-md-8">
            <form action="{{route('contracts.update', [$contract->task->id, $contract->id])}}" method="post">
              @method('PUT')
              @csrf()
            @if($contract->status == 'rejected')
                @foreach($contract->participants as $participant)
                  @if($participant->pivot->status == 'rejected')

                  <button type="button"  class="btn btn-decline"> Rejected By
                    @if($current_participant and $current_participant->id == $participant->id)
                    You
                    @else
                    {{$participant->name}}
                    @endif
                  </button>
                  @endif
                @endforeach
            @else
              @if($current_participant)
                @if($current_participant->pivot->status == 'pending' )
                  <button type="submit" name="accept" value="accept" class="btn btn-success "> Accept</button>
                  <button  type="submit" name="reject" value="reject" class="btn btn-decline"> Decline</button>
                @elseif($current_participant->pivot->status == 'rejected')
                <button type="button"  class="btn btn-decline"> Rejected By you</button>
                @elseif($current_participant->pivot->status == 'accepted')
                <button type="button"  class="btn btn-success "> Accepted By you</button>
                @endif
              @endif

              @if(!$current_participant || $current_participant->pivot->status != 'pending')
                @foreach($contract->participants as $participant)
                  @if ($participant->id != auth()->user()->id)
                    @if($participant->pivot->status == 'rejected')
                    <button type="button"  class="btn btn-decline"> Rejected By {{$participant->name}}</button>
                    @elseif($participant->pivot->status == 'pending')
                    <button  type="button" class="btn btn-decline"> Waiting For {{$participant->name}}</button>
                    @elseif($participant->pivot->status == 'accepted')
                    <button  type="button" class="btn btn-success "> Accepted By {{$participant->name}}</button>
                    @endif
                  @endif
                @endforeach
              @endif
            @endif

          </form>
          </div>
        </div>
        @if(auth()->user()->role == 'coordinator' and in_array($contract->status, ['accepted', 'partial_accepted', 'pending']))

        <form action="{{route('contracts.start', [$contract->id])}}" method="post">
          @csrf()
          <div class="item">
            <div class="d-block pull-right">
              <button type="submit" @if($contract->status != 'accepted') disabled @endif name="accept" value="accept"
                class="btn  @if($contract->status != 'accepted') btn-secondary @else btn-success @endif "> Start Contract</button>
            </div>
          </div>
        </form>
        @elseif(auth()->user()->id == $contract->task->user_id and in_array($contract->status, ['started']))

        <form action="{{route('contracts.pay', [$contract->id])}}" method="post">
          @csrf()
          <div class="item">
            <div class="d-block ">
              <h3>Pay  @if($active_mileston) milestone {{$active_mileston->name}} {{$active_mileston->budget}} @else Total project {{$contract->budget}}@endif $</h3>
              <button type="submit"  name="accept" value="accept"
                class="btn  btn-success pull-right"> Pay</button>
            </div>
          </div>
        </form>
        @elseif($contract->status == 'finished')
        <div class="item">
          <div class="d-block color-paid">
            <h3>Contract Finalized</h3>
          </div>
        </div>
        @endif

      </div>
    </div>
  </div>
</div>
@endsection

@section('ex_js')
@endsection
