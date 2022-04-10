<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use Carbon\Carbon;

class Asset extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function convertToTree(array $array)
    {
        $indexed = array();
        // first pass - get the array indexed by the primary id
        foreach ($array as $row) {
            $row["level"] = 0;
            $indexed[$row["id"]]             = $row;
            $indexed[$row["id"]]['children'] = array();
        }

        // second pass
        $root = array();
        foreach ($indexed as $id => $row) {

            $pid = $indexed[$id]['parent_id'];

            if ($pid == 0) {
                $indexed[$id]["level"] = 0;
            } else {
                $indexed[$id]["level"] = $indexed[$pid]["level"]+1;
            }

            $indexed[$row['parent_id']]['children'][] = &$indexed[$id];

            if (!$row['parent_id']) {
                $root[] = &$indexed[$id];
            }
        }
        return $root;
    }



    public static function getTreeData() {

        $records = Asset::orderBy('parent_id')->orderBy('title_en')->get()->toArray();

        $items = array();

        foreach ($records as $row) {            
            $items[]  = Asset::setUserTime($row);
        }

        return Asset::convertToTree($items);
    }

    public static function getLatestItem() {

        $latest = Asset::latest()->first();
        return Asset::setUserTime($latest);
    }



    public static function getItemById($id) {
        return Asset::setUserTime(Asset::find($id));
    }



    public static function setUserTime($item) {

        $item["created_by"] = User::select('name','lastname','email')->where('id', $item["created_by"])->first();
        $item["created_diff"] = Carbon::parse($item["created_at"])->diffForHumans();

        $item["updated_by"] = User::select('name','lastname','email')->where('id', $item["updated_by"])->first();
        $item["updated_diff"] = Carbon::parse($item["updated_at"])->diffForHumans();

        return $item;
    }

}
