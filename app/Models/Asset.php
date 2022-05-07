<?php

namespace App\Models;

use App\Models\Photo;
use App\Models\Pdf;

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

    public function pdfs()
    {
        return $this->hasMany(Pdf::class);
    }
}
