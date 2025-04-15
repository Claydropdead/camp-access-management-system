<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_registration_id', 'type', 'plate_number', 'color', 'model',
    ];

    public function registration()
    {
        return $this->belongsTo(VisitorRegistration::class, 'visitor_registration_id');
    }
}
