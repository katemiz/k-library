<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Models\Role;


class RoleObserver
{
    public function creating(Role $role)
    {
        $user = Auth::user();
        $role->created_by = $user->id;
    }

    public function updating(Role $role)
    {
        $user = Auth::user();
        $role->updated_by = $user->id;
    }
}
