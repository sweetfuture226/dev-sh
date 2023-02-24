<div class="chat-message clearfix px-0">
  <div class="d-block">

    <div class="d-flex w-100 send-msg-box">
      <livewire:trix :value="$message">
    </div>

    <div class="buttons-container">

      <button class="btn">
        <input type="file"  wire:model="attachments" multiple  />
        <img alt="img" src="{{asset('images/Link.svg')}}">
      </button>


      <button class="btn btn-sm btn-primary"
              style="border-radius: 9999px; height: 100%"
              wire:click="send">
        Send

      </button>

    </div>
    @if(count($attachments) > 0)
    <div class="attachments">
      @foreach($attachments as $key => $attachment)
      <div class="item">
        <div class="icon">
          @if(collect(['jpg', 'png', 'jpeg', 'webp'])->contains($attachment->getClientOriginalExtension()))
              <img width="24" src="{{ $attachment->temporaryUrl() }}" />
         @else
             <img alt="img"
                  src="{{asset('images/pdf-icon.png')}}"
                  width="24">
          @endif
        </div>
        <div class="title">
          @error('attachments.'. $key)
            <p class="text-sm text-red" class="mb-2">{{ $message }}</p>
          @enderror
          {{ $attachment->getClientOriginalName() }}
        </div>
        <div class="action">
          <button class="btn btn-danger" wire:click="removeUpload('attachments', '{{ $attachment->getFilename() }}')">
            <img alt="img" images="" public=""
                 src="{{asset('images/delete-sign.png')}}"
                 width="18"></button>
        </div>
      </div>
      @endforeach

    </div>
    @endif

  </div>
</div>
