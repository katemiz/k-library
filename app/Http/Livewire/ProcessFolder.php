<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

use Image;

class ProcessFolder extends Component
{
    public $tur = false;
    public $mime_types;
    public $img_mime_types;

    public $dosyalar = [];
    public $directories = [];

    public function mount()
    {
        $this->img_mime_types = Config::get('constants.file_vs_mime_types')[
            'img'
        ];

        if (request('tur') > 0) {
            $this->tur = request('tur');
            $this->mime_types = Config::get('constants.file_vs_mime_types')[
                $this->tur
            ];
        }
    }

    public function render()
    {
        $this->index();
        return view('livewire.process-folder');
    }

    public function index()
    {
        $files = Storage::files('gallery');

        foreach ($files as $file) {
            // $dosya = Storage::get($file);

            // $mimetype = Storage::mimeType($file);

            // dd($this->mime_types);

            $dosya = [
                'name' => basename($file),
                'size' => Storage::size($file),
            ];

            if ($this->tur) {
                $fmime = Storage::mimeType($file);

                if (
                    in_array($fmime, $this->img_mime_types) &&
                    Storage::size($file) < 2796113
                ) {
                    $dosya['thumbnail'] = Image::make(
                        Storage::path($file)
                    )->encode('data-url');

                    $dosya['exif'] = $this->exif(Storage::path($file));

                    // dd($dosya['thumbnail']);
                }

                if (in_array($fmime, $this->mime_types)) {
                    array_push($this->dosyalar, $dosya);
                }
            } else {
                array_push($this->dosyalar, $dosya);
            }
        }

        // dd($this->dosyalar);

        if (!$this->tur) {
            $this->directories = Storage::directories('gallery');
        }
    }

    public function exif($img)
    {
        $exif = exif_read_data($img, 'IFD0');

        if ($exif === false) {
            return false;
        }

        $edata['camera'] = $exif['Make'];
        $edata['datetaken'] = $exif['DateTimeOriginal'];
        $edata['location'] = isset($exif['GPS']) ? $exif['GPS'] : 'no location';

        return $edata;
    }
}
