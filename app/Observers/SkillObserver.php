<?php

namespace App\Observers;

use App\Models\Skill;
use Illuminate\Support\Facades\Auth;

class SkillObserver
{
    /**
     * Handle the Skill "created" event.
     *
     * @param  \App\Models\Skill  $skill
     * @return void
     */

    public function creating(Skill $skill)
    {
        $user = Auth::user();
        $skill->created_by = $user->id;
    }




    public function created(Skill $skill)
    {
        $user = Auth::user();
        $skill->created_by = $user->id;
    }

    /**
     * Handle the Skill "updated" event.
     *
     * @param  \App\Models\Skill  $skill
     * @return void
     */
    public function updated(Skill $skill)
    {
        $user = Auth::user();
        $skill->updated_by = $user->id;
    }


    public function updating(Skill $skill)
    {
        $user = Auth::user();
        $skill->updated_by = $user->id;
    }





    /**
     * Handle the Skill "deleted" event.
     *
     * @param  \App\Models\Skill  $skill
     * @return void
     */
    public function deleted(Skill $skill)
    {
        //
    }

    /**
     * Handle the Skill "restored" event.
     *
     * @param  \App\Models\Skill  $skill
     * @return void
     */
    public function restored(Skill $skill)
    {
        //
    }

    /**
     * Handle the Skill "force deleted" event.
     *
     * @param  \App\Models\Skill  $skill
     * @return void
     */
    public function forceDeleted(Skill $skill)
    {
        //
    }
}