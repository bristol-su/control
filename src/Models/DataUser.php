<?php


namespace BristolSU\ControlDB\Models;


use DateTime;
use Illuminate\Database\Eloquent\Model;

class DataUser extends Model implements \BristolSU\ControlDB\Contracts\Models\DataUser
{

    protected $table = 'control_data_user';
    
    protected $fillable = [
        'first_name', 'last_name', 'email', 'dob', 'preferred_name'
    ];
    
    protected $casts = [
        'dob' => 'date'
    ];

    public function setDobAttribute(?DateTime $dob)
    {
        if($dob !== null) {
            $this->attributes['dob'] = $dob->format('Y-m-d');
        }
    }
    
    public function setFirstName(?string $firstName): void
    {
        $this->first_name = $firstName;
        $this->save();
    }

    public function setLastName(?string $lastName): void
    {
        $this->last_name = $lastName;
        $this->save();
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
        $this->save();
    }

    public function setDob(?DateTime $dob): void
    {
        $this->dob = $dob;
        $this->save();
    }

    public function setPreferredName(?string $name): void
    {
        $this->preferred_name = $name;
        $this->save();
    }

    public function firstName(): string
    {
        return $this->first_name;
    }

    public function lastName(): string
    {
        return $this->last_name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function dob(): DateTime
    {
        return $this->dob;
    }

    public function preferredName(): string
    {
        return $this->preferred_name;
    }

    public function id()
    {
        return $this->id;
    }
}