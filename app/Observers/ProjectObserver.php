<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class ProjectObserver
{
    public function creating(Project $diploma)
    {
        $user = Auth::user();
        $diploma->created_by = $user->id;
    }


    public function updating(Project $diploma)
    {
        $user = Auth::user();
        $diploma->updated_by = $user->id;
    }
}
