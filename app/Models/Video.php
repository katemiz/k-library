<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

use Image;
use FFMpeg;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'video';

    public static function createThumb($videopath)
    {
        $p = pathinfo($videopath);

        $thumb = $p['dirname'] . '/THUMBS/' . $p['filename'] . '.png';

        $thumbdir = $p['dirname'] . '/THUMBS/';
        $thumbfname = $p['filename'] . '.png';

        FFMpeg::open($videopath)
            ->getFrameFromSeconds(10)
            ->export()
            ->toDisk('local')
            ->save($thumb);

        return $thumb;
    }

    protected function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                Image::make(Storage::path($value))
                    ->encode('data-url'),
        );
    }

}
