<script>

    import { treeprops,formprops,topnode } from '@/config/config_category.js'

    import { printOrder } from "@/Pages/Shared/Functions/tree.js";

    import EditorQuill from '@/Pages/Shared/Editor/EditorQuill.svelte'
    import Header from '@/Pages/Shared/Header/Header.svelte'

    import { Inertia } from '@inertiajs/inertia'

    export let treedata
    export let itemValues
    export let selectedParentId

    let id = false
    let title_en
    let title_tr
    let parent_id
    let desc_en
    let desc_tr

    let parent_options
    let is_edit = false
    let processing = false
    let values = {}

    let editorProps_en = formprops.editor_en
    let editorProps_tr = formprops.editor_tr

    // IF THIS IS EDIT
    if (itemValues) {

        values = itemValues

        id = itemValues.id
        parent_id = itemValues.parent_id
        title_en = itemValues.title_en
        title_tr = itemValues.title_tr
        editorProps_en.content = itemValues.desc_en
        editorProps_tr.content = itemValues.desc_tr

        desc_en = {html:itemValues.desc_en,text:itemValues.desc_en_text}
        desc_tr = {html:itemValues.desc_tr,text:itemValues.desc_tr_text}

        is_edit = true

    } else {

        //IF THIS IS ADD CHILD TO SELECTED NODE
        if (selectedParentId) {
            parent_id = selectedParentId
        }

        title_en = ''
        title_tr = ''
        editorProps_en = formprops.editor_en
        editorProps_tr = formprops.editor_tr

        editorProps_en.content = ''
        editorProps_tr.content = ''
    }

    let header,submit_label

    if (!is_edit) {

        header = formprops.header.new
        submit_label = formprops.submit.new.label

    } else {

        header = formprops.header.update
        submit_label = formprops.submit.update.label
    }

    // PARENT OPTIONS
    parent_options = treedata

    parent_options = printOrder(parent_options)
    parent_options.unshift(topnode)

    function readContent(event) {

        if (event.detail.id == formprops.editor_en.id) {
            desc_en = event.detail.icerik
        }

        if (event.detail.id == formprops.editor_tr.id) {
            desc_tr = event.detail.icerik
        }
    }


    function handleSubmit() {

        values = {
            parent_id:parent_id,
            title_en:title_en,
            title_tr:title_tr,
            desc_en:desc_en,
            desc_tr:desc_tr
        }

        if (!is_edit) {

            Inertia.post('bcategory', values,{
                preserveState:false
            })

        } else {

            values.id = id

            Inertia.put('bcategory', values,{
                preserveState:false
            })
        }
    }

</script>

<svelte:head>
	<link href="/css/quill.snow.css" rel="stylesheet">
</svelte:head>


<Header header="{{ title:header }}" />

<form on:submit|preventDefault={handleSubmit} class="mx-4">

    <div class="box">
        
        <div class="field">

            <label class="label" for="{formprops.parent.id}">{formprops.parent.label}</label>
            <div class="control" id="{formprops.parent.id}">

                <div class="select is-fullwidth">
                    <select bind:value={parent_id}>
                        <option value="NotSelected">Select ...</option>

                        {#each parent_options as option}
                            <option value="{option.id}">
                                {#each [...Array(option.level).keys()] as dot}
                                &nbsp; &nbsp; &nbsp; &nbsp;
                                {/each}
                                
                                {option[treeprops.titleColumn]}
                            </option>
                        {/each}
                    </select>
                </div>

            </div>
        </div>
            
        <div class="field">
            <label class="label" for="{formprops.title_en.id}">{formprops.title_en.label}</label>
            <div class="control" id="{formprops.title_en.id}">
                <input class="input" bind:value={title_en} type="text" placeholder="{formprops.title_en.placeholder}" >
            </div>
        </div>

        <div class="field">
            <label class="label" for="{formprops.title_tr.id}">{formprops.title_tr.label}</label>
            <div class="control" id="{formprops.title_tr.id}">
                <input class="input" bind:value={title_tr} type="text" placeholder="{formprops.title_tr.placeholder}" >
            </div>
        </div>

        <EditorQuill props={editorProps_en} on:editordata={readContent}/>
        <EditorQuill props={editorProps_tr} on:editordata={readContent}/>

        <div class="buttons is-right">
            <button class="button is-info" disabled={processing}>{submit_label}</button>
        </div>

    </div>

</form>