@extends('layouts.layout')


@section('content')

    <script src="{{ asset('/js/ckeditor5/ckeditor.js') }}"></script>

    <script>

        let cicon = `<x-icon icon="cancel" fill="{{config('constants.icons.color.danger')}}"/>`

        let filesToDelete = {
            'image':[],
            'audio':[],
            'video':[],
            'doc':[],
            'dosya':[]
        }

        let filesToExclude = []

        function removeFile(prefix,id) {

            if (filesToDelete[prefix].includes(id)) {
                filesToDelete[prefix].splice(filesToDelete[prefix].indexOf(id),1)
            } else {
                filesToDelete[prefix].push(id)
            }

            document.getElementById('filesToDelete').value = JSON.stringify(filesToDelete)

            Array.from(document.getElementById(prefix+id).children).forEach(element => {

                if (element.dataset.name !== undefined && element.dataset.name === 'buttons') {

                    Array.from(element.children).forEach(el => {

                        if (Array.from(el.classList).includes('is-hidden')) {
                            el.classList.remove('is-hidden')
                        } else {
                            el.classList.add('is-hidden')
                        }
                    })
                } else {

                    if (Array.from(element.classList).includes('iptal')) {
                        element.classList.remove('iptal')
                    } else {
                        element.classList.add('iptal')
                    }
                }
            });
        }

        function cancelFile(key,fname) {

            document.getElementById(`K${key}`).remove()

            if (filesToExclude.includes(fname)) {
                filesToExclude.splice(filesToExclude.indexOf(fname),1)
            } else {
                filesToExclude.push(fname)
            }

            if (filesToExclude.length > 0) {
                document.getElementById('filesToExclude').value = filesToExclude.join()
            } else {
                document.getElementById('filesToExclude').value = ''
            }

            document.getElementById('filesToUpload').value = document.getElementById('filesToUpload').value-1

            if (document.getElementById('filesToUpload').value == 0) {
                document.getElementById('noFile').classList.remove('is-hidden')
            }
        }

        function getNames() {

            var newFiles = document.getElementById('fupload')

            if (Object.entries(newFiles.files).length < 1) {
                document.getElementById('noFile').classList.remove('is-hidden')
                return true
            }

            document.getElementById('noFile').classList.add('is-hidden')

            let satir = ''
            dosyalar = []

            for (const [key, dosya] of Object.entries(newFiles.files)) {

                satir = satir +`
                <tr id="K${key}">
                    <td>${dosya.name}</td>
                    <td>${dosya.size}</td>
                    <td>${dosya.type}</td>
                    <td><a onclick="cancelFile('${key}','${dosya.name}')">${cicon}</a></td>
                </tr>`

                dosyalar.push({key:dosya})
            }

            document.getElementById('filesToUpload').value = Object.entries(newFiles.files).length
            document.getElementById('filesToExclude').value = ''
            document.getElementById('filesList').innerHTML = satir
        }

    </script>

    <div class="section container">

        <header>
            @if ($addfilesonly)
                <h1 class="title is-size-1 has-text-weight-light">Add Files</h1>
            @else
                <h1 class="title is-size-1 has-text-weight-light">{{$asset ? 'Edit Asset' : 'New Asset'}}</h1>
            @endif
            <h1 class="subtitle">Attach any type of files</h1>
        </header>

        <div class="column box mt-6">

            @if ($addfilesonly)
            <form action="{{ '/assets-storefiles' }}" method="{{ $asset ? 'POST' : 'POST' }}" enctype="multipart/form-data">
            @else
            <form action="{{ $asset ? '/assets-update/'.$asset->id : '/assets-add' }}" method="{{ $asset ? 'POST' : 'POST' }}" enctype="multipart/form-data">
            @endif

            @csrf

            <input type="hidden" id="id" value="{{ $asset ? $asset->id : false }}" autocomplete="off">
            <input type="hidden" id="filesToUpload" value="0" autocomplete="off">
            <input type="hidden" id="filesToDelete" name="filesToDelete" value="" autocomplete="off">
            <input type="hidden" id="filesToExclude" name="filesToExclude" value="0" autocomplete="off">

            @if (!$addfilesonly)
            <div class="field">
                <label class="label">Asset title</label>
                <div class="control">
                <input class="input" type="text" name="title"
                    placeholder="eg. My vacation in Istanbul, My birthday party"
                    value="{{$asset ? $asset->title : ''}}">
                </div>
            </div>
            @endif

            @if ($asset)

            <div class="field">
                <label class="label">Files for this asset : [
                    @php
                    echo ini_get("upload_max_filesize");
                    @endphp ]
                </label>

                <div class="column">
                <table class="table is-striped  is-fullwidth" >
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Type</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($asset->images)
                            @foreach ($asset->images as  $image)
                                <x-file-tr :dbfile="$image" prefix='image'/>
                            @endforeach
                        @endif

                        @if ($asset->audio)
                            @foreach ($asset->audio as  $audio)
                                <x-file-tr :dbfile="$audio" prefix='audio'/>
                            @endforeach
                        @endif

                        @if ($asset->video)
                            @foreach ($asset->video as  $video)
                                <x-file-tr :dbfile="$video" prefix='video'/>
                            @endforeach
                        @endif

                        @if ($asset->docs)
                            @foreach ($asset->docs as  $doc)
                                <x-file-tr :dbfile="$doc" prefix='doc'/>
                            @endforeach
                        @endif

                        @if ($asset->dosyalar)
                            @foreach ($asset->dosyalar as  $dosya)
                                <x-file-tr :dbfile="$dosya" prefix='dosya'/>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                </div>
                @endif

                <div class="columns">

                    <div class="column is-2">
                    <div class="file is-boxed">
                        <label class="file-label">
                        <input
                            class="file-input"
                            type="file"
                            name="assets[]"
                            id="fupload"
                            multiple
                            onchange="getNames()" />
                        <span class="file-cta">
                            <span class="file-icon">
                            <x-icon icon="upload" fill="{{config('constants.icons.color.active')}}"/>
                            </span>
                            <span class="file-label">Files</span>
                        </span>
                        </label>
                    </div>
                    </div>

                    <div class="column">
                        <table class="table is-striped  is-fullwidth" >
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Size</th>
                                    <th>Type</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody id="filesList">
                            </tbody>

                            <tfoot id="noFile">
                            <tr>
                                <td colspan="4" class="has-text-centered">No files selected yet!</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>

            @if (!$addfilesonly)
            <div class="field">
                <input type="hidden" name="editor_data" id="ckeditor" value="{{$asset ? $asset->notes : ''}}">
                <label class="label">Notes/Remarks</label>
                <div class="column" id="editor"></div>
            </div>
            @endif

            <button type="submit" class="button is-link is-light">{{$asset ? 'Update' : 'Save'}}</button>

            </form>

        </div>

    </div>


    @if (!$addfilesonly)
    <script>
        ClassicEditor
        .create( document.querySelector('#editor') )
        .then( editor => {
            // console.log(editor);
            let icerik = document.getElementById('ckeditor').value

            if (icerik.length>0) {
                editor.setData(icerik)
            }

            editor.model.document.on('change:data', ( evt, data ) => {
                document.getElementById("ckeditor").value = editor.getData()
            });
        })
        .catch( error => {
            console.error(error);
        });
    </script>
    @endif

@endsection
