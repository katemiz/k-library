
@extends('layouts.layout')


@section('content')

    <script>

    let cicon = `<x-icon icon="cancel" fill="{{config('constants.icons.color.danger')}}"/>`

    let filesToDelete = []
    let filesToExclude = []

    function removeFile(mimetype,id) {

        if (filesToDelete.includes(mimetype+'_'+id)) {
            filesToDelete.splice(filesToDelete.indexOf(mimetype+'_'+id),1)
        } else {
            filesToDelete.push(mimetype+'_'+id)
        }

        if (filesToDelete.length > 0) {
            document.getElementById('filesToDelete').value = filesToDelete.join()
        } else {
            document.getElementById('filesToDelete').value = ''
        }

        Array.from(document.getElementById(`ef${id}`).children).forEach(element => {

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

        <header class="mt-6">
            @if ($addfilesonly)
                <h1 class="title is-size-1 has-text-weight-light">Add Files</h1>
                <h1 class="subtitle">Attach any type of files</h1>
            @else
                <h1 class="title is-size-1 has-text-weight-light">{{$asset ? 'Edit Asset' : 'New Asset'}}</h1>
                <h1 class="subtitle">Attach any type of files</h1>
            @endif
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
                <label class="label">Files for this asset</label>

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


                            @if ($asset->attachments)
                                @foreach ($asset->attachments as  $attachment)
                                <tr id="ef{{$attachment->id}}">
                                    <td>{{$attachment->org_name}}</td>
                                    <td>{{$attachment->size}}</td>
                                    <td>{{$attachment->mimetype}}</td>
                                    <td data-name="buttons">
                                        <span class="icon" onclick="removeFile('{{$attachment->mimetype}}',{{$attachment->id}})">
                                            <x-icon icon="delete" fill="{{config('constants.icons.color.danger')}}"/>
                                        </span>

                                        <span class="is-hidden icon" onclick="removeFile('{{$attachment->mimetype}}',{{$attachment->id}})">
                                            <x-icon icon="undo" fill="{{config('constants.icons.color.active')}}"/>
                                        </span>
                                    </td>
                                </tr>
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
            //console.log(editor);
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
