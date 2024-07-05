<?php

namespace App\Http\Livewire\Registration;

use Livewire\Component;
use App\Models\User;

class UserInfo extends Component

{
    public $title;
    public $user_name;
    public $city;
    public $last_name;
    public $locationname;
    public $dateofbirth;
    public $ethnicityname;
    public $contact_number;
    public $statusuk;
    public $email;
    public $kinname;
    public $gender;
    public $kin_relation;
    public $address;
    public $kin_phone;

    protected $rules = [
        'title' => 'required',
        'user_name' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'locationname' => 'required',
        'dateofbirth' => 'required|date',
        'ethnicityname' => 'required',
        'contact_number' => 'required|string|max:255',
        'statusuk' => 'required',
        'email' => 'required|max:255',
        'kinname' => 'required|max:255',
        'gender' => 'required|max:255',
        'kin_relation' => 'required|max:255',
        'address' => 'required|max:255',
        'kin_phone' => 'required|max:255',

    ];


    public function render()
    {
        return view('livewire.registration.user-info');
    }

    public function storeData()
    {
    //    $this->validate();

        $data = [
            'title' => $this->title,
            'user_name' => $this->user_name,
            'city' => $this->city,
            'last_name' => $this->last_name,
            'locationname' => $this->locationname,
            'dateofbirth' => $this->dateofbirth,
            'ethnicityname' => $this->ethnicityname,
            'contact_number' => $this->contact_number,
            'statusuk' => $this->statusuk,
            'email' => $this->email,
            'kinname' => $this->kinname,
            'gender' => $this->gender,
            'kin_relation' => $this->kin_relation,
            'address' => $this->address,
            'kin_phone' => $this->kin_phone,
        ];

        $this->emit('userInfo', $data);

    }

}
