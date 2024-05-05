<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'TIM',
        'TDG',
        'TP',
        'TI',
        'TO',
        'statut'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'TIM' => 'integer',
        'TDG' => 'integer',
        'TP' => 'integer',
        'TI' => 'integer',
        'TO' => 'integer',
    ];

   // Dans le modèle Machine
public function user() {
    return $this->belongsTo(User::class);
}

}
