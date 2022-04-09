<script>

    import { params,gui } from '@/config/config.js'
    import { sabitler } from '@/config/config_simpleitem.js'
    import { parseDateTime } from '@/Pages/Shared/Functions/time.js'

    import { Inertia } from '@inertiajs/inertia'

    import Layout from '@/Pages/Shared/Layout.svelte'
    import Pagination from '@/Pages/Shared/Pagination/Pagination.svelte'
    import Notification from '@/Pages/Shared/Notification/Notification.svelte'
    import Header from '@/Pages/Shared/Header/Header.svelte'
    import Icon from '@/Pages/Shared/Icon.svelte'
  
    export let pagetype
    export let tabledata
    export let filters
    export let notification

    let page = sabitler[pagetype]


    let filterquery = filters.search
    let userid
    let sortcolumn
    let sortorder

    let sortstatus = {

      title:{
        order:'asc',
        hidden:false
      },

      created_by:{
        order:'asc',
        hidden:false
      },

      created_at:{
        order:'asc',
        hidden:false
      }
    }

    function handleSort(col,id) {

      sortstatus[col].order = (sortstatus[col].order == 'desc') ? 'asc': 'desc'
      sortstatus[col].hidden = !sortstatus[col].hidden

      sortcolumn = col
      sortorder = sortstatus[col].order
      userid = id

      handleQuery()
    }

    function handleQuery () {

      let params = {}

      params.sortcolumn = sortcolumn
      params.sortorder = sortorder

      if (filterquery) {
        params.search = filterquery
      }

      if (userid) {
        params.userid = userid
      }

      Inertia.get("/simpleitem/"+pagetype,params, {
        preserveState:true
      })
    }
  
    function handleReset () {
      filterquery = ''
      Inertia.get("/simpleitem/"+pagetype)
    }

</script> 
  
<svelte:head>
    <title>{params.app.name} - {page.headers.general}</title>
</svelte:head>
    
<Layout>

    <div class="section container">

        <Header header="{{ title:page.headers.list }}" />

        {#if notification}
        <Notification {notification} />
        {/if}

        <!-- ***************** -->
        <!-- ADD BUTTON        -->
        <!-- ***************** -->

        <div class="column">

        <div class="buttons has-addons is-left">

            <a href="/simpleitem-form/{pagetype}" class="button is-light">
                <span class="icon is-small">
                    <Icon name="add" size="{gui.icons.size}" color="{gui.icons.color}"/>
                </span>
                <span>{page.addcommand.label}</span>
            </a>
        
        </div>
        </div>

        <!-- ************************ -->
        <!-- Filter Tree Search Box   -->
        <!-- ************************ -->

        <div class="columns is-mobile">

        <div class="column">

            <!-- Filter Tree Search Box -->
            <div class="field has-addons is-fullwidth is-pulled-right">

                <p class="control has-icons-left has-icons-right">
                    <input class="input" type="text" placeholder="{page.filterbox.placeholder}" bind:value={filterquery} on:input="{handleQuery}">
                    <span class="icon is-small is-left">
                        <Icon name="search" size="{gui.icons.size}" color="{gui.icons.color}"/>
                    </span>
                </p>

                <div class="control">
                    <button class="button is-light px-1" on:click="{handleReset}">
                        <Icon name="cancel" size="{gui.icons.size}" color="lightgrey"/>
                    </button>
                </div>

            </div>
        </div>
        </div>


        {#if tabledata.data.length > 0}

        <!-- ************************ -->
        <!-- TABLE                    -->
        <!-- ************************ -->

        <table class="table is-fullwidth">

            <caption>Total <b>{tabledata.total}</b> Results</caption>

            <thead>
            <tr>
                <th>
                <span class="icon-text" on:click="{() => handleSort("title",false)}">
                    <span class="icon" class:is-hidden="{sortstatus['title'].hidden}"><Icon name="arrow_up" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
                    <span class="icon" class:is-hidden="{!sortstatus['title'].hidden}"><Icon name="arrow_down" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
                    <span>{page.form.input.label}</span>
                </span>
                </th>

                <th>
                <span class="icon-text" on:click="{() => handleSort("created_by",false)}">
                    <span class="icon" class:is-hidden="{sortstatus['created_by'].hidden}"><Icon name="arrow_up" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
                    <span class="icon" class:is-hidden="{!sortstatus['created_by'].hidden}"><Icon name="arrow_down" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
                    <span>Created By</span>
                </span>
                </th>

                <th>
                <span class="icon-text" on:click="{() => handleSort("created_at",false)}">
                    <span class="icon" class:is-hidden="{sortstatus['created_at'].hidden}"><Icon name="arrow_up" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
                    <span class="icon" class:is-hidden="{!sortstatus['created_at'].hidden}"><Icon name="arrow_down" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
                    <span>Created At</span>
                </span>
                </th>

                <th class="has-text-right">Actions</th>
            </tr>
            </thead>

            <tbody>

                {#each tabledata.data as item}
                <tr>
                    <td>                      
                    <a href="/simpleitem/{pagetype}/{item.id}">
                        {@html item.title}
                    </a>
                    </td>

                    <td>
                    <a href="{"#"}" on:click="{() => handleSort("created_by",item.created_by.id)}">
                        {item.created_by.email}
                    </a>
                    </td>

                    <td>{parseDateTime(item.created_at)}</td>

                    <td class="has-text-right">
                    <a href="/simpleitem/{pagetype}/{item.id}" class="icon">
                        <Icon name="eye" size="{gui.icons.size}" color="{gui.icons.color}"/>
                    </a>
                    <a href="/simpleitem-form/{pagetype}/{item.id}" class="icon">
                        <Icon name="edit" size="{gui.icons.size}" color="{gui.icons.color}"/>
                    </a>
                    </td>
                </tr>
                {/each}

            </tbody>

        </table>

        <Pagination pagination={tabledata} iconprops={gui.icons}/>

        {:else}

        <!-- ************************ -->
        <!-- NO ITEM IN DB            -->
        <!-- ************************ -->

        <div class="notification is-warning is-light">No data in system yet!</div>

        {/if}

    </div>

</Layout>