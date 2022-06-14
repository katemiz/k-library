<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

use App\Models\Asset;
use App\Models\Gorsel;
use App\Models\Audio;
use App\Models\Dosya;
use App\Models\Document;
use App\Models\Video;

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
    public $addedfiles = [];

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

    public function stats()
    {
        $counts['asset'] = Asset::where([
            ['user_id', '=', Auth::id()],
            ['is_fake', '=', 0],
        ])->count();

        $counts['image'] = Gorsel::where([
            ['user_id', '=', Auth::id()],
        ])->count();

        $counts['audio'] = Audio::where([
            ['user_id', '=', Auth::id()],
        ])->count();

        $counts['video'] = Video::where([
            ['user_id', '=', Auth::id()],
        ])->count();

        $counts['document'] = Document::where([
            ['user_id', '=', Auth::id()],
        ])->count();

        $counts['dosya'] = Dosya::where([
            ['user_id', '=', Auth::id()],
        ])->count();

        return view('dashboard', [
            'counts' => $counts,
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

    public function storefiles(Request $req)
    {
        $assetdata['owner_id'] = Auth::id();
        $assetdata['user_id'] = Auth::id();
        $assetdata['is_fake'] = true;
        $assetdata['title'] = 'Files uploaded';
        $assetdata['notes'] = '';

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
                if (strlen($dosya->getMimeType()) > 32) {
                    $filename = '/usr' . Auth::id() . '/file/other';
                } else {
                    $filename =
                        '/usr' . Auth::id() . '/' . $dosya->getMimeType();
                }

                $saved_dir = Storage::disk('local')->put($filename, $dosya);

                $this->saveRecord($dosya, $id, $saved_dir);
            }
        }
    }

    public function deleteFiles($req, $id)
    {
        if (strlen(trim($req->filesToDelete)) < 1) {
            return true;
        }

        foreach (json_decode($req->filesToDelete) as $key => $dizin) {
            if (count($dizin) > 0) {
                foreach ($dizin as $id) {
                    switch ($key) {
                        case 'image':
                            $attach = Gorsel::find($id);
                            break;

                        case 'audio':
                            $attach = Audio::find($id);
                            break;

                        case 'video':
                            $attach = Video::find($id);
                            break;

                        case 'doc':
                            $attach = Document::find($id);
                            break;

                        case 'dosya':
                            $attach = Dosya::find($id);
                            break;
                    }

                    Storage::delete($attach->stored_as);
                    $attach->delete();
                }
            }
        }

        return true;
    }

    public function deleteattach(Request $request)
    {
        switch ($request->type) {
            case 'image':
                $attach = Gorsel::find($request->id);
                break;

            case 'audio':
                $attach = Audio::find($request->id);
                break;

            case 'video':
                $attach = Video::find($request->id);
                break;

            case 'doc':
                $attach = Document::find($request->id);
                break;

            case 'dosya':
                $attach = Dosya::find($request->id);
                break;
        }

        Storage::delete($attach->stored_as);
        $attach->delete();

        $ass = Asset::find($request->asset_id);

        if ($ass->getAttachmentNumber() > 0) {
            return view('asset-view', [
                'id' => $request->asset_id,
            ]);
        } else {
            $ass->delete();
            return view('/list-records', ['type' => 'assetf']);
        }
    }

    public function forms(Request $request)
    {
        $asset = false;
        $is_fake = false;

        if ($request->id) {
            $asset = Asset::find($request->id);
            $is_fake = $asset->is_fake;
        }

        return view('form', [
            'asset' => $asset,
            'addfilesonly' => $is_fake,
        ]);
    }

    public function addfilesform()
    {
        $asset = false;

        return view('form', ['asset' => $asset, 'addfilesonly' => true]);
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

    public function saveRecord($dosya, $id, $saved_dir)
    {
        $dosya_data = [
            'asset_id' => $id,
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
