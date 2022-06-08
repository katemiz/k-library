<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Asset;
use App\Models\Gorsel;
use App\Models\Audio;
use App\Models\Dosya;
use App\Models\Diger;
use App\Models\Video;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Log;

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

        if (Auth::id() !== $asset->owner_id) {
            return false;
        }

        return view('livewire.view', [
            'asset' => $asset,
            'notification' => $this->notification,
        ]);
    }

    public function showPhoto(Request $request, $assetId, $photoId)
    {
        $p = Gorsel::find($photoId);

        $request->id = $assetId; // needed for render()

        $this->isImgModalVisible = true;

        $this->photo_data = Gorsel::previewGorsel($p->stored_as);
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

        return redirect('/assets-list/assets', ['m' => 'delete']);
    }

    public function deletePhoto(Request $request, $assetId, $photoId)
    {
        Gorsel::find($photoId)->delete();
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
