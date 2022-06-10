<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;

use Image;

class Dosya extends Model
{
    use HasFactory;
    protected $table = 'dosyalar';

    protected $guarded = [];
}
