<script>

    import { params,gui } from '@/config/config.js'
    import { langlevels } from '@/config/config_langlevels.js'

    import { Inertia } from '@inertiajs/inertia'

    import Layout from '@/Pages/Shared/Layout.svelte'
    import Icon from '@/Pages/Shared/Icon.svelte'

    import Swal from "sweetalert2"

    export let id
    export let role
    export let rolelangs
    export let alllangs

    let languages
    let showmodal = false
    let selected = []
    let temp = []

    processAvailable()

    function processAvailable() {

        rolelangs.forEach(element => {
            selected.push(element.id)
            temp.push({id:element.id,level:element.pivot.level})
        });

        languages = temp
    }


    function addLang(id) {

        if ( selected.includes(id) ) {

            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Clicked language is already included',
                showConfirmButton: false,
                timer: 1000
            })

            return true
        } 

        selected.push(id)
        temp.push({id:id,level:null})

        languages = temp
    }


    function removeLang(id) {

        temp = temp.filter(function(e) { return e.id !== id })

        selected.splice(selected.indexOf(id), 1);

        delete selected[id]
        languages = languages.filter(function(e) { return e.id !== id })
    }


    function saveLang() {
        Inertia.post('/role-language', {id:id,langs:languages},{
            preserveState:false
        })
    }

    function showHelp() {
        showmodal = !showmodal
    }

</script>



<svelte:head>
    <title>{params.app.name} - Languages</title>
	<link href="/css/quill.snow.css" rel="stylesheet">
</svelte:head>


<Layout>

    <div class="section container">

        <div class="columns">

            <div class="column">
                <h1 class="title has-text-weight-light">{role.title_en}</h1>
                <h2 class="subtitle">Languages</h2>
            </div>

            <div class="column is-4">

                <div class="buttons is-pulled-right">
                    <button class="button is-small is-link is-light" on:click="{saveLang}">
                        <span class="icon is-small">
                            <Icon name="save" size="{gui.icons.size}" color="{gui.icons.color}"/>
                        </span>
                        <span>Save</span>
                    </button>

                    <a href="/roles/{id}" class="button is-small">
                        <span class="icon is-small">
                            <Icon name="cancel" size="{gui.icons.size}" color="danger"/>
                        </span>
                        <span>Cancel</span>
                    </a>
                </div>

            </div>   
        </div>


        {#if languages.length > 0}

            <table class="table is-bordered is-fullwidth">

            {#each languages as dil}

                <tr>
                    <td>
                        <a href="{"#"}" class="icon" on:click={removeLang(dil.id)}>
                          <Icon name="remove_from_list" size="{gui.icons.size}" color="danger"/>
                        </a>
                    </td>

                    <td>{alllangs.filter(el => el.id == dil.id)[0].title}</td>

                    <td class="has-text-right">

                        <div class="field">

                            <div class="control">
                
                                <div class="select is-fullwidth">
                                    <select bind:value={dil.level}>
                                        <option value="none">Select ...</option>
                
                                        {#each langlevels as level}
                                            <option value="{level.level}">{level.level} - {level.title}</option>
                                        {/each}
                                    </select>
                                </div>
                
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="icon-text" on:click="{showHelp}">
                            <span class="icon">
                                <Icon name="info" size="{gui.icons.size}" color="{gui.icons.color}"/>
                            </span>
                            <span class="has-text-link">Language Levels</span>
                        </span> 
                    </td>
                </tr>

            {/each}

            </table>

        {:else}
            <div class="notification is-warning is-light">
            No language requirment exists for this role.
            </div>
        {/if}

        <table class="table is-fullwidth mt-6">
            <caption>Available Languages to Select</caption>

            {#each alllangs as lang}
            <tr>
                <td>{lang.title}</td>
                <td class="has-text-right">

                    <button class="button is-small" on:click="{addLang(lang.id)}">
                        <span class="icon is-small">
                            <Icon name="add" size="{gui.icons.size}" color="{gui.icons.color}"/>
                        </span>
                        <span>Add</span>
                    </button>
                </td>
            </tr>
            {/each}
        </table>

    </div>

    <div class="modal" class:is-active="{showmodal}">
        <div class="modal-background" on:click="{showHelp}"></div>
        <div class="modal-content">
          <p class="image">
            <img src="/images/language_levels.png" alt="Language Levels">
          </p>
        </div>
        <button class="modal-close is-large" aria-label="close"  on:click="{showHelp}"></button>
    </div>

</Layout>
