<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Asset;
use App\Models\Audio;
use App\Models\Document;
use App\Models\Dosya;
use App\Models\Gorsel;
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

class AssetView extends Component
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

        return view('livewire.asset-view', [
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

        foreach ($asset->images as $image) {
            Gorsel::find($image->id)->delete();
            Storage::delete($image->stored_as);
        }

        foreach ($asset->audio as $doc) {
            Audio::find($doc->id)->delete();
            Storage::delete($doc->stored_as);
        }

        foreach ($asset->video as $v) {
            Video::find($v->id)->delete();
            Storage::delete($v->stored_as);
        }

        foreach ($asset->dosyalar as $dosya) {
            Dosya::find($dosya->id)->delete();
            Storage::delete($dosya->stored_as);
        }

        foreach ($asset->docs as $doc) {
            Document::find($doc->id)->delete();
            Storage::delete($doc->stored_as);
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
