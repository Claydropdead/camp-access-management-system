<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personnels';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'rank',
        'office',
        'unit',
        'department_subunit',
        'email',
        'contact_number',
        'picture',
    ];
    
    /**
     * Get the personnel's full name.
     */
    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . ($this->middlename ? $this->middlename . ' ' : '') . $this->lastname;
    }
    
    /**
     * Get the RFID cards assigned to this personnel.
     */
    public function rfidCards()
    {
        return $this->hasMany(RFIDCard::class, 'personnel_id');
    }
}
