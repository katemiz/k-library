<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Asset;
use App\Models\Image;

use Livewire\WithPagination;

class FilterBox extends Component
{
    public $query = '';

    public function render()
    {
        return view('livewire.filter-box');
    }
}
