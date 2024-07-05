<?php

namespace App\Http\Livewire\Registration;

use Livewire\Component;
use App\Models\User;

class UserCareer extends Component

{
    public $field1;
   
    
    protected $rules = [
        
    ];


    public function render()
    {
        return view('livewire.registration.user-career');
    }



    public function storeData()
    {
    //    $this->validate();

        $data = [
            // 
        ];

        $this->emit('userCareer', $data);

    }


    public function stepBack()
    {
        $this->emit('goBack');
    }



}
