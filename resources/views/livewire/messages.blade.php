<div>
    <ul class="p-0 pe-1">
        @php
            $prevMsg=null;
        @endphp
        @foreach($messages as $row)
            @if(!$prevMsg || ($prevMsg && $row->created_at->format('Y-m-d') !== $prevMsg->created_at->format('Y-m-d')))
                <li class="clearfix date-val">
                 <span class="small">
                       {{ ($row->created_at->isToday())?'Today': (($row->created_at->isYesterday())?'Yesterday':$row->created_at->format('M d, Y')) }}
                 </span>
                </li>
            @endif
                <li class="clearfix">
                    @if(Auth::id()!== $row->from_id)
                      <div class="message-data">
                          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQqGQ8dQ-LMiMmTEyBijR0FzpQHC7tH6qTE2g&usqp=CAU"
                               alt="avatar">
                          <span class="message-data-time">{!! $row->from->name !!}
                           <span class="small text-muted px-1">
                                 <small><i class="fa fa-clock-o"></i> {{ $row->created_at->format('g:i A')  }}</small>
                           </span>
                      </span>
                      </div>
                    @else
                      <div class="message-data text-end">
                       <span class="message-data-time small text-muted">
                           <i class="fa fa-clock-o"></i> {{ $row->created_at->format('g:i A')}}</span>
                      </div>
                    @endif
                    @if($row->contract_id)
                    <div class="message
                     @if(Auth::id()!== $row->from_id) other-message  @else float-right my-message @endif has-attachment {{data_get(json_decode($row->message), 'color')}}">
                      <a target="_blank" class="item" href="{!! route('contracts.show',[$row->task_id, $row->contract_id]) !!}">
                        <div class="icon">
                          <img alt="img"
                               src="{{asset('images/note-2.svg')}}"
                               width="24">
                        </div>
                        <div class="title"> Contract
                          Details
                        </div>
                        <span> {{data_get(json_decode($row->message), 'message')}}</span>
                      </a>
                    </div>
                    @else
                    <div class="message
                     @if($row->from->role == 'coordinator') highlight @endif
                     @if(Auth::id()!== $row->from_id) other-message   @else my-message float-right @endif text-start @if($row->attachments->count() > 0) has-attachment @endif">
                        {!! $row->message !!}
                        @foreach($row->attachments as $attachment)
                        <a class="link-attachment" target="_blank" href="{{route('attachments.show', $attachment->id)}}">


                          <div class="icon"><img
                              src="{{asset('images/file-blue.png')}}">
                          </div>


                          <div class="title">{{$attachment->original_name}}
                          </div>
                        </a>
                        @endforeach
                    </div>
                    @endif

                </li>
                @if($row->contract_id and data_get(json_decode($row->message), 'sub_message'))
                <li class="action clearfix">
                  <div class="
                  clearfix action message @if(Auth::id()!== $row->from_id) other-message   @else my-message float-right @endif  text-start @if($row->attachments->count() > 0) has-attachment @endif {{data_get(json_decode($row->message), 'sub_color')}}">
                      {!! data_get(json_decode($row->message), 'sub_message') !!}
                  </div>
                </li>
                @endif
            @php
                $prevMsg = $row;
            @endphp
        @endforeach
    </ul>
</div>
