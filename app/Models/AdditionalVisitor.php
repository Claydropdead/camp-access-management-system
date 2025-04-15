<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalVisitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_registration_id', 'name', 'contact_number',
    ];

    public function registration()
    {
        return $this->belongsTo(VisitorRegistration::class, 'visitor_registration_id');
    }
}
