<div wire:ignore style="width: 100% !important;">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />

    <input id="{{ $trixId }}" type="hidden" name="content" value="{{ $value }}">
    <trix-editor style="width: 100% !important;max-width: 100% !important;word-break: break-all !important;"
   input="{{ $trixId }}" ></trix-editor>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    <script>
        document.querySelector(".trix-button-group--file-tools").remove();
        document.querySelector(".trix-button--icon-link").remove();
        document.querySelector(".trix-button--icon-bullet-list").remove();
        var trixEditor = document.getElementById("{{ $trixId }}")
        var element = document.querySelector("trix-editor");

        element.addEventListener("focus", function(event) {
          var ele = $('.scroll-chat-history');
          console.log('focus')
          setTimeout(function () {
            ele.stop().animate({scrollTop:ele.prop("scrollHeight")}, 500, 'swing', function() {

            });
          }, 300);
        });

        element.addEventListener("click", function(event) {
          var ele = $('.scroll-chat-history');
          console.log('click')
          setTimeout(function () {
            ele.stop().animate({scrollTop:ele.prop("scrollHeight")}, 500, 'swing', function() {

            });
          }, 300);
        });
        addEventListener("trix-change", function(event) {
            @this.set('value', trixEditor.getAttribute('value'))
        })
        addEventListener("trix-change", function(event) {
          console.log('change')
        })
        addEventListener("trix-focus", function(event) {
            console.log('focus..')
          var ele = $('.scroll-chat-history');
          setTimeout(function () {
            ele.stop().animate({scrollTop:ele.prop("scrollHeight")}, 500, 'swing', function() {

            });
          }, 300);
        })
        addEventListener("trix-blur", function(event) {
          console.log('trix-blur')
          var ele = $('.scroll-chat-history');
          setTimeout(function () {
            ele.stop().animate({scrollTop:ele.prop("scrollHeight")}, 500, 'swing', function() {

            });
          }, 300);
        })

        window.addEventListener('clear-trix', function () {

          element.editor.setSelectedRange([0, element.editor.getDocument().getLength()]);
          element.editor.deleteInDirection("backward");
          var ele = $('.scroll-chat-history');
            console.log('clear-trix')
            setTimeout(function () {
                    ele.scrollTop(ele.prop("scrollHeight"));
                    $('#btn-close').focus();
                }, 500);
        });
    </script>
</div>
