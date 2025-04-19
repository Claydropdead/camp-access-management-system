<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFIDCard extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rfid_cards';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'card_number',
        'personnel_id',
        'status',
        'issued_at',
        'expires_at',
        'notes',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
    
    /**
     * Get the personnel associated with the RFID card.
     */
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}
