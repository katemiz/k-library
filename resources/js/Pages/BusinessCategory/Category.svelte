<script>

  import { params,gui } from '@/config/config.js'
  import { treeprops,topnode } from '@/config/config_category.js'
	import { flat } from "@/Pages/Shared/Functions/tree.js";

  import Index from '@/Pages/BusinessCategory/Index.svelte'
  import Form from '@/Pages/BusinessCategory/Form.svelte'
  import Show from '@/Pages/BusinessCategory/Show.svelte'

  import Layout from '@/Pages/Shared/Layout.svelte'
  import Tree from '@/Pages/Shared/Tree/Tree.svelte'
  import Header from '@/Pages/Shared/Header/Header.svelte'

  export let treedata
  export let item 
  export let paction
  export let notification = false

  $: rawdata = flat(treedata)
  $: parent = findParent(item)

  let itemValues = false
  let selectedParentId = false

  function editNode (event) {

    itemValues = event.detail.item
    paction = 'update'
  }

  function addChild (event) {

    selectedParentId = event.detail.id
    itemValues = false

    paction = 'new'
  }

  function addClick() {
    itemValues = false
    selectedParentId = false
    notification = false
    paction = 'new'
  }

  function nodeClick(event) {

    itemValues = false
    selectedParentId = false
    notification = false
    paction ='show'

    // event.target.dataset.id is id of node clicked on tree
    item = rawdata.filter( el => el.id == event.target.dataset.id)[0]

    parent = findParent(item)
  }


  function findParent(item) {

    if (item.parent_id == 0) {
      return topnode
    } else {
      return rawdata.filter( el => el.id == item.parent_id)[0]
    }
  }

</script>
      

<svelte:head>
    <title>{params.app.name} - Business Categories</title>
</svelte:head>
    
<Layout>

  <div class="section container">

    <Header header="{{ title:"Business Categories" }}" />

    <div class="columns">

      <div class="column is-4 has-background-grey-ter">
        <Tree iconprops={gui.icons} {treeprops} treedata={treedata} {nodeClick} {addClick}/>
      </div>

      <div class="column">

        {#if paction == 'index'}
          <Index {notification}/>
        {/if}

        {#if paction == 'show'}
          <Show {item} {notification} {parent} on:editnode={editNode} on:addchild={addChild}/>
        {/if}

        {#if paction == 'new'}
          <Form {treedata} {itemValues} {selectedParentId}/>
        {/if}

        {#if paction == 'update'}
          <Form {treedata} {itemValues} {selectedParentId}/>
        {/if}

      </div>

    </div>

  </div>

</Layout>