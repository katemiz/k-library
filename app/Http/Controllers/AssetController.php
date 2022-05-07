<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

use App\Models\Asset;
use App\Models\Photo;
use App\Models\Pdf;

use Image;

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

    /*     public function fetch(Request $request)
    {

        $data = [
            'aa' => 'aaaaa',
            'bb' => 'bbbbb',
            'q' => Response::json($request->query),
        ];

        return Response::json($data);
    }
 */
    public function listall(Request $request)
    {
        if ($request->sc && $request->so) {
            $this->sortorders[$request->sc] = $request->so;
            $this->active_sortcolumn = $request->sc;
        }

        return view('asset.list', [
            'assets' => $this->getAssets($request),
            'sortorders' => $this->sortorders,
            'filters' => $request->only(['search']),
            'notification' => false,
        ]);
    }

    public function store(Request $req)
    {
        $assetdata['asset_type'] = $req->type;
        $assetdata['owner_id'] = Auth::id();
        $assetdata['user_id'] = Auth::id();
        $assetdata['title'] = $req->title;
        $assetdata['notes'] = $req->editor_data;

        $new_asset = Asset::create($assetdata);

        if ($req->has('assets')) {
            foreach ($req->file('assets') as $dosya) {
                $yenidosya = Storage::putFile(
                    'klibrary/usr' . Auth::id(),
                    $dosya,
                    'private'
                );

                $dosya_data = [
                    'asset_id' => $new_asset->id,
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

        return view('asset.view', [
            'asset' => Asset::latest()->first(),
            'notification' => [
                'type' => 'success',
                'message' => 'Asset has been added successfully',
            ],
        ]);
    }

    public function typeselect(Request $request)
    {
        return view('asset.typeselect');
    }

    public function forms(Request $request)
    {
        return view('asset.form', ['type' => $request->type]);
    }

    public function show(Request $request)
    {
        $asset = Asset::find($request->id);

        $notification = false;

        if (count($asset->photos) > 0) {
            foreach ($asset->photos as $p) {
                $files[$p->id] = Image::make(Storage::path($p->stored_as))
                    ->fit(300, 320)
                    ->encode('data-url');
            }
        } else {
            $files = [];
            $notification = [
                'type' => 'warning',
                'message' => 'No files for this asset yet!',
            ];
        }

        $asset->dosyalar = $files;

        return view('asset.view', [
            'asset' => $asset,
            'notification' => $notification,
        ]);
    }

    /*     public function resimCheck(Request $request, $imagename)
    {
        $profile_path = storage_path('app/public/images/' . $imagename);

        $img_token = Session::get('img_token');

        if ($img_token == $request->img_token) {
            Session::forget('img_token');
            return response()->file($profile_path);
        } else {
            abort(404);
        }
    } */
}
