<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Audio;
use App\Models\Dosya;
use App\Models\Document;

class FileAccessController extends Controller
{
    public function audio($id)
    {
        $audio = Audio::find($id);

        if (!$this->checkPermission($audio->user_id)) {
            abort(404, 'No permission!');
        }

        $dosya = Storage::path($audio->stored_as);

        if (file_exists($dosya)) {
            $headers = [
                'Content-Type' => $audio->mimetype,
            ];

            return response()->download(
                $dosya,
                $audio->filename,
                $headers,
                'inline'
            );
        } else {
            abort(404, 'File not found!');
        }
    }

    public function docs($id)
    {
        $doc = Document::find($id);

        if (!$this->checkPermission($doc->user_id)) {
            abort(404, 'No permission!');
        }

        $dosya = Storage::path($doc->stored_as);

        if (file_exists($dosya)) {
            $headers = [
                'Content-Type' => $doc->mimetype,
            ];

            return response()->download(
                $dosya,
                $doc->filename,
                $headers,
                'inline'
            );
        } else {
            abort(404, 'File not found!');
        }
    }

    public function dosya($id)
    {
        $d = Dosya::find($id);

        if (!$this->checkPermission($d->user_id)) {
            abort(404, 'No permission!');
        }

        $dosya = Storage::path($d->stored_as);

        if (file_exists($dosya)) {
            $headers = [
                'Content-Type' => $d->mimetype,
            ];

            return response()->download(
                $dosya,
                $d->filename,
                $headers,
                'inline'
            );
        } else {
            abort(404, 'File not found!');
        }
    }

    public function checkPermission($uid)
    {
        if (Auth::id() === $uid) {
            return true;
        } else {
            return false;
        }
    }
}
