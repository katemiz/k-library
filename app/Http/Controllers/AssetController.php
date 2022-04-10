<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use App\Models\Asset;

class AssetController extends Controller
{
    public function getdata($request)
    {
        $sortcolumn = 'title';
        $sortorder = 'asc';

        if ($request->input('sortcolumn')) {
            $sortcolumn = $request->input('sortcolumn');
        }

        if ($request->input('sortorder')) {
            $sortorder = $request->input('sortorder');
        }

        $params = false;

        if ($request->input('search')) {
            $params['search'] = $request->input('search');
        }

        if ($request->input('userid')) {
            $params['created_by'] = $request->input('userid');
        }

        $getdata = Asset::query()
            ->orderBy($sortcolumn, $sortorder)
            ->when($params, function ($query, $params) {
                if (isset($params['search']) && !empty($params['search'])) {
                    $query->where(
                        'title',
                        'like',
                        '%' . $params['search'] . '%'
                    );
                }

                if (
                    isset($params['asset_type']) &&
                    !empty($params['asset_type'])
                ) {
                    $query->where('asset_type', '=', $params['asset_type']);
                }

                if (isset($params['userid']) && !empty($params['userid'])) {
                    $query->where('created_by', '=', $params['userid']);
                }
            })
            ->paginate(Config::get('constants.table.no_of_results'))
            ->through(fn($item) => Asset::processItem($item))
            ->withQueryString();

        return $getdata;
    }

    public function list(Request $request)
    {
        return Inertia::render('Asset/List', [
            'assetType' => $request->asset_type,
            'tableData' => $this->getdata($request),
            'filters' => $request->only(['search']),
            'notification' => false,
        ]);
    }

    public function typeselect(Request $request)
    {
        return Inertia::render('Asset/TypeSelect');
    }

    public function form(Request $request)
    {
        return Inertia::render('Asset/Form', [
            'asset_type' => $request->asset_type,
            'item' => false,
        ]);
    }
}
