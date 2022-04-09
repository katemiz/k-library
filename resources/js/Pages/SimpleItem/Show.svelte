<script>

    import { params,gui } from '@/config/config.js'
    import { sabitler } from '@/config/config_simpleitem.js'

    import { Link } from '@inertiajs/inertia-svelte'
    import { Inertia } from '@inertiajs/inertia'

    import Layout from '@/Pages/Shared/Layout.svelte'
    import Icon from '@/Pages/Shared/Icon.svelte'
    import Header from '@/Pages/Shared/Header/Header.svelte'
    import Notification from '@/Pages/Shared/Notification/Notification.svelte'
    import ItemInfo from '@/Pages/Shared/Notification/ItemInfo.svelte'

    import Swal from "sweetalert2"

    export let pagetype
    export let item
    export let notification


    let pageprops = sabitler[pagetype]

    function confirmDelete(id) {

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        })
        .then((result) => {

            Inertia.delete('/simpleitem/'+pagetype, {
                method:'delete',
                preserveState:false,
                data:{
                    id:id
                }
            })
        })
    }

</script>


<svelte:head>
  <title>{params.app.name} - {pageprops.headers.general}</title>
</svelte:head>


  
<Layout>

    <div class="section container">

        <h1 class="title has-text-weight-light">{pageprops.headers.show}</h1>
        <h2 class="subtitle">View Properties</h2>

        {#if notification}
            <Notification {notification} />
        {/if}


<!--         <div class="columns">

            <div class="column is-half">
                <Link href="/simpleitem/{pagetype}" class="navbar-item">
                    <Icon name="list" size="{gui.icons.size}" color="{gui.icons.color}"/> List All
                </Link> 
            </div>

            <div class="column">
                <div class="is-pulled-right">
                <Link href="/simpleitem-form/{pagetype}" class="navbar-item">
                    <Icon name="add" size="{gui.icons.size}" color="{gui.icons.color}"/> {pageprops.addcommand.label}
                </Link>
                </div>
            </div>

        </div>
 -->

        <div class="columns mt-6">

            <div class="column is-3">

                <aside class="menu">
                    <p class="menu-label">MENU</p>
                    <ul class="menu-list">
                      <li>
                        <Link href="/simpleitem/{pagetype}" class="navbar-item">
                            <!-- <Icon name="list" size="{gui.icons.size}" color="{gui.icons.color}"/> --> List All
                        </Link> 
                      </li>
                      <li>
                        <Link href="/simpleitem-form/{pagetype}" class="navbar-item">
                            <!-- <Icon name="add" size="{gui.icons.size}" color="{gui.icons.color}"/> --> {pageprops.addcommand.label}
                        </Link>
                      </li>
                    </ul>
                </aside>

            </div>

            <div class="column">
                
                <div class="card">
        
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content">
                                <p class="title is-4">{item.title}</p>
                            </div>
                        </div>
                    
                        <div class="content">{@html item.remarks}</div>
                    </div>
        
        
                    <footer class="card-footer">
        
                        <a href="/simpleitem-form/{pagetype}/{item.id}" class="card-footer-item">
                            <Icon name="edit" size="{gui.icons.size}" color="{gui.icons.color}"/>&nbsp;Edit
                        </a>
                        <a href="{"#"}" class="card-footer-item" on:click="{confirmDelete(item.id)}">
                            <Icon name="delete" size="{gui.icons.size}" color="danger"/>&nbsp;Delete
                        </a>
        
                    </footer>
                    
                </div>

                <ItemInfo {item} />

            </div>

        </div>




    </div>

</Layout>