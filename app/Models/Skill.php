<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Skill extends Model
{
    use HasFactory;

    protected $parentColumn = 'parent_id';

    protected $guarded = ['id'];


    public function parent()
    {
        return $this->belongsTo(Skill::class,$this->parentColumn);
    }


    public function children()
    {
        return $this->hasMany(Skill::class, $this->parentColumn);
    }


    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }



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

        $records = Skill::orderBy('parent_id')->orderBy('title_en')->get()->toArray();

        $items = array();

        foreach ($records as $row) {            
            $items[]  = Skill::setUserTime($row);
        }

        return Skill::convertToTree($items);
    }


    public static function getLatestItem() {
        return Skill::setUserTime(Skill::latest()->first());
    }



    public static function getItemById($id) {
        return Skill::setUserTime(Skill::find($id));
    }


    public static function setUserTime($row) {

        $row["created_by"] = User::select('name','lastname','email')->where('id', $row["created_by"])->first();
        $row["created_diff"] = Carbon::parse($row["created_at"])->diffForHumans();

        $row["updated_by"] = User::select('name','lastname','email')->where('id', $row["updated_by"])->first();
        $row["updated_diff"] = Carbon::parse($row["updated_at"])->diffForHumans();

        return $row;
    }
}
