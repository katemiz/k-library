
@extends('layouts.layout')


@section('content')



    <script>

    let files = []

    let cicon = `<x-icon icon="cancel" fill="{{config('constants.icons.color.danger')}}"/>`


    let formData = new FormData()

    function removeRow(id) {
        console.log(id)

        console.log(formData.values)
    }




    function getNames() {


        for(var pair of formData.entries()) {
   console.log(pair[0]+ ', '+ pair[1]);
}

        var newFiles = document.getElementById('fupload')

        console.log("DDDDDDDDDD",newFiles.files)

        let satir, dosya

        if (Object.entries(newFiles.files).length < 1) {
            alert("No files selected")
            return true
        }

        document.getElementById('warning').classList.add("is-hidden")

        for (const [key, dosya] of Object.entries(newFiles.files)) {

            files.push(dosya)

            let kutu = document.getElementById('uploadTable')

            satir = document.createElement('tr')
            satir.innerHTML = `<td>${dosya.name}</td><td>${dosya.size}</td><td>${dosya.type}</td><td><a @click="removeRow(${key})">${cicon}</a></td>`

            kutu.append(satir)
        }
    }

    </script>



  <div class="section container">

    <header class="mt-6">
      <h1 class="title is-size-1 has-text-weight-light">New Asset</h1>
      <h1 class="subtitle">Attach any type of files</h1>
    </header>

    <div class="column box mt-6">

        <form action="/assets-add/{{$type}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="field">
          <label class="label">Asset title</label>
          <div class="control">
            <input class="input" type="text" name="title" placeholder="eg. My vacation in Istanbul, My birthday party">
          </div>
        </div>

        <div class="field">
          <label class="label">Files associated with this asset</label>

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
                      <tbody id="uploadTable">
                        <tr id="warning">
                            <td colspan="4" class="has-text-centered">No files selected yet!</td>
                        </tr>
                      </tbody>
                  </table>
              </div>

          </div>
        </div>

        <div class="field">
            <input type="hidden" name="editor_data" id="val_editor" value="">
            <label class="label">Notes/Remarks</label>
            <div class="column" id="editor"></div>
        </div>

        <button type="submit" class="button is-link is-light">Save</button>

        </form>

    </div>

  </div>


    <script>
        ClassicEditor
        .create( document.querySelector('#editor') )
        .then( editor => {
            //console.log(editor);
            editor.model.document.on('change:data', ( evt, data ) => {
                document.getElementById("val_editor").value = editor.getData()
                //console.log(editor.getData())
            });
        })
        .catch( error => {
            console.error(error);
        });
    </script>


  @endsection
