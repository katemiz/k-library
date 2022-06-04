<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use App\Models\Asset;
use App\Models\Photo;
use App\Models\Pdf;
use App\Models\Music;
use App\Models\Video;
use App\Models\Other;

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

    public function stats(Request $req)
    {
        return view('dashboard', [
            'assets_count' => Asset::where([
                ['user_id', '=', Auth::id()],
                ['is_fake', '=', 0],
            ])->count(),
            'images_count' => Photo::where('user_id', '=', Auth::id())->count(),
            'docs_count' => Pdf::where('user_id', '=', Auth::id())->count(),
            'audio_count' => Music::where('user_id', '=', Auth::id())->count(),
            'video_count' => Video::where('user_id', '=', Auth::id())->count(),
            'others_count' => Other::where('user_id', '=', Auth::id())->count(),
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
        $assetdata['title'] = 'Container fake asset';
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

                $yenidosya = Storage::disk('local')->put($filename, $dosya);

                $dosya_data = [
                    'asset_id' => $id,
                    'user_id' => Auth::id(),
                    'org_name' => $dosya->getClientOriginalName(),
                    'size' => $dosya->getSize(),
                    'stored_as' => $yenidosya,
                    'mimetype' => $dosya->getMimeType(),
                ];

                Log::info('$dosya->getMimeType() = ' . $dosya->getMimeType());

                switch ($dosya->getMimeType()) {
                    // PHOTO
                    case 'image/jpeg':
                    case 'image/png':
                    case 'image/gif':
                        $exif_data = Photo::exif(Storage::path($yenidosya));
                        $dosya_data = array_merge($dosya_data, $exif_data);
                        $newfile = Photo::create($dosya_data);
                        $this->addedfiles['photo'][] = $newfile->id;
                        break;

                    // MUSIC
                    case 'audio/ogg':
                    case 'audio/webm':
                    case 'audio/mpeg':
                    case 'audio/webm':
                        $newfile = Music::create($dosya_data);
                        $this->addedfiles['music'][] = $newfile->id;
                        break;

                    // VIDEO
                    case 'video/ogg':
                    case 'video/mp4':
                    case 'video/mpeg':
                    case 'video/x-ms-asf':
                    case 'video/x-msvideo':
                    case 'video/quicktime':
                    case 'video/webm':
                        $newfile = Video::create($dosya_data);
                        $this->addedfiles['video'][] = $newfile->id;
                        break;

                    // BOOK
                    case 'application/pdf':
                        $newfile = Pdf::create($dosya_data);
                        $this->addedfiles['pdf'][] = $newfile->id;
                        break;

                    // OTHER
                    default:
                        $newfile = Other::create($dosya_data);
                        $this->addedfiles['other'][] = $newfile->id;
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
            $asset->attachments = $asset->images->merge($asset->docs);
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
