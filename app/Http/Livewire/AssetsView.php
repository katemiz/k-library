<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Asset;
use App\Models\Photo;
use App\Models\Pdf;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

use Carbon\Carbon;
use Image;

class AssetsView extends Component
{
    public $isImgModalVisible = false;
    public $photo_data = '';
    public $notification = false;

    public $icerik = '';

    public function render(Request $request)
    {
        $asset = Asset::find($request->id);

        $asset->carbondate = Carbon::parse($asset->created_at)->diffForHumans();

        if (Auth::id() !== $asset->owner_id) {
            return false;
        }

        $files = [];

        if (count($asset->photos) > 0) {
            foreach ($asset->photos as $p) {
                $files[$p->id] = Image::make(Storage::path($p->stored_as))
                    ->fit(300, 320)
                    ->encode('data-url');
            }
        }

        $asset->dosyalar = $files;

        return view('livewire.view', [
            'asset' => $asset,
            'notification' => $this->notification,
        ]);
    }

    public function showPhotoHold(Request $request, $assetId, $photoId)
    {
        $p = Photo::find($photoId);

        $request->id = $assetId;
        $this->isImgModalVisible = true;

        if (!File::exists(Storage::path($p->stored_as))) {
            abort(404);
        }

        $file = File::get(Storage::path($p->stored_as));
        $type = File::mimeType(Storage::path($p->stored_as));

        $response = Response::make($file, 200);

        $response->header('Content-Type', $type);

        $this->icerik = $response;

        return $response;
    }

    public function showPhoto(Request $request, $assetId, $photoId)
    {
        $p = Photo::find($photoId);

        $request->id = $assetId; // needed for render()

        $this->isImgModalVisible = true;

        $this->photo_data = (string) Image::make(
            Storage::path($p->stored_as)
        )->encode('data-url');
    }

    public function deleteAsset(Request $request, $assetId, $photoId)
    {
        $asset = Asset::find($assetId);

        foreach ($asset->photos as $photo) {
            Photo::find($photo->id)->delete();
            Storage::delete($photo->stored_as);
        }

        foreach ($asset->pdfs as $pdf) {
            Pdf::find($pdf->id)->delete();
            Storage::delete($pdf->stored_as);
        }

        $asset->delete();

        return redirect()->route('myassets', ['m' => 'delete']);
    }

    public function deletePhoto(Request $request, $assetId, $photoId)
    {
        Photo::find($photoId)->delete();
        $request->id = $assetId; // needed for render()

        $this->notification = [
            'type' => 'is-success',
            'message' => 'Image has been deleted',
        ];
    }

    public function closeModal(Request $request, $assetId)
    {
        $request->id = $assetId; // needed for render()

        $this->isImgModalVisible = !$this->isImgModalVisible;
    }
}
