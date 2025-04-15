<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'contact_number', 'id_type', 'id_picture', 'purpose', 'message',
        'is_group', 'group_size', 'visit_date', 'visit_time', 'contact_person', 'office',
        'has_vehicle', 'status',
    ];

    public function additionalVisitors()
    {
        return $this->hasMany(AdditionalVisitor::class);
    }

    public function vehicles()
    {
        return $this->hasMany(VisitorVehicle::class);
    }
}
