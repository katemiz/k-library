<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Asset;
use App\Models\Image;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use Livewire\WithPagination;

class AssetsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $count;

    public $notification = false;
    //public $assets = [];

    public $sortField = 'title';
    public $sortDirection = 'asc';

    public $sortTimeField = 'created_at';
    public $sortTimeDirection = 'desc';

    public function paginationView()
    {
        return 'livewire::my-pagination';
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection =
                $this->sortDirection === 'asc' ? 'desc' : 'asc';
        }

        if ($this->sortTimeField === $field) {
            $this->sortTimeDirection =
                $this->sortTimeDirection === 'asc' ? 'desc' : 'asc';
        }
    }

    public function render(Request $request)
    {
        if ($request->m) {
            $this->notification = [
                'type' => 'is-primary',
                'message' =>
                    'Asset and its files has been deleted successfully',
            ];
        }

        $q = Asset::query()
            ->orderBy($this->sortTimeField, $this->sortTimeDirection)
            ->orderBy($this->sortField, $this->sortDirection);

        $q->where('user_id', '=', Auth::id());

        $q->when(!empty($this->search), function ($sql) {
            return $sql
                ->where('title', 'like', '%' . $this->search . '%')
                ->orWhere(function ($query) {
                    $query->orWhere('notes', 'like', '%' . $this->search . '%');
                });
        });

        // $this->assets = $q
        //     ->paginate(Config::get('constants.table.no_of_results'))
        //     ->toArray();

        $assets = $q->paginate(Config::get('constants.table.no_of_results'));

        $this->count = $q->count();

        return view('livewire.assets-table', [
            'assets' => $assets,
            'notification' => $this->notification,
        ]);
    }

    public function resetFilter()
    {
        $this->search = '';
        $this->resetPage();
        /*         $this->search = '';

        $this->sortField = 'title';
        $this->sortDirection = 'asc';

        $this->sortTimeField = 'created_at';
        $this->sortTimeDirection = 'asc'; */
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
