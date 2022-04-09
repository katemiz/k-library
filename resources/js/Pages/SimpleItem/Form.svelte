<script>
    import { params,gui } from '@/config/config.js'
    import { sabitler } from '@/config/config_simpleitem.js'
    
    import { Link } from '@inertiajs/inertia-svelte'
    import { Inertia } from '@inertiajs/inertia'

    import Layout from '@/Pages/Shared/Layout.svelte'
    import EditorQuill from '@/Pages/Shared/Editor/EditorQuill.svelte'
    import Header from '@/Pages/Shared/Header/Header.svelte'
    import Icon from '@/Pages/Shared/Icon.svelte'

    export let pagetype
    export let item

    let editorProps
    let title
    let remarks
    let processing = false
    let submitbutton
    let header

    let pageprops = sabitler[pagetype]

    editorProps = pageprops.form.textarea

    // IF THIS IS EDIT
    if (item) {

        title = item.title
        remarks = {
            html:item.remarks,
            text:item.remarks_text
        }
        editorProps.content = item.remarks

        header = pageprops.headers.update
        submitbutton = pageprops.form.submit.update.label
    } else {

        header = pageprops.headers.new
        submitbutton = pageprops.form.submit.new.label
    }


    function readContent(event) {
		remarks = event.detail.icerik
    }


    function handleSubmit() {

        let values = {
            title:title,
            remarks:remarks
        }

        if (item) {

            values.id = item.id
            Inertia.put('/simpleitem-upsert/'+pagetype, values,{
                onStart: () => {processing = true},
                onFinish: () => {processing = false},
            })

        } else {
            Inertia.post('/simpleitem-upsert/'+pagetype, values,{
                onStart: () => {processing = true},
                onFinish: () => {processing = false},
            })
        }
    }

</script>


<svelte:head>
  <title>{params.app.name} - {header}</title>
  <link href="/css/quill.snow.css" rel="stylesheet">
</svelte:head>
  

<Layout>

<div class="section container">

    <Header header="{{ title:header }}" />

    <div class="column has-text-right">
        <Link href="/simpleitem/{pagetype}" class="navbar-item">
          <Icon name="list" size="{gui.icons.size}" color="{gui.icons.color}"/> Back to List
        </Link> 
    </div>

    <form on:submit|preventDefault={handleSubmit} class="mx-4">

        <div class="box">
                            
            <div class="field">
                <label class="label" for="titleid">{pageprops.form.input.label}</label>
                <div class="control" id="titleid">
                    <input class="input" bind:value={title} type="text" placeholder="{pageprops.form.input.placeholder}" >
                </div>
            </div>
                
            <EditorQuill props={editorProps} on:editordata={readContent}/>

            <div class="buttons is-right">
                <button class="button is-info" disabled={processing}>{submitbutton}</button>
            </div>

        </div>

    </form>
</div>
</Layout>