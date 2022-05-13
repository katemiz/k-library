<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Asset;
use App\Models\Photo;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use Image;

class AssetsView extends Component
{
    public $isImgModalVisible = false;
    public $pdata = '';
    public $notification = false;

    public function render(Request $request)
    {
        $asset = Asset::find($request->id);

        $asset->carbondate = Carbon::parse($asset->created_at)->diffForHumans();

        if (Auth::id() !== $asset->owner_id) {
            return false;
        }

        $notification = false;
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

    public function showPhoto(Request $request, $assetId, $photoId)
    {
        $p = Photo::find($photoId);

        $request->id = $assetId;

        $this->pdata = Storage::url($p->stored_as);

        $this->isImgModalVisible = true;
    }

    public function closeModal(Request $request, $assetId)
    {
        $request->id = $assetId;

        $this->isImgModalVisible = false;
    }
}
