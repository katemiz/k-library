<?php

namespace App\Models;

use App\Models\Gorsel;
use App\Models\Audio;
use App\Models\Dosya;
use App\Models\Document;
use App\Models\Video;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Carbon;

class Asset extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(Gorsel::class);
    }

    public function dosyalar()
    {
        return $this->hasMany(Dosya::class);
    }

    public function video()
    {
        return $this->hasMany(Video::class);
    }

    public function audio()
    {
        return $this->hasMany(Audio::class);
    }

    public function docs()
    {
        return $this->hasMany(Document::class);
    }


    public function getAttachmentNumber()
    {
        return $this->images()->count()+$this->dosyalar()->count()+$this->video()->count()+$this->audio()->count()+$this->docs()->count();
    }

    protected function carbonCreatedAt(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => Carbon::parse(
                $attributes['created_at']
            )->diffForHumans(),
        );
    }

}
