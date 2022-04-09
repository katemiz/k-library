<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('level', 'created_by')->withTimestamps();
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class)->withPivot('level', 'created_by')->withTimestamps();
    }

    public function diplomas()
    {
        return $this->belongsToMany(Diploma::class)->withPivot('status', 'created_by')->withTimestamps();
    }

    public function professions()
    {
        return $this->belongsToMany(Profession::class)->withPivot('provision', 'created_by')->withTimestamps();
    }

    public static function processItem($row) {

        $row["category"] = Category::getItemById($row["category"]);

        $row["created_by"] = User::select('id','name','lastname','email')->where('id', $row["created_by"])->first();
        $row["created_diff"] = Carbon::parse($row["created_at"])->diffForHumans();

        $row["updated_by"] = User::select('id','name','lastname','email')->where('id', $row["updated_by"])->first();
        $row["updated_diff"] = Carbon::parse($row["updated_at"])->diffForHumans();

        return $row;
    }

    public static function getItemById($id) {
        return Role::processItem(Role::find($id));
    }

    public static function getLatestItem() {
        return Role::processItem(Role::latest()->first());
    }

}
