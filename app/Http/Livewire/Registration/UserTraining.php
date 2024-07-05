<?php

namespace App\Http\Livewire\Registration;

use Livewire\Component;
use App\Models\User;

class UserTraining extends Component

{

    public function render()
    {
        return view('livewire.registration.user-training');
    }

    public function storeData()
    {
    //    $this->validate();

        $data = [
            
        ];

        $this->emit('userTraining', $data);

    }

    public function goBack()
    {
        $this->currentStep--;
    }


    public function stepBack()
    {
        $this->emit('goBack');
    }

}
