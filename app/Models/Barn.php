<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barn extends Model
{
    use HasFactory;
    
    const LONG = 1;
    const SHORT = 2;
    
    protected $table = 'barn';
    
    protected $fillable = [
        'iid',
        'uid',
        'price',
        'type',
        'clinch',
        'clinch_id',
        'created_at',
        'updated_at',
    ];
    
    public static function other_type($type)
    {
        if($type == Barn::LONG) return Barn::SHORT;
        if($type == Barn::SHORT) return Barn::LONG;
    }
    
    public function item()
    {
        return $this->belongsTo(Item::class,'iid');
    }
}
