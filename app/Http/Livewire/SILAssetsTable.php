<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Asset;
use App\Models\Audio;
use App\Models\Document;
use App\Models\Dosya;
use App\Models\Gorsel;
use App\Models\Video;

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
            default:
            case 'assets':
                $q = Asset::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy($this->sortField, $this->sortDirection);

                $q->where('user_id', '=', Auth::id());
                $q->where('is_fake', '=', 0);

                if (strlen($this->search) > 0) {
                    $q->where('title', 'like', '%' . $this->search . '%');
                    $q->orwhere('notes', 'like', '%' . $this->search . '%');
                }

                $items = $q->paginate(
                    Config::get('constants.table.no_of_results')
                );
                break;

            case 'images':
                $q = Gorsel::query()->orderBy(
                    $this->sortTimeField,
                    $this->sortTimeDirection
                );

                $q->where('user_id', '=', Auth::id());

                if (strlen($this->search) > 0) {
                    $q->where('org_name', 'like', '%' . $this->search . '%');
                }

                $items = $q->paginate(
                    Config::get('constants.table.thumbnails')
                );

                break;

            case 'docs':
                $q = Document::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy('org_name', $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                if (strlen($this->search) > 0) {
                    $q->where('org_name', 'like', '%' . $this->search . '%');
                }

                $items = $q->paginate(
                    Config::get('constants.table.no_of_results')
                );
                break;

            // AUDIO
            case 'audio':
                $q = Audio::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy('org_name', $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                if (strlen($this->search) > 0) {
                    $q->where('org_name', 'like', '%' . $this->search . '%');
                }

                /*                 $items = $q->paginate(
                    Config::get('constants.table.no_of_results')
                ); */

                // Log::info('ITEMS = ' . $items);

                //$request->type = 'audio';
                break;

            // VIDEO
            case 'video':
                $q = Video::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy('org_name', $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                if (strlen($this->search) > 0) {
                    $q->where('org_name', 'like', '%' . $this->search . '%');
                }

                $items = $q->paginate(
                    Config::get('constants.table.no_of_results')
                );
                break;

            // OTHER
            case 'others':
                $q = Dosya::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy('org_name', $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                if (strlen($this->search) > 0) {
                    $q->where('org_name', 'like', '%' . $this->search . '%');
                }

                $items = $q->paginate(
                    Config::get('constants.table.no_of_results')
                );
                break;
        }

        $this->count = $q->count();

        return view('livewire.assets-table', [
            'type' => $request->type,
            'items' => $q->paginate(
                Config::get('constants.table.no_of_results')
            ),
            'notification' => $this->notification,
            'cols_per_row' => Config::get('constants.table.cols_per_row'),
        ]);
    }

    public function ara(Request $request, $type, $query)
    {
        $request->type = $type;
        $this->search = $query;
    }

    public function resetFilter(Request $request, $type)
    {
        $this->search = '';
        $request->type = $type;

        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteAudio(Request $request, $id)
    {
        Audio::find($id)->delete();
        $request->type = 'audio';
    }

    public function deleteDoc(Request $request, $id)
    {
        Document::find($id)->delete();
        $request->type = 'docs';
    }

    public function deleteOthers(Request $request, $id)
    {
        Dosya::find($id)->delete();
        $request->type = 'others';
    }
}