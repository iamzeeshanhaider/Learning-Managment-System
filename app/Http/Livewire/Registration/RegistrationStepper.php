<?php

namespace App\Http\Livewire\Registration;

use Livewire\Component;

class RegistrationStepper extends Component
{
    public int $currentStep;
    public $userInfo;
    public $userCareer;
    public $userTraining;

    protected $listeners = [
        'userInfo' => 'handleFormData',
        'userCareer' => 'handleFormData',
        'userTraining' => 'handleFormData',
        'goBack'
     ];
     
     public function handleFormData($formData)
     {
         switch ($this->currentStep) {
             case 1:
                 $this->userInfo = $formData;
                 break;
             case 2:
                 $this->userCareer = $formData;
                 break;
             case 3:
                 $this->userTraining = $formData;
                 break;
         }
     
         $this->nextStep();
     }


    public function mount(int $currentStep = 1)
    {
        $this->currentStep = $currentStep;
    }


  


    public function render()
    {
        return view('livewire.registration.registration-stepper'); 
    }

    public function nextStep()
    {
    
        $this->currentStep++;
    }

    public function goBack()
    {
        $this->currentStep--;
    }

   



    
}
