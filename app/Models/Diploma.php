<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;


class Diploma extends Model
{
    use HasFactory;

    protected $parentColumn = 'parent_id';

    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(Diploma::class,$this->parentColumn);
    }

    public function children()
    {
        return $this->hasMany(Diploma::class, $this->parentColumn);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public static function getItemById($id) {
        return Diploma::processItem(Diploma::find($id));
    }


    public static function getLatestItem() {
        return Diploma::processItem(Diploma::latest()->first());
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public static function processItem($item) {

        $item["created_by"] = User::select('name','lastname','email')->where('id', $item["created_by"])->first();
        $item["created_diff"] = Carbon::parse($item["created_at"])->diffForHumans();

        $item["updated_by"] = User::select('name','lastname','email')->where('id', $item["updated_by"])->first();
        $item["updated_diff"] = Carbon::parse($item["updated_at"])->diffForHumans();

        return $item;
    }
}



