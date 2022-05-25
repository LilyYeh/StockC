<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    
    protected $table = 'item';
    
    protected $fillable = [
        'name',
        'market_price',
        'image',
        'created_at',
        'updated_at',
    ];
    
    public function barns()
    {
        return $this->hasMany(Barn::class,'iid');
    }
}
