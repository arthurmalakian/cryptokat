<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Coin extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'coin_title',
        'coin_abbreviation',
        'coin_description',
        'gecko_id',
    ];

    public function history()
    {
        return $this->hasMany(History::class,'coin_id','id');
    }
}
