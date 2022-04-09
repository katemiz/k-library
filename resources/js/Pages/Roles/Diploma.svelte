<script>
    import { params,gui } from '@/config/config.js'
    import { diplomaOptions } from '@/config/config_roles.js'

    import { Inertia } from '@inertiajs/inertia'

    import Layout from '@/Pages/Shared/Layout.svelte'
    import Icon from '@/Pages/Shared/Icon.svelte'

    import Swal from "sweetalert2"

    export let id
    export let role
    export let rolediplomas
    export let alldiplomas

    let diplomas
    let selected = []
    let temp = []

    processAvailable()

    function processAvailable() {

        rolediplomas.forEach(element => {
            selected.push(element.id)
            temp.push({id:element.id,status:element.pivot.status})
        });

        diplomas = temp
    }


    function addDiploma(id) {

        if ( selected.includes(id) ) {

            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Selected diplama/education level is already included',
                showConfirmButton: false,
                timer: 1000
            })

            return true
        } 

        selected.push(id)
        temp.push({id:id,status:null})

        diplomas = temp
    }


    function removeDiploma(id) {

        temp = temp.filter(function(e) { return e.id !== id })

        selected.splice(selected.indexOf(id), 1);

        delete selected[id]
        diplomas = diplomas.filter(function(e) { return e.id !== id })
    }


    function saveDiploma() {
        Inertia.post('/role-diploma', {id:id,diplomas:diplomas},{
            preserveState:false
        })
    }


</script>


<svelte:head>
    <title>{params.app.name} - Diploma/Education Levels</title>
	<link href="/css/quill.snow.css" rel="stylesheet">
</svelte:head>


<Layout>

    <div class="section container">

        <div class="columns">

            <div class="column">
                <h1 class="title has-text-weight-light">{role.title_en}</h1>
                <h2 class="subtitle">Diploma/Education Level</h2>
            </div>

            <div class="column is-4">

                <div class="buttons is-pulled-right">
                    <button class="button is-small is-link is-light" on:click="{saveDiploma}">
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


        {#if diplomas.length > 0}

            <table class="table is-bordered is-fullwidth">

            {#each diplomas as diploma}

                <tr>
                    <td>
                        <a href="{"#"}" class="icon" on:click={removeDiploma(diploma.id)}>
                          <Icon name="remove_from_list" size="{gui.icons.size}" color="danger"/>
                        </a>
                    </td>

                    <td>{alldiplomas.filter(el => el.id == diploma.id)[0].title}</td>

                    <td class="has-text-right">

                        <div class="field">

                            <div class="control">
                
                                <div class="select is-fullwidth">
                                    <select bind:value={diploma.status}>
                                        <option value="none">Select ...</option>
                
                                        {#each diplomaOptions as durum}
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
            No diploma/education level requirment exists for this role.
            </div>
        {/if}

        <table class="table is-fullwidth mt-6">
            <caption>Available diploma/education levels to select</caption>

            {#each alldiplomas as diploma}
            <tr>
                <td>{diploma.title}</td>
                <td class="has-text-right">

                    <button class="button is-small" on:click="{addDiploma(diploma.id)}">
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

</Layout>
