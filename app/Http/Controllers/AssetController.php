<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

use App\Models\Asset;
use App\Models\Photo;
use App\Models\Pdf;

use Image;
use Carbon\Carbon;

use Livewire\WithPagination;

class AssetController extends Controller
{
    use WithPagination;

    public $sortorders = [
        'title' => 'asc',
        'created_at' => 'asc',
    ];

    public $active_sortcolumn = 'title';

    public function getAssets($request)
    {
        $params = false;

        if ($request->input('search')) {
            $params['search'] = $request->input('search');
        }

        return Asset::query()
            ->where('user_id', '=', Auth::id())
            ->orderBy(
                $this->active_sortcolumn,
                $this->sortorders[$this->active_sortcolumn]
            )
            ->when($params, function ($query, $params) {
                if (isset($params['search']) && !empty($params['search'])) {
                    $query->where(
                        'title',
                        'like',
                        '%' . $params['search'] . '%'
                    );
                }
            })
            ->paginate(Config::get('constants.table.no_of_results'))
            // ->through(fn($item) => Language::processItem($item))
            ->withQueryString()
            ->toArray();
    }

    public function stats(Request $req)
    {
        return view('dashboard', [
            'asset_count' => Asset::where('user_id', '=', Auth::id())->count(),
            'photo_count' => Photo::where('user_id', '=', Auth::id())->count(),
            'pdf_count' => Pdf::where('user_id', '=', Auth::id())->count(),
        ]);
    }

    public function store(Request $req)
    {
        $assetdata['owner_id'] = Auth::id();
        $assetdata['user_id'] = Auth::id();
        $assetdata['title'] = $req->title;
        $assetdata['notes'] = $req->editor_data;

        $new_asset = Asset::create($assetdata);

        $this->addFiles($req, $new_asset->id);

        return redirect()->route('view', ['id' => $new_asset->id]);
    }

    public function update(Request $req)
    {
        Asset::find($req->id)->update([
            'title' => $req->title,
            'notes' => $req->editor_data,
        ]);

        $this->addFiles($req, $req->id);
        $this->deleteFiles($req, $req->id);

        return redirect()->route('view', ['id' => $req->id]);
    }

    public function addFiles($req, $id)
    {
        if ($req->has('assets')) {
            foreach ($req->file('assets') as $dosya) {
                $filename = '/usr' . Auth::id() . '/' . $dosya->getMimeType();

                $yenidosya = Storage::disk('local')->put($filename, $dosya);

                $dosya_data = [
                    'asset_id' => $id,
                    'user_id' => Auth::id(),
                    'org_name' => $dosya->getClientOriginalName(),
                    'size' => $dosya->getSize(),
                    'stored_as' => $yenidosya,
                    'mimetype' => $dosya->getMimeType(),
                ];

                switch ($dosya->getMimeType()) {
                    // PHOTO
                    case 'image/jpeg':
                    case 'image/png':
                    case 'image/gif':
                        $exif_data = Photo::exif(Storage::path($yenidosya));
                        $dosya_data = array_merge($dosya_data, $exif_data);
                        Photo::create($dosya_data);
                        break;

                    // BOOK
                    default:
                    case 'application/pdf':
                        Pdf::create($dosya_data);
                        break;
                }
            }
        }
    }

    public function deleteFiles($req, $id)
    {
        if (strlen(trim($req->filesToDelete)) < 1) {
            return true;
        }

        $files = explode(',', $req->filesToDelete);

        if (count($files) > 0) {
            foreach ($files as $attach) {
                $pieces = explode('_', $attach);

                $mimetype = $pieces['0'];
                $id = $pieces['1'];

                switch ($mimetype) {
                    // PHOTO
                    case 'image/jpeg':
                    case 'image/png':
                    case 'image/gif':
                        $attach = Photo::find($id);
                        break;

                    // BOOK
                    default:
                    case 'application/pdf':
                        $attach = Pdf::find($id);
                        break;
                }

                Storage::delete($attach->stored_as);
                $attach->delete();
            }
        }

        return true;
    }

    public function forms(Request $request)
    {
        $asset = false;

        if ($request->id) {
            $asset = Asset::find($request->id);
            $asset->attachments = $asset->photos->merge($asset->pdfs);
        }

        return view('asset.form', ['asset' => $asset, 'addfilesonly' => false]);
    }

    public function addfilesform(Request $request)
    {
        $asset = false;

        return view('asset.form', ['asset' => $asset, 'addfilesonly' => true]);
    }

    public function show(Request $request)
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

        return view('asset.view', [
            'asset' => $asset,
            'notification' => $notification,
        ]);
    }
}
