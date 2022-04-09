<script>
  import { params,gui } from '@/config/config.js'
  import { pageprops,treeprops,topnode } from '@/config/config_skill.js'

	import { flat } from "@/Pages/Shared/Functions/tree.js";
  
  import Layout from '@/Pages/Shared/Layout.svelte'
  import Tree from '@/Pages/Shared/Tree/Tree.svelte'
  import Index from '@/Pages/Skill/Index.svelte'
  import Form from '@/Pages/Skill/Form.svelte'
  import Show from '@/Pages/Skill/Show.svelte'
  import Header from '@/Pages/Shared/Header/Header.svelte'

  export let treedata
  export let item = false 
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
    <title>{params.app.name} - {pageprops.page.title}</title>
</svelte:head>
    
<Layout>

  <div class="section container">

    <Header header="{{ title:pageprops.page.title }}" />

    <div class="columns">

      <div class="column is-4 has-background-grey-ter">
        <Tree treeprops={treeprops} treedata={treedata} iconprops={gui.icons} {nodeClick} {addClick}/>
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