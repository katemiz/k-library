<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;


class CategoryObserver
{
    public function creating(Category $category)
    {
        $user = Auth::user();
        $category->created_by = $user->id;
    }

    public function updating(Category $category)
    {
        $user = Auth::user();
        $category->updated_by = $user->id;
    }
}
