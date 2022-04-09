<script>

  import {params,gui} from '@/config/config.js'
  import {pageprops,formprops,categoryprops} from '@/config/config_roles.js'

  import { parseDateTime } from '@/Pages/Shared/Functions/time.js'


  import Layout from '@/Pages/Shared/Layout.svelte'


  import { Inertia } from '@inertiajs/inertia'
  import Pagination from '@/Pages/Shared/Pagination/Pagination.svelte'
  import Notification from '@/Pages/Shared/Notification/Notification.svelte'
  import Header from '@/Pages/Shared/Header/Header.svelte'
  import Icon from '@/Pages/Shared/Icon.svelte'

  export let roles
  export let filters
  export let notification

  let filterquery = filters.search ? filters.search:''
  let category
  //let category = filters.category


  let userid
  let sortcolumn
  let sortorder
  let sortstatus = {

    category:{
      order:'asc',
      hidden:false
    },

    title_en:{
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

    if (col == 'created_by') {
      userid = id
    }

    if (col == 'category') {
      category = id
    }

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

    if (category) {
      params.category = category
    }

    Inertia.get("/roles-list",params, {
      preserveState:true
    })

  }

  function handleReset () {
    filterquery = ''
    category= ''
    Inertia.get("/roles-list")
  }

</script>



<svelte:head>
    <title>{params.app.name} - {pageprops.headers.list}</title>
</svelte:head>




<Layout>

  <div class="section container">


  <Header header="{{ title:pageprops.headers.list }}" />

  {#if notification}
    <Notification {notification} />
  {/if}

  <!-- ***************** -->
  <!-- ADD BUTTON        -->
  <!-- ***************** -->

  <div class="column">

    <div class="buttons has-addons is-left">

      <a href="/roles/form/new" class="button is-light">
        <span class="icon is-small">
            <Icon name="add" size="{gui.icons.size}" color="{gui.icons.color}"/>
        </span>
        <span>{pageprops.commands.add.label}</span>
      </a>

    </div>
  </div>




  {#if roles.data.length > 0}

    <!-- ************************ -->
    <!-- Filter Tree Search Box   -->
    <!-- ************************ -->

    <div class="columns is-mobile">
      <div class="column is-4 is-offset-8">

        <!-- Filter Tree Search Box -->
        <div class="field has-addons is-fullwidth">

            <p class="control has-icons-left has-icons-right">
                <input class="input" type="text" placeholder="{pageprops.table.filter.placeholder}" bind:value={filterquery} on:input="{handleQuery(0)}">
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


    <!-- ************************ -->
    <!-- TABLE                    -->
    <!-- ************************ -->

    <table class="table is-fullwidth">

      <caption>Total <b>{roles.total}</b> Results</caption>

      <thead>
        <tr>

          <th>
            <span class="icon-text" on:click="{() => handleSort("category",false)}">
              <span class="icon" class:is-hidden="{sortstatus['category'].hidden}"><Icon name="arrow_up" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
              <span class="icon" class:is-hidden="{!sortstatus['category'].hidden}"><Icon name="arrow_down" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
              <span>Category</span>
            </span>
          </th>

          <th>
            <span class="icon-text" on:click="{() => handleSort("title_en",false)}">
              <span class="icon" class:is-hidden="{sortstatus['title_en'].hidden}"><Icon name="arrow_up" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
              <span class="icon" class:is-hidden="{!sortstatus['title_en'].hidden}"><Icon name="arrow_down" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
              <span>Title</span>
            </span>
          </th>

          <th>
            <span class="icon-text" on:click="{() => handleSort("created_at",false)}">
              <span class="icon" class:is-hidden="{sortstatus['created_at'].hidden}"><Icon name="arrow_up" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
              <span class="icon" class:is-hidden="{!sortstatus['created_at'].hidden}"><Icon name="arrow_down" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
              <span>Created At</span>
            </span>
          </th>

          <th>
            <span class="icon-text" on:click="{() => handleSort("created_by",false)}">
              <span class="icon" class:is-hidden="{sortstatus['created_by'].hidden}"><Icon name="arrow_up" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
              <span class="icon" class:is-hidden="{!sortstatus['created_by'].hidden}"><Icon name="arrow_down" size="{gui.icons.size}" color="{gui.icons.color}"/></span>
              <span>Created By</span>
            </span>
          </th>

          <th class="has-text-right">Actions</th>
        </tr>
      </thead>

      <tbody>
        {#each roles.data as item}

          <tr>
              <td><a href="{"#"}" on:click="{() =>handleSort("category",item.category.id)}">{@html item.category.title_en}</a></td>
              <td><a href="/roles/{item.id}">{@html item.title_en}</a></td>
              <td>{parseDateTime(item.created_at)}</td>

              <td>
                <a href="{"#"}" on:click="{() => handleSort("created_by",item.created_by.id)}">
                  {item.created_by.email}
                </a>
              </td>

              <td class="has-text-right">
                  <a href="/roles/{item.id}" class="icon">
                      <Icon name="eye" size="{gui.icons.size}" color="{gui.icons.color}"/>
                  </a>
                  <a href="/roles/form/{item.id}" class="icon">
                      <Icon name="edit" size="{gui.icons.size}" color="{gui.icons.color}"/>
                  </a>
              </td>
          </tr>

        {/each}
      </tbody>

    </table>

    <Pagination pagination={roles} iconprops={gui.icons}/>

  {:else}

    <!-- ************************ -->
    <!-- NO ITEM IN DB            -->
    <!-- ************************ -->

    <div class="notification is-warning is-light">No roles found in system yet!</div>

  {/if}

  </div>

</Layout>