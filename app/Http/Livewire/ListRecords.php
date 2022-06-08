<?php

namespace App\Http\Livewire;

use App\Models\Asset;
use App\Models\Gorsel;
use App\Models\Audio;
use App\Models\Dosya;
use App\Models\Document;
use App\Models\Video;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

use Livewire\Component;
use Livewire\WithPagination;

class ListRecords extends Component
{
    use WithPagination;

    public $search = '';

    public $type = false;

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
        if (!$this->type) {
            $this->type = $request->type;
        }
        $q = $this->getDataPerType();

        // Log::info('this->type = ' . $this->type);

        return view('livewire.list-records', [
            'type' => $this->type,
            'records' => $q->paginate(
                Config::get('constants.table.no_of_results')
            ),
        ]);
    }

    public function ara($query)
    {
        $this->search = $query;
    }

    public function resetFilter()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function getDataPerType()
    {
        switch ($this->type) {
            case 'asset':
                $q = Asset::query()->orderBy(
                    $this->sortTimeField,
                    $this->sortTimeDirection
                );

                $q->where('user_id', '=', Auth::id());
                $q->where('is_fake', '=', 0);

                if (strlen($this->search) > 0) {
                    $q->where('title', 'like', '%' . $this->search . '%');
                    $q->orWhere('notes', 'like', '%' . $this->search . '%');
                }

                break;

            case 'image':
                $q = Gorsel::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy('filename', $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                if (strlen($this->search) > 0) {
                    $q->where('filename', 'like', '%' . $this->search . '%');
                }

                break;

            case 'audio':
                $q = Audio::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy('filename', $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                if (strlen($this->search) > 0) {
                    $q->where('filename', 'like', '%' . $this->search . '%');
                }
                break;

            // VIDEO
            case 'video':
                $q = Video::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy('filename', $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                if (strlen($this->search) > 0) {
                    $q->where('filename', 'like', '%' . $this->search . '%');
                }
                break;

            case 'doc':
                $q = Document::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy('filename', $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                if (strlen($this->search) > 0) {
                    $q->where('filename', 'like', '%' . $this->search . '%');
                }
                break;

            default:
                $q = Dosya::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy('filename', $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                if (strlen($this->search) > 0) {
                    $q->where('filename', 'like', '%' . $this->search . '%');
                }

                break;
        }

        return $q;
    }
}
