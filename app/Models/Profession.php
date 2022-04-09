<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;


class Profession extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function processItem($item) {

        $item["created_by"] = User::select('name','lastname','email')->where('id', $item["created_by"])->first();
        $item["created_diff"] = Carbon::parse($item["created_at"])->diffForHumans();

        $item["updated_by"] = User::select('name','lastname','email')->where('id', $item["updated_by"])->first();
        $item["updated_diff"] = Carbon::parse($item["updated_at"])->diffForHumans();

        return $item;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }


    public static function getItemById($id) {
        return Profession::processItem(Profession::find($id));
    }


    public static function getLatestItem() {
        return Profession::processItem(Profession::latest()->first());
    }
}
