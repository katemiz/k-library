

<script>
    import {params,gui} from '@/config/config.js'
    import {formprops} from '@/config/config_roles.js'

    import Layout from '@/Pages/Shared/Layout.svelte'
    import EditorQuill from '@/Pages/Shared/Editor/EditorQuill.svelte'
    import Icon from '@/Pages/Shared/Icon.svelte'


    import { Inertia } from '@inertiajs/inertia'

    export let role

    let experience
    let editorProps_experience = formprops.editor_experience


    if (role.experience.length > 0) {
        editorProps_experience.content = role.experience
    }

    function readContent(event) {
        if (event.detail.id == formprops.editor_experience.id) {
            experience = event.detail.icerik
        }
    }



    function saveExperience() {

        let values = {
            id:role.id,
            experience:experience
        }

        console.log("values",values)
        Inertia.post('/role-experience', {id:role.id,experience:experience},{
            preserveState:false
        })
    }

</script>







<svelte:head>
    <title>{params.app.name} - Languages</title>
	<link href="/css/quill.snow.css" rel="stylesheet">
</svelte:head>


<Layout>

    <section class="section container">

        <div class="columns">

            <div class="column">
                <h1 class="title has-text-weight-light">{role.title_en}</h1>
                <h2 class="subtitle">Experience</h2>
            </div>

            <div class="column is-4">

                <div class="buttons is-pulled-right">
                    <button class="button is-small is-link is-light" on:click="{saveExperience}">
                        <span class="icon is-small">
                            <Icon name="save" size="{gui.icons.size}" color="{gui.icons.color}"/>
                        </span>
                        <span>Save</span>
                    </button>

                    <a href="/roles/{role.id}" class="button is-small">
                        <span class="icon is-small">
                            <Icon name="cancel" size="{gui.icons.size}" color="danger"/>
                        </span>
                        <span>Cancel</span>
                    </a>
                </div>

            </div>   
        </div>


        <EditorQuill props={editorProps_experience} on:editordata={readContent}/>


    </section>
        

</Layout>
