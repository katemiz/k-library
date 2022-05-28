<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Asset;
use App\Models\Photo;
use App\Models\Music;

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

        switch ($request->type) {
            // ASSETS
            default:
            case 'assets':
                $q = Asset::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy($this->sortField, $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                $q->when(!empty($this->search), function ($sql) {
                    return $sql
                        ->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere(function ($query) {
                            $query->orWhere(
                                'notes',
                                'like',
                                '%' . $this->search . '%'
                            );
                        });
                });

                $items = $q->paginate(
                    Config::get('constants.table.no_of_results')
                );
                break;

            // PHOTOS
            case 'photos':
                $q = Photo::query()->orderBy(
                    $this->sortTimeField,
                    $this->sortTimeDirection
                );

                $q->where('user_id', '=', Auth::id());

                /*                 if (count($asset->photos) > 0) {
                    foreach ($asset->photos as $p) {
                        $files[$p->id] = Image::make(Storage::path($p->stored_as))
                            ->fit(300, 320)
                            ->encode('data-url');
                    }
                } */

                $items = $q->paginate(
                    Config::get('constants.table.thumbnails')
                );

                //dd($items);

                break;

            // PDFS
            case 'pdfs':
                $q = Pdf::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy($this->sortField, $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                $q->when(!empty($this->search), function ($sql) {
                    return $sql->where(
                        'org_name',
                        'like',
                        '%' . $this->search . '%'
                    );
                });

                $items = $q->paginate(
                    Config::get('constants.table.no_of_results')
                );
                break;

            // MUSIC
            case 'music':
                $q = Music::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy('org_name', $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                $q->when(!empty($this->search), function ($sql) {
                    return $sql->where(
                        'org_name',
                        'like',
                        '%' . $this->search . '%'
                    );
                });

                $items = $q->paginate(
                    Config::get('constants.table.no_of_results')
                );
                break;

            // VIDEO
            case 'videos':
                $q = Video::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy($this->sortField, $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                $q->when(!empty($this->search), function ($sql) {
                    return $sql->where(
                        'org_name',
                        'like',
                        '%' . $this->search . '%'
                    );
                });

                $items = $q->paginate(
                    Config::get('constants.table.no_of_results')
                );
                break;

            // OTHER
            case 'others':
                $q = Other::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy($this->sortField, $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                $q->when(!empty($this->search), function ($sql) {
                    return $sql->where(
                        'org_name',
                        'like',
                        '%' . $this->search . '%'
                    );
                });

                $items = $q->paginate(
                    Config::get('constants.table.no_of_results')
                );
                break;
        }

        $this->count = $q->count();

        return view('livewire.assets-table', [
            'type' => $request->type,
            'items' => $items,
            'notification' => $this->notification,
            'cols_per_row' => Config::get('constants.table.cols_per_row'),
        ]);
    }

    public function resetFilter()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
