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

    /*     protected function images(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                Record::query()
                    ->where([
                        ['asset_id', '=', $this->id],
                        ['classification', '=', 'image'],
                    ]),
        );
    }
 */

    /*     protected function docs(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                Record::query()
                    ->where([
                        ['asset_id', '=', $value],
                        ['classification', '=', 'doc'],
                    ]),
        );
    }

 */
}
