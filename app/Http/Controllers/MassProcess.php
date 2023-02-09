<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MassProcess extends Controller
{
    public $tur;

    public $mime_types;

    public $ftypes = [
        'img' => ['image/jpeg', 'image/png', 'image/gif'],

        'audio' => ['audio/ogg', 'audio/webm', 'audio/mpeg', 'audio/webm'],

        'video' => [
            'video/ogg',
            'video/mp4',
            'video/mpeg',
            'video/x-ms-asf',
            'video/x-msvideo',
            'video/quicktime',
            'video/webm',
        ],

        'doc' => ['application/pdf'],
    ];

    public function __construct()
    {
        if (request('tur') > 0) {
            $this->tur = request('tur');
            $this->mime_types = $this->ftypes[$this->tur];
        }
    }

    public function index()
    {
        $files = Storage::files('gallery');

        foreach ($files as $file) {
            if (in_array($file->getMimeType(), $this->mime_types)) {
                $storedir = '/usr' . Auth::id() . '/' . $file->getMimeType();
                $saved_dir = Storage::disk('local')->put($storedir, $file);
            }
        }
    }

    public function addFiles($req, $id)
    {
        if ($req->has('assets')) {
            foreach ($req->file('assets') as $dosya) {
                if (strlen($dosya->getMimeType()) > 32) {
                    $filename = '/usr' . Auth::id() . '/file/other';
                } else {
                    $filename =
                        '/usr' . Auth::id() . '/' . $dosya->getMimeType();
                }

                $saved_dir = Storage::disk('local')->put($filename, $dosya);

                $this->saveRecord($dosya, $saved_dir);
            }
        }
    }

    public function saveRecord($dosya, $saved_dir)
    {
        $dosya_data = [
            'asset_id' => null,
            'user_id' => Auth::id(),
            'filename' => $dosya->getClientOriginalName(),
            'size' => $dosya->getSize(),
            'stored_as' => $saved_dir,
            'mimetype' => $dosya->getMimeType(),
        ];

        switch ($dosya->getMimeType()) {
            // IMAGE
            case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
                $exif_data = Gorsel::exif(Storage::path($saved_dir));
                $dosya_data = array_merge($dosya_data, $exif_data);

                $dosya_data['thumbnail'] = Gorsel::createThumb($saved_dir);

                Gorsel::create($dosya_data);

                break;

            // AUDIO
            case 'audio/ogg':
            case 'audio/webm':
            case 'audio/mpeg':
            case 'audio/webm':
                Audio::create($dosya_data);
                break;

            // VIDEO
            case 'video/ogg':
            case 'video/mp4':
            case 'video/mpeg':
            case 'video/x-ms-asf':
            case 'video/x-msvideo':
            case 'video/quicktime':
            case 'video/webm':
                $dosya_data['thumbnail'] = Video::createThumb($saved_dir);

                Video::create($dosya_data);
                break;

            // DOC
            case 'application/pdf':
                Document::create($dosya_data);
                break;

            // OTHER
            default:
                Dosya::create($dosya_data);
                break;
        }
    }
}
