<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Models\Diploma;

class DiplomaObserver
{
    public function creating(Diploma $diploma)
    {
        $user = Auth::user();
        $diploma->created_by = $user->id;
    }


    public function updating(Diploma $diploma)
    {
        $user = Auth::user();
        $diploma->updated_by = $user->id;
    }
}
