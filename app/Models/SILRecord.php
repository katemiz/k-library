<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;

use Image;

class Record extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function exif($image)
    {
        $edata['mimetype'] = mime_content_type($image);
        $edata['has_exif'] = false;
        $edata['camera'] = '';
        $edata['datetaken'] = '';
        $edata['location'] = '';
        $edata['thumbnail'] = null;

        if (
            !in_array($edata['mimetype'], [
                'image/jpg',
                'image/jpeg',
                'image/gif',
            ])
        ) {
            return $edata;
        }

        $exif = exif_read_data($image, 'IFD0');

        if ($exif === false) {
            return $edata;
        }

        $edata['has_exif'] = true;
        $edata['camera'] = $exif['Make'];
        $edata['datetaken'] = $exif['DateTimeOriginal'];
        $edata['location'] = Record::get_image_location($image);
        $edata['thumbnail'] = Record::createThumbnail($image);

        return $edata;
    }

    public static function get_image_location($image = '')
    {
        $exif = exif_read_data($image, 0, true);
        if ($exif && isset($exif['GPS'])) {
            $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
            $GPSLatitude = $exif['GPS']['GPSLatitude'];
            $GPSLongitudeRef = $exif['GPS']['GPSLongitudeRef'];
            $GPSLongitude = $exif['GPS']['GPSLongitude'];

            $lat_degrees =
                count($GPSLatitude) > 0 ? Record::gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes =
                count($GPSLatitude) > 1 ? Record::gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds =
                count($GPSLatitude) > 2 ? Record::gps2Num($GPSLatitude[2]) : 0;

            $lon_degrees =
                count($GPSLongitude) > 0
                    ? Record::gps2Num($GPSLongitude[0])
                    : 0;
            $lon_minutes =
                count($GPSLongitude) > 1
                    ? Record::gps2Num($GPSLongitude[1])
                    : 0;
            $lon_seconds =
                count($GPSLongitude) > 2
                    ? Record::gps2Num($GPSLongitude[2])
                    : 0;

            $lat_direction =
                ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
            $lon_direction =
                ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

            $latitude =
                $lat_direction *
                ($lat_degrees + $lat_minutes / 60 + $lat_seconds / (60 * 60));
            $longitude =
                $lon_direction *
                ($lon_degrees + $lon_minutes / 60 + $lon_seconds / (60 * 60));

            return $latitude . ',' . $longitude;
        } else {
            return false;
        }
    }

    public static function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if (count($parts) <= 0) {
            return 0;
        }
        if (count($parts) == 1) {
            return $parts[0];
        }
        return floatval($parts[0]) / floatval($parts[1]);
    }

    public static function saveThumbnail($dosya)
    {
        Image::make(Storage::path($dosya))
            ->fit(150, 160)
            ->encode('data-url');
    }

    public static function createThumbnail($image)
    {
        Log::info('thumb dosya' . $image);

        //basename("/etc/sudoers.d").PHP_EOL
        return true;
        $thumbdir =
            '/usr' . Auth::id() . '/' . $dosya->getMimeType() . '/THUMBS';

        $yenidosya = Storage::disk('local')->put($thumbdir, $image);

        $thumbnail = Image::make($path)->resize($width, $height, function (
            $constraint
        ) {
            $constraint->aspectRatio();
        });
        $thumbnail->save($path);
    }

    /*     protected function thumbnail(): Attribute
    {
        if ($attributes['classification'] == 'image') {
            return Attribute::make(
                get: fn ($value, $attributes) =>
                    Image::make(Storage::path($this->stored_as))
                        ->fit(150, 160)
                        ->encode('data-url'),
            );
        } else {
            return null;
        }



    }

    protected function preview(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                Image::make(Storage::path($this->stored_as))
                    ->fit(300, 320)
                    ->encode('data-url'),
        );
    }
 */
}
