<script>

    import {params} from '@/config/config.js'
    import {pageprops,formprops,categoryprops} from '@/config/config_roles.js'

    import Layout from '@/Pages/Shared/Layout.svelte'
    import EditorQuill from '@/Pages/Shared/Editor/EditorQuill.svelte'
    import Header from '@/Pages/Shared/Header/Header.svelte'
    import { printOrder } from "@/Pages/Shared/Functions/tree.js";

    import { Inertia } from '@inertiajs/inertia'

    export let categorytree
    export let item

    let categories
    let id = false
    let title_en
    let title_tr
    let categoryId
    let desc_en
    let desc_tr

    let header
    let submit_label

    let processing = false
    let values = {}

    let editorProps_en = formprops.editor_en
    let editorProps_tr = formprops.editor_tr

    // IF THIS IS EDIT
    if (item) {

        values = item

        id = item.id
        categoryId = item.category
        title_en = item.title_en
        title_tr = item.title_tr
        editorProps_en.content = item.desc_en
        editorProps_tr.content = item.desc_tr

        desc_en = {html:item.desc_en,text:item.desc_en_text}
        desc_tr = {html:item.desc_tr,text:item.desc_tr_text}

        header = formprops.headers.update
        submit_label = formprops.submit.update.label

    } else {

        title_en = ''
        title_tr = ''
        editorProps_en = formprops.editor_en
        editorProps_tr = formprops.editor_tr

        editorProps_en.content = ''
        editorProps_tr.content = ''

        header = formprops.headers.new
        submit_label = formprops.submit.new.label
    }

    categories = printOrder(categorytree)

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
            category:categoryId,
            title_en:title_en,
            title_tr:title_tr,
            desc_en:desc_en,
            desc_tr:desc_tr
        }


        if (!item) {

            console.log("VALUES post", values)


            Inertia.post('/roles', values,{
                preserveState:false
            })

        } else {

            values.id = id

            console.log("VALUES put", values)


            Inertia.put('/roles', values,{
                preserveState:false
            })
        }
    }

</script>

<svelte:head>
    <title>{params.app.name} - {formprops.headers.new}</title>
	<link href="/css/quill.snow.css" rel="stylesheet">
</svelte:head>


<Layout>

    <div class="section container">

        <Header header="{{ title:pageprops.headers.list }}" />

        <form on:submit|preventDefault={handleSubmit} class="mx-4">

            <div class="box">
                
                <div class="field">

                    <label class="label" for="{formprops.category.id}">{formprops.category.label}</label>
                    <div class="control" id="{formprops.category.id}">

                        <div class="select is-fullwidth">
                            <select bind:value={categoryId}>
                                <option value="NotSelected">Select ...</option>

                                {#each categories as option}
                                    <option value="{option.id}">
                                        {#each [...Array(option.level).keys()] as dot}
                                        &nbsp; &nbsp; &nbsp; &nbsp;
                                        {/each}
                                        
                                        {option[categoryprops.titleColumn]}
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

    </div>

</Layout>
