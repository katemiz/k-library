<?php

namespace App\Models;

use App\Models\Photo;
use App\Models\Pdf;
use App\Models\Music;
use App\Models\Video;
use App\Models\Other;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function music()
    {
        return $this->hasMany(Music::class);
    }

    public function video()
    {
        return $this->hasMany(Video::class);
    }

    public function other()
    {
        return $this->hasMany(Other::class);
    }

    public function pdfs()
    {
        return $this->hasMany(Pdf::class);
    }
}
