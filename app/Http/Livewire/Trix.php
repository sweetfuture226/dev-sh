<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Trix extends Component
{
    public $value;
    public $trixId;

    public function mount($value = ''){
        $this->value = $value;
        $this->trixId = 'trix-' . uniqid();
    }

    public function getListeners()
    {
      return [
        'message.added' => 'resetValue'
      ];
    }

    public function resetValue()
    {
      $this->value = "";
    }


    public function updatedValue($value){
        $this->emit('trix_value_updated', $this->value);
    }

    public function render()
    {
        return view('livewire.trix');
    }
}
