<?php

namespace App\Observers;

use App\Models\Language;
use Illuminate\Support\Facades\Auth;

class LanguageObserver
{
    /**
     * Handle the Language "created" event.
     *
     * @param  \App\Models\Language  $language
     * @return void
     */
    public function created(Language $language)
    {
        //
    }

    /**
     * Handle the Language "updated" event.
     *
     * @param  \App\Models\Language  $language
     * @return void
     */
    public function updated(Language $language)
    {
        //
    }

    /**
     * Handle the Language "deleted" event.
     *
     * @param  \App\Models\Language  $language
     * @return void
     */
    public function deleted(Language $language)
    {
        //
    }

    /**
     * Handle the Language "restored" event.
     *
     * @param  \App\Models\Language  $language
     * @return void
     */
    public function restored(Language $language)
    {
        //
    }

    /**
     * Handle the Language "force deleted" event.
     *
     * @param  \App\Models\Language  $language
     * @return void
     */
    public function forceDeleted(Language $language)
    {
        //
    }


    public function creating(Language $language)
    {
        $user = Auth::user();
        $language->created_by = $user->id;
    }


    public function updating(Language $language)
    {
        $user = Auth::user();
        $language->updated_by = $user->id;
    }
}
