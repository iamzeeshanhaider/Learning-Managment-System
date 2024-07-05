<?php

namespace App\Http\Resources\API\V1;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'first_name' => $this->name,
            'last_name' => $this->lname,
            'username' => $this->username,
            'code' => $this->code,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'email' => $this->email,
            'phone' => $this->phone,
            'email_verified_at' => $this->email_verified_at,
            'designation' => $this->designation,
            'media_token' => $this->media_token,
            'slug' => $this->slug,
            'ethnicity' => $this->ethnicity,
            'status' => $this->status,
            'uk_status' => $this->uk_status,
            'has_completed_profile' => (bool) $this->has_completed_profile,
            'last_login' => $this->last_login,
            'last_login_ip_address' => $this->last_login_ip_address,
            'created_at' => $this->created_at,
            'avatar' => $this->avatar,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'roles' => RoleResource::collection($this->roles),
        ];

        // Check if $this->bio exists and add it to the data
        if ($this->bio) {
            $data['bio'] = static::getBio($this->bio);
        }
        if ($this->calendar_id) {
            $data['calendar_id'] = $this->calendar_id;
        }

        return $data;
    }

    public static function getInfoOnly(User $user)
    {
        return [
            'id' => $user->id,
            'first_name' => $user->name,
            'last_name' => $user->lname,
            'username' => $user->username,
            'gender' => $user->gender,
            'email' => $user->email,
            'phone' => $user->phone,
            'designation' => $user->designation,
            'slug' => $user->slug,
            'avatar' => $user->avatar,
        ];
    }

    public static function getBio($bio)
    {
        return [
            'student_id' => $bio->student_id,
            'nok_name' => $bio->nok_name,
            'nok_relation' => $bio->nok_relation,
            'nok_phone' => $bio->nok_phone,
            'nok_email' => $bio->nok_email,
            'qualification' => $bio->qualification,
            'employment_status' => $bio->employment_status,
            'years_of_experience' => $bio->years_of_experience,
            'how_did_you_hear_about_us' => $bio->how_did_you_hear_about_us,
            'professional_registration_body' => $bio->professional_registration_body,
            'att_level' => $bio->att_level,
            'signed_doc' => $bio->signed_doc,
        ];
    }
}
