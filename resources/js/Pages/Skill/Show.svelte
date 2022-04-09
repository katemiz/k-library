<script>
    import { createEventDispatcher } from 'svelte';
    const dispatch = createEventDispatcher();

    import { params,gui } from '@/config/config.js'

    import Icon from '@/Pages/Shared/Icon.svelte'
    import Notification from '@/Pages/Shared/Notification/Notification.svelte'
    import Header from '@/Pages/Shared/Header/Header.svelte'
    import ItemInfo from '@/Pages/Shared/Notification/ItemInfo.svelte'

    import { Inertia } from '@inertiajs/inertia'
    import Swal from "sweetalert2"

    export let item
    export let notification
    export let parent

    function confirmDelete(event) {

        Swal
        .fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        })
        .then((result) => {

            Inertia.delete('skills', {
                method:'delete',
                preserveState:false,
                data:{
                    id:event.target.dataset.id
                }
            })
        })
    }


    function editNode () {
        dispatch('editnode', {
            item: item
        });
    }


    function addChild (event) {
        dispatch('addchild', {
            id:parseInt(event.target.dataset.id)
        });
    }

</script>


<svelte:head>
  <title>{params.app.name} - Skills Properties</title>
</svelte:head>


<Header header="{{ title:"Properties" }}" />

<Notification {notification} />

<div class="card">

    <div class="card-content">
        <div class="media">
            <div class="media-content">
                <p class="title is-4 my-1">{item.title_en}</p>
                <p class="title is-4 my-1 has-text-grey">{item.title_tr}</p>



                <p class="subtitle is-6 mt-3">{parent.title_en} / {parent.title_tr}</p>
            </div>
        </div>
    
        <div class="content">

            {@html item.desc_en}
            {@html item.desc_tr}

        </div>
    </div>


    <footer class="card-footer">

        <a href="{"#"}" class="card-footer-item" on:click={addChild} data-id={item.id}>
            <Icon name="add" size="{gui.icons.size}" color="{gui.icons.color}"/>&nbsp;Add Child
        </a>

        <a href="{"#"}" class="card-footer-item" on:click={editNode}>
            <Icon name="edit" size="{gui.icons.size}" color="{gui.icons.color}"/>&nbsp;Edit
        </a>

        {#if item.children == undefined || item.children.length == 0}
            <a href="{"#"}" class="card-footer-item" on:click={confirmDelete} data-id={item.id}>
                <Icon name="delete" size="{gui.icons.size}" color="danger"/>&nbsp;Delete
            </a>
        {/if}

    </footer>

</div>

<ItemInfo {item} />