<?php

namespace App\Models;

use Illuminate\Support\Facades\Config;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

use Image;

class Gorsel extends Model
{
    use HasFactory;

    protected $table = 'gorseller';

    protected $guarded = [];

    public static function exif($image)
    {
        $edata['mimetype'] = mime_content_type($image);
        $edata['has_exif'] = false;
        $edata['camera'] = '';
        $edata['datetaken'] = '';
        $edata['location'] = '';

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

        // dd($exif);

        if ($exif === false) {
            return $edata;
        }

        $edata['has_exif'] = true;
        $edata['camera'] = $exif['Make'];
        $edata['datetaken'] = $exif['DateTimeOriginal'];
        $edata['location'] = Gorsel::get_image_location($image);

        return $edata;
    }

    public static function get_image_location($image = '')
    {
        $exif = exif_read_data($image, 0, true);

        if ($exif && isset($exif['GPS'])) {

            if (!isset($exif['GPS']['GPSLatitudeRef']) || empty($exif['GPS']['GPSLatitudeRef']))
            {
                return false;
            }

            if (!isset($exif['GPS']['GPSLatitude']) || empty($exif['GPS']['GPSLatitude']))
            {
                return false;
            }

            if (!isset($exif['GPS']['GPSLongitudeRef']) || empty($exif['GPS']['GPSLongitudeRef']))
            {
                return false;
            }

            if (!isset($exif['GPS']['GPSLongitude']) || empty($exif['GPS']['GPSLongitude']))
            {
                return false;
            }

            $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
            $GPSLatitude = $exif['GPS']['GPSLatitude'];
            $GPSLongitudeRef = $exif['GPS']['GPSLongitudeRef'];
            $GPSLongitude = $exif['GPS']['GPSLongitude'];

            $lat_degrees =
                count($GPSLatitude) > 0 ? Gorsel::gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes =
                count($GPSLatitude) > 1 ? Gorsel::gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds =
                count($GPSLatitude) > 2 ? Gorsel::gps2Num($GPSLatitude[2]) : 0;

            $lon_degrees =
                count($GPSLongitude) > 0
                    ? Gorsel::gps2Num($GPSLongitude[0])
                    : 0;
            $lon_minutes =
                count($GPSLongitude) > 1
                    ? Gorsel::gps2Num($GPSLongitude[1])
                    : 0;
            $lon_seconds =
                count($GPSLongitude) > 2
                    ? Gorsel::gps2Num($GPSLongitude[2])
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

    public static function previewGorsel($imagepath)
    {

        $gorsel = Image::make(Storage::path($imagepath));
        $gorsel = $gorsel->orientate();

        return (string) $gorsel->encode('data-url');
    }

    public static function createThumb($imagepath)
    {
        $p = pathinfo($imagepath);

        $thumb =
            $p['dirname'] . '/THUMBS/' . $p['filename'] . '.' . $p['extension'];

        $intImg = Image::make(Storage::path($imagepath));
        $intImg = $intImg->orientate();

        $intImg->resize(Config::get('constants.thumbnail.max_dimension'), Config::get('constants.thumbnail.max_dimension'), function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        Storage::disk('local')->put($thumb, (string) $intImg->encode());

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
