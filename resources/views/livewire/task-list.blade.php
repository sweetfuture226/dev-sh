<div class="row">
    <div class="col-md-6 col-sm-12">
        <h2>
            Your Tasks
        </h2>
    </div>
    <div class="col-md-6 col-sm-12 text-end task-btn">


        @if((auth()->user()->is_admin || auth()->user()->role == 'client'))
        <a href="{!! route('tasks.create') !!}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-plus"></i> Add New Task
        </a>
        @endif
    </div>
  <div class="col-md-12 mt-3 task-list-box">
    <div class="row py-0">
      <button class="btn btn-light btn-sm mb-1 d-none" id="refresh-chat-btn"
              wire:click="refreshChat">
          <i class="fa fa-refresh text-secondary "></i> Refresh Chat
      </button>
      @if($tasks->count()>0)
          <div
                  class="col-md-6 border-end border-light border-3 task-list-content {!! ($agent !== 'Mobile')?'scroll-v':'' !!}"
                  id="task-list-content"  @if($agent == 'Mobile') style="padding: 0px;margin : 12px 12px 12px 12px;" @endif>
              @foreach($tasks as $ind=>$task)
                  @if($agent == 'Mobile')
                  <div
                          class="task-node cursor-pointer border-dark border-1 px-1 py-2 {!! (($ind+1)>=$tasks->count())?'border-0':'border-bottom' !!}">
                      <div class="d-flex justify-content-between mt-2"
                           >

                          <div wire:click="selectTask({{$task->id}})" class="fs-7 fw-bold {!! ($task->id == $selectedTask)?'text-primary':'' !!}" style="width:100%; margin:auto">
                              {!! $task->content !!}

                          </div>
                          <div wire:click="selectTask({{$task->id}})">
                              @if($task->user_id === auth::id())
                                  <div class="d-flex align-bottom p-1 float-right">


                                      <a href="{!! route('tasks.edit',$task->id) !!}">
                                          <i class="fa fa-edit text-secondary me-1 fs-5"></i>
                                      </a>

                                      <i class="d-none fa fa-trash text-danger fs-5" wire:click="deleteTask({{ $task->id }})"
                                         onclick="confirm('Are you sure you want to remove?') || event.stopImmediatePropagation()"></i>
                                  </div>
                              @endif
                          </div>

                      </div>
                      <div class="d-flex" wire:click="selectTask({{$task->id}})">
                        <div class="fs-7" style="width:100%; margin:auto;word-break: break-all">
                          <span wire:click="selectTask({{$task->id}})">
                              {!! $task->description !!}
                          </span>


                        </div>
                        <div style="width:145px;">
                            <label class="w-auto small px-2 {!! ($task->id == $selectedTask)?'bg-lb':'bg-lg' !!}">
                                ${!! $task->budget_min !!} - ${!! $task->budget_max !!}
                            </label>
                        </div>

                      </div>
                      <div class="d-flex">
                          <div class="small text-muted">
                              <span wire:click="selectTask({{$task->id}})">
                                @if($task->contract)
                                  @if($task->contract->status == 'pending')
                                  <label class="info info-orage">Under Review</label>
                                  @elseif($task->contract->status == 'started')
                                  <label class="info info-success">Contract Start</label>
                                  @elseif($task->contract->status == 'rejected')
                                  <label class="info info-danger">Rejected</label>
                                  @elseif($task->contract->status == 'finished')
                                  <label class="info info-ended">Contract Finalized</label>
                                  @elseif($task->contract->status == 'accepted' || $task->contract->status == 'partial_accepted')
                                    @foreach($task->contract->participants as $participant)
                                      @if($participant->pivot->status == 'rejected')
                                      <label class="info info-danger"> Rejected By {{$participant->id == auth()->user()->id ? 'You' : $participant->name}}</label>
                                      @elseif($participant->pivot->status == 'pending')
                                      <label class="info info-danger"> Waiting For {{$participant->id == auth()->user()->id ? 'You' : $participant->name}}</label>
                                      @elseif($participant->pivot->status == 'accepted')
                                      <label class="info info-success"> Accepted By {{$participant->id == auth()->user()->id ? 'You' : $participant->name}}</label>
                                      @endif
                                    @endforeach
                                  @endif
                                @endif
                              </span>
                          </div>


                      </div>
                  </div>
                  @else
                  <div
                          class="task-node cursor-pointer border-dark border-1 px-1 py-2 {!! (($ind+1)>=$tasks->count())?'border-0':'border-bottom' !!}">
                      <div class="d-flex justify-content-between mt-2" wire:click="selectTask({{$task->id}})"
                           >

                          <div class="fs-7 fw-bold {!! ($task->id == $selectedTask)?'text-primary':'' !!}">
                              {!! $task->content !!}
                              @if($task->contract)
                                @if($task->contract->status == 'pending')
                                <label class="info info-orage">Under Review</label>
                                @elseif($task->contract->status == 'started')
                                <label class="info info-success">Contract Start</label>
                                @elseif($task->contract->status == 'rejected')
                                <label class="info info-danger">Rejected</label>
                                @elseif($task->contract->status == 'finished')
                                <label class="info info-ended">Contract Finalized</label>
                                @elseif($task->contract->status == 'accepted' || $task->contract->status == 'partial_accepted')
                                  @foreach($task->contract->participants as $participant)
                                    @if($participant->pivot->status == 'rejected')
                                    <label class="info info-danger"> Rejected By {{$participant->id == auth()->user()->id ? 'You' : $participant->name}}</label>
                                    @elseif($participant->pivot->status == 'pending')
                                    <label class="info info-danger"> Waiting For {{$participant->id == auth()->user()->id ? 'You' : $participant->name}}</label>
                                    @elseif($participant->pivot->status == 'accepted')
                                    <label class="info info-success"> Accepted By {{$participant->id == auth()->user()->id ? 'You' : $participant->name}}</label>
                                    @endif
                                  @endforeach
                                @endif
                              @endif
                          </div>
                          <div>
                              <label class="w-auto small px-2 {!! ($task->id == $selectedTask)?'bg-lb':'bg-lg' !!}">
                                  ${!! $task->budget_min !!} - ${!! $task->budget_max !!}
                              </label>
                          </div>
                      </div>
                      <div class="">
                          <div class="small text-muted">
                              <span wire:click="selectTask({{$task->id}})">
                                  {!! $task->description !!}
                              </span>

                              @if($task->user_id === auth()->id())
                                  <div class="d-flex align-bottom p-1 float-right">


                                      <a href="{!! route('tasks.edit',$task->id) !!}">
                                          <i class="fa fa-edit text-secondary me-1 fs-5"></i>
                                      </a>

                                      <i class="d-none fa fa-trash text-danger fs-5" wire:click="deleteTask({{ $task->id }})"
                                         onclick="confirm('Are you sure you want to remove?') || event.stopImmediatePropagation()"></i>
                                  </div>
                              @endif
                          </div>

                      </div>
                  </div>
                  @endif
              @endforeach

          </div>
          @if($agent !== 'Mobile')
              <div class="d-none d-md-block col-md-6 task-list-content " >
                  <div class="row gx-5">
                      @if($taskObject)
                          <div class="bg-light p-2 d-md-none border border-light w-100">
                              {!! $taskObject->content !!}
                          </div>
                      @endif
                      <div class="col-lg-12">
                          @if($selectedTask)
                            <div class="chat-header" style="margin-bottom:3px;">
                              <div class="d-flex align-items-center px-2">
                                <div class="chat-header-avatars d-flex align-items-center " style="width:100%">
                                  <div class="avatar-names">
                                    <h3>
                                      @if($taskObject and $taskObject->contract)
                                        @foreach($taskObject->contract->participants as $participant)
                                          {{$participant->name}}@if(!$loop->last), @endif
                                        @endforeach
                                      @endif
                                    </h3>
                                  </div>

                                </div>
                                @if((auth()->user()->is_admin || auth()->user()->role == 'coordinator') and $taskObject and (!$taskObject->contract || $taskObject->contract->status == 'rejected'))
                                <a href="{{route('contracts.create',$taskObject->id)}}" style="width:260px" class="btn btn-outline-primary btn-sm mr-3 pull-right">
                                    <i class="fa fa-plus"></i> Create New Contract
                                </a>
                                @endif
                                <div class="chat-header-call">
                                  <a href="https://wa.me/{{$taskObject->phone}}" target="_blank"> <img alt="img" height="32"
                                                    src="{{asset('images/call.svg')}}"
                                                    width="32"> </a>
                                </div>
                              </div>
                            </div>

                              <div class="chat-app">
                                  <div class="chat">
                                      <div class="scroll-chat-history chat-history px-2 web">
                                          <livewire:messages :messages="$conversations" />
                                      </div>
                                      <div class="chat-message clearfix px-0">
                                          <livewire:new-message :task="$taskObject" />
                                      </div>
                                  </div>
                              </div>
                          @endif
                      </div>
                  </div>
              </div>
          @endif
      @else
          <div class="col-md-12 text-muted text-center align-middle my-5 py-5">
              No Tasks Found
          </div>
      @endif

      @if($agent == 'Mobile')
          <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
               aria-labelledby="exampleModalLabel" aria-hidden="true" >
              <div class="modal-dialog modal-fullscreen" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 style="width:100%" class="modal-title" id="exampleModalLabel">
                              @if($taskObject)
                                  {!! $taskObject->content !!}
                              @endif
                          </h5>
                          @if((auth()->user()->is_admin || auth()->user()->role == 'coordinator') and $taskObject and (!$taskObject->contract || $taskObject->contract->status == 'rejected'))
                          <a style="width: 250px;font-size: 11px;" href="{{route('contracts.create',$taskObject->id)}}" class="btn btn-outline-primary btn-sm mr-3 pull-right">
                              <i class="fa fa-plus"></i> Create New Contract
                          </a>
                          @endif
                          <button id="btn-close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true close-btn">×</span>
                          </button>
                      </div>
                      <div class="modal-body scroll-chat-history" style="height: 80vh ">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="chat-app">

                                      <div class="chat">
                                          <div class="text-end border-bottom  border-light mb-2 d-none">
                                              <button class="btn btn-light btn-sm mb-1" id="refresh-chat-btn"
                                                      wire:click="refreshChat">
                                                  <i class="fa fa-refresh text-secondary "></i> Refresh Chat
                                              </button>
                                          </div>

                                          <div class="chat-history px-2 mobile" >
                                              <livewire:messages :messages="$conversations" />
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <livewire:new-message :task="$taskObject" />
                      </div>
                  </div>
              </div>
          </div>
      @endif
      <script>
          window.addEventListener('new-text', function () {
              var ele = $('.scroll-chat-history');
              ele.scrollTop(ele.prop("scrollHeight"));
          });

          window.addEventListener('taskSelected', event => {
              console.log('task selected..');

              $('#exampleModal').modal('show');
              var ele = $('.scroll-chat-history');
              setTimeout(function () {
                      ele.scrollTop(ele.prop("scrollHeight"));
                  }, 500);

          });


      </script>
  </div>
  </div>
</div>
