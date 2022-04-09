<script>
    import { params,gui } from '@/config/config.js'
    import { professionCriteria } from '@/config/config_roles.js'

    import { Inertia } from '@inertiajs/inertia'

    import Layout from '@/Pages/Shared/Layout.svelte'
    import Icon from '@/Pages/Shared/Icon.svelte'

    import Swal from "sweetalert2"

    export let id
    export let role
    export let roleprofessions
    export let allprofessions

    let professions
    let selected = []
    let temp = []

    processAvailable()

    function processAvailable() {

        roleprofessions.forEach(element => {
            selected.push(element.id)
            temp.push({id:element.id,provision:element.pivot.provision})
        });

        professions = temp
    }


    function addProfession(id) {

        if ( selected.includes(id) ) {

            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Selected profession is already included',
                showConfirmButton: false,
                timer: 1000
            })

            return true
        } 

        selected.push(id)
        temp.push({id:id,provision:null})

        professions = temp
    }


    function removeProfession(id) {

        temp = temp.filter(function(e) { return e.id !== id })

        selected.splice(selected.indexOf(id), 1);

        delete selected[id]
        professions = professions.filter(function(e) { return e.id !== id })
    }


    function saveProfession() {
        Inertia.post('/role-profession', {id:id,professions:professions},{
            preserveState:false
        })
    }


</script>


<svelte:head>
    <title>{params.app.name} - Professions</title>
	<link href="/css/quill.snow.css" rel="stylesheet">
</svelte:head>


<Layout>

    <div class="section container">

        <div class="columns">

            <div class="column">
                <h1 class="title has-text-weight-light">{role.title_en}</h1>
                <h2 class="subtitle">Professions</h2>
            </div>

            <div class="column is-4">

                <div class="buttons is-pulled-right">
                    <button class="button is-small is-link is-light" on:click="{saveProfession}">
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


        {#if professions.length > 0}

            <table class="table is-bordered is-fullwidth">

            {#each professions as profession}

                <tr>
                    <td>
                        <a href="{"#"}" class="icon" on:click={removeProfession(profession.id)}>
                          <Icon name="remove_from_list" size="{gui.icons.size}" color="danger"/>
                        </a>
                    </td>

                    <td>{allprofessions.filter(el => el.id == profession.id)[0].title}</td>

                    <td class="has-text-right">

                        <div class="field">

                            <div class="control">
                
                                <div class="select is-fullwidth">
                                    <select bind:value={profession.provision}>
                                        <option value="none">Select ...</option>
                
                                        {#each professionCriteria as durum}
                                            <option value="{durum.id}">{durum.title}</option>
                                        {/each}
                                    </select>
                                </div>
                
                            </div>
                        </div>
                    </td>

                </tr>

            {/each}

            </table>

        {:else}
            <div class="notification is-warning is-light">
            No profession requirment exists for this role.
            </div>
        {/if}


        {#if allprofessions.length > 0}

        <table class="table is-fullwidth mt-6">
            <caption>Available professions to select</caption>

            {#each allprofessions as profession}
            <tr>
                <td>{profession.title}</td>
                <td class="has-text-right">

                    <button class="button is-small" on:click="{addProfession(profession.id)}">
                        <span class="icon is-small">
                            <Icon name="add" size="{gui.icons.size}" color="{gui.icons.color}"/>
                        </span>
                        <span>Add</span>
                    </button>
                </td>
            </tr>
            {/each}
        </table>
        {:else}
            <div class="notification is-warning is-light">
            No profession definitions found.
            Please inform administrator to add provisions to select.
            </div>
        {/if}

    </div>

</Layout>
