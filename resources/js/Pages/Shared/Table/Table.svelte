<script>
    import { createEventDispatcher } from 'svelte';
    const dispatch = createEventDispatcher();

    //import FilterTable from '../Tree/FilterBox.svelte'
    import Pagination from '@/Pages/Shared/Pagination/Pagination.svelte'
    import THeadFoot from '@/Pages/Shared/Table/THeadFoot.svelte'
    import Icon from '@/Pages/Shared/Icon.svelte'

    // import { page, useForm,Link } from '@inertiajs/inertia-svelte'

    export let dataFromServer
    export let props;
    export let iconprops;
    export let tabledata;

    console.log("TABLE ",props)


    let query



    function handleQuery (event) {


    }


    function handleReset () {

        query=''
    }


</script>


{#if tabledata.length > 0}

    <div class="columns is-mobile">
        <div class="column is-4 is-offset-8">
            <!-- <FilterTable placeholder="Search in table ..." on:queryinput={handleQuery} on:queryreset={handleReset} /> -->


            <!-- Filter Tree Search Box -->
            <div class="field has-addons is-fullwidth">

                <p class="control has-icons-left has-icons-right">
                    <input class="input" type="text" placeholder="{props.filter.placeholder}" bind:value={query} on:input="{handleQuery}">
                    <span class="icon is-small is-left">
                        <Icon name="search" size="{iconprops.size}" color="{iconprops.color}"/>
                    </span>
                </p>

                <div class="control">
                    <button class="button is-light px-1" on:click="{handleReset}">
                        <Icon name="cancel" size="{iconprops.size}" color="lightgrey"/>
                    </button>
                </div>

            </div>

        </div>
    </div>



    <table class="table is-fullwidth">

        <THeadFoot headers={props.thead}/>

        <tbody>

            {#each tabledata as item}

                <tr>
                    <td>{item.id}</td>
                    <td>{@html item.title}</td>
                    <td>{@html item.created_at}</td>
                    <td>
                        <a href="{"#"}" class="icon">
                            <Icon name="eye" size="{iconprops.size}" color="{iconprops.color}"/>
                        </a>
                        <a href="{"#"}" class="icon">
                            <Icon name="edit" size="{iconprops.size}" color="{iconprops.color}"/>
                        </a>
                        <a href="{"#"}" class="icon">
                            <Icon name="delete" size="{iconprops.size}" color="danger"/>
                        </a>                        
                    </td>

                </tr>

            {/each}
        </tbody>

        {#if tabledata.length > 20}
        <THeadFoot headers={props.tfoot} footer="true" />
        {/if}

    </table>

{:else}

    <div class="notification is-warning">No records yet.</div>

{/if}



<Pagination pagination={dataFromServer} {iconprops}/>


<!-- 

<nav class="pagination is-small is-centered" aria-label="pagination">

    <Link
        class="pagination-previous {!dataFromServer.prev_page_url ? 'is-disabled' :''}"
        href="{dataFromServer.prev_page_url ? dataFromServer.prev_page_url :'#'}">
        <Icon name="previous" size="S" color="link"/>
    </Link>

    <Link
        class="pagination-next {!dataFromServer.next_page_url ? 'is-disabled' :''}"
        href="{dataFromServer.next_page_url ? dataFromServer.next_page_url :'#'}">
        <Icon name="next" size="S" color="link"/>
    </Link>

    <ul class="pagination-list">

        {#each dataFromServer.links as link,i}
            {#if i >0 && i < dataFromServer.links.length-1}

                <li>
                    <Link
                        class="pagination-link {link.active ? 'is-current':''}"
                        href="{link.url}"
                        aria-label="Goto page {link.url}">
                        {link.label}
                </Link>
                </li>

            {/if}
        {/each}

    </ul>
</nav>


 -->