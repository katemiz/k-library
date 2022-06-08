<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Gorsel;
use App\Models\Audio;
use App\Models\Dosya;
use App\Models\Document;
use App\Models\Video;

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
                'Test File',
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
                'Test File',
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
