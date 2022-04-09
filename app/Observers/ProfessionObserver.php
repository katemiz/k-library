<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Models\Profession;

class ProfessionObserver
{
    public function creating(Profession $profession)
    {
        $user = Auth::user();
        $profession->created_by = $user->id;
    }

    public function updating(Profession $profession)
    {
        $user = Auth::user();
        $profession->updated_by = $user->id;
    }
}
