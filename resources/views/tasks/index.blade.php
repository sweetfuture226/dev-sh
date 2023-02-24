@extends('layouts.app')
@section('ex-css')
<style>
.trix-button--icon-increase-nesting-level,
.trix-button--icon-decrease-nesting-level, .trix-button--icon-link { display: none; }
</style>
@endsection
@section('content')
    <div class="card p-0 p-md-5 border-light">
        <div class="card-body">
            <livewire:task-list/>
        </div>
    </div>
@endsection
@section('ex_js')
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script>
        $(document).ready(function () {

            // listen for message
            Echo.channel('laravel-live-chat')
                .listen('NewChatMessageEvent', (e) => {
                    $('#refresh-chat-btn').trigger('click');
                    //scrollDown();
                    //scrollToBottom();
                });


            // scroll chat container to bottom
            function scrollToBottom() {
                var ele = $('.chat-history');
                ele.scrollTop(ele.prop("scrollHeight"));
            }

            $('.close').click(function () {
                $('#exampleModal').modal('hide');
            });

            function scrollDown() {
                scrollToBottom();
                //$('.chat-history').animate({ scrollTop: $('.chat-history').height() }, 800);
            }

            // $('#task-list-content').on('click', '.task-node', function () {
            //     //scrollDown();
            //     setTimeout(function () {
            //         scrollDown();
            //     }, 300);
            // });
            scrollDown();
        });
    </script>
@endsection
