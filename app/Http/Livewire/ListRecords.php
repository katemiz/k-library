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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    protected $listeners = ['delete' => 'deleteAttach'];

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

        return view('livewire.list-records', [
            'notification' => false,
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

            case 'assetf':
                $q = Asset::query()->orderBy(
                    $this->sortTimeField,
                    $this->sortTimeDirection
                );

                $q->where('user_id', '=', Auth::id());
                $q->where('is_fake', '=', 1);

                if (strlen($this->search) > 0) {
                    $q->where('title', 'like', '%' . $this->search . '%');
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

            case 'video':
                $q = Video::query()
                    ->orderBy($this->sortTimeField, $this->sortTimeDirection)
                    ->orderBy('filename', $this->sortDirection);

                $q->where('user_id', '=', Auth::id());

                if (strlen($this->search) > 0) {
                    $q->where('filename', 'like', '%' . $this->search . '%');
                }
                break;

            case 'document':
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

    public function deleteAttach(Request $request, $type, $assetId, $id)
    {
        switch ($type) {
            case 'image':
                $attach = Gorsel::find($id);
                break;

            case 'audio':
                $attach = Audio::find($id);
                break;

            case 'video':
                $attach = Video::find($id);
                break;

            case 'doc':
                $attach = Document::find($id);
                break;

            case 'dosya':
                $attach = Dosya::find($id);
                break;
        }

        Storage::delete($attach->stored_as);
        $attach->delete();

        $request->id = $assetId; // needed for render()

        $this->notification = [
            'type' => 'is-success',
            'message' => $type . ' has been deleted',
        ];

        $ass = Asset::find($assetId);

        if ($ass->getAttachmentNumber() < 1) {
            $ass->delete();

            return redirect('/list-records/' . $type, [
                'm' => 'delete',
                'notification' => $this->notification,
            ]);
        }
    }
}
