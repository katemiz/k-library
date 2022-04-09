<script>

    import { createEventDispatcher } from 'svelte';
    const dispatch = createEventDispatcher();

    import CKEditor from "ckeditor5-svelte";
    import ClassicEditor from "@ckeditor/ckeditor5-build-classic/build/ckeditor";

    export let props
    export let id
    /*
    props = {
        content:'hellow world',
        type:false,
        height:S/M/L
    }
    */

    let height

    if (props.height == undefined || props.height == null) {
        height = '150px'
    } else {
        switch (props.height) {
            case 'S':
                height = '100px'
                break
            default:
            case 'M':
                height = '150px'
                break

            case 'L':
                height = '250px'
                break
        }
    } 
    
    // Setting up editor prop to be sent to wrapper component
    let editor = ClassicEditor;
    // Reference to initialised editor instance
    let editorInstance = null;
    // Setting up any initial data for the editor

    let editorData =  props.content ? props.content : '' ;
    
    // If needed, custom editor config can be passed through to the component
    // Uncomment the custom editor config if you need to customise the editor.
    // Note: If you don't pass toolbar object then Document editor will use default set of toolbar items.

    let editorTypes = {

        default:{},
        min:{

            toolbar: {
                items: [
                    "heading",
                    "|",
                    "fontFamily",
                    "fontSize",
                    "bold",
                    "italic",
                    "underline"
                ]
            }
        }
    }

    let editorConfig

    if (props.type) {
        editorConfig = editorTypes[props.type]
    } else {
        editorConfig = editorTypes["default"]
    }
    
    function onReady({ detail: editor }) {
        // Insert the toolbar before the editable area.
        editorInstance = editor+id;
        editor.ui
            .getEditableElement()
            .parentElement.insertBefore(
                editor.ui.view.toolbar.element,
                editor.ui.getEditableElement()
            );

        editor.editing.view.change( writer => {
            writer.setStyle( 'height', height, editor.editing.view.document.getRoot() );
        } );
    }


    function sendIcerik() {
        dispatch('editordata', {
            icerik: editorData
        });
    }

</script>




    
<CKEditor
bind:editor
on:ready={onReady}
bind:config={editorConfig}
bind:value={editorData} on:input={sendIcerik}/> 