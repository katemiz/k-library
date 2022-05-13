<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
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

        if (!in_array($edata['mimetype'], ['image/jpeg'])) {
            return $edata;
        }

        $exif = exif_read_data($image, 'IFD0');

        if ($exif === false) {
            return $edata;
        }

        $edata['has_exif'] = true;
        $edata['camera'] = $exif['Make'];
        $edata['datetaken'] = $exif['DateTimeOriginal'];
        $edata['location'] = Photo::get_image_location($image);

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
                count($GPSLatitude) > 0 ? Photo::gps2Num($GPSLatitude[0]) : 0;
            $lat_minutes =
                count($GPSLatitude) > 1 ? Photo::gps2Num($GPSLatitude[1]) : 0;
            $lat_seconds =
                count($GPSLatitude) > 2 ? Photo::gps2Num($GPSLatitude[2]) : 0;

            $lon_degrees =
                count($GPSLongitude) > 0 ? Photo::gps2Num($GPSLongitude[0]) : 0;
            $lon_minutes =
                count($GPSLongitude) > 1 ? Photo::gps2Num($GPSLongitude[1]) : 0;
            $lon_seconds =
                count($GPSLongitude) > 2 ? Photo::gps2Num($GPSLongitude[2]) : 0;

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

    /*     public function showProfilePicture($path)
    {
        $profile_path = storage_path(
            'app/public/images/profile/' . $user_id . '/' . $filename
        );

        if (Auth::user()->id == $user_id) {
            return response()->file($profile_path);
        } else {
            abort(404);
        }
    } */
}
