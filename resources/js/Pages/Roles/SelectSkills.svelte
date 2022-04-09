<script>
  import { params,gui } from '@/config/config.js'
  import { slevels } from '@/config/config_slevels.js'
  import { flat } from "@/Pages/Shared/Functions/tree.js";

  import Tree from '@/Pages/Shared/Tree/Tree.svelte'
  import Layout from '@/Pages/Shared/Layout.svelte'
  import LevelsInfo from '@/Pages/Skill/LevelsInfo.svelte'
  import Icon from '@/Pages/Shared/Icon.svelte'

  import { Inertia } from '@inertiajs/inertia'

  import Swal from "sweetalert2"

  export let id
  export let role
  export let skilltree
  export let roleSkills

  let showModal = false
  let currentSkillIds = []

  roleSkills.forEach( el => {
    currentSkillIds.push(parseInt(el.id))
  })

  let rawdata = flat(skilltree)

  let requirements = []
  let roleLevels = []

  roleSkills.forEach(element => {
    requirements[requirements.length] = rawdata.filter( el => el.id == element.id)[0]
    roleLevels[element.id] = element.pivot.level
  });

  let selectedSkill

  function nodeClick(event) {

    // event.target.dataset.id is id of node clicked on tree
    selectedSkill = rawdata.filter( el => el.id == event.target.dataset.id)[0]

    if ( currentSkillIds.includes(parseInt(event.target.dataset.id)) ) {

      Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'Clicked skill is already included',
        showConfirmButton: false,
        timer: 1000
      })
    } else {
      requirements[requirements.length] = selectedSkill;
      currentSkillIds.push(parseInt(event.target.dataset.id))
    }
  }


  function removeSkill(deger) {

    currentSkillIds = currentSkillIds.filter(function(e) { return e !== deger })
    delete currentSkillIds[deger]
    requirements = requirements.filter(function(e) { return e.id !== deger })
  }


  function saveSkills () {

    let skills = []

    roleLevels.forEach( (value,key) => {

      if (value !== undefined && value !== null) {

        if (value === 'NotSelected') {
          value = null
        }
        skills.push({skill:key,level:value})
      }
    })

    Inertia.post('/role-skill', {id:id,skills: skills},{
      preserveState:false
    })
  }


  function showInfo() {
    showModal = !showModal
  }

  const treeprops = {

    titleColumn:"title_en",
    expanded:false,
    title:"SELECT SKILLS FROM THIS TREE",
    boxTitle:"My Tree",
    home:"My First Node title",
    filter_placeholder:"Search in tree ...",

    commands:{
      add:false
    }
  }

</script>
        
  
<svelte:head>
    <title>{params.app.name} - Required Skills and Skill Levels</title>
</svelte:head>

    
<Layout>

  <section class="section container">

    <div class="columns">

      <div class="column">
          <h1 class="title has-text-weight-light">{role.title_en}</h1>
          <h2 class="subtitle">Skills and Skill Levels</h2>
      </div>

      <div class="column is-4">

        <div class="buttons is-pulled-right">
          <button class="button is-small is-link is-light" on:click="{saveSkills}">
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

    {#if requirements.length > 0}

    <div class="columns">

      <div class="column is-2 has-background-light has-text-centered has-text-link" on:click="{showInfo}">
        <p>
              <Icon name="info" size="{gui.icons.size}" color="{gui.icons.color}"/>
        </p> 
        <p>
      Skill Levels Guideline
    </p> 
      </div>


      <div class="column">

        <table class="table is-fullwidth">

          <thead>
            <tr>
              <th>Remove</th>
              <th>Skill</th>
              <th>Skill Level</th>
            </tr>
          </thead>
    
          <tbody>
    
            {#each requirements as requirement}
            <tr>
              <td>
                <a href="{"#"}" class="icon" on:click={removeSkill(requirement.id)}>
                  <Icon name="remove_from_list" size="{gui.icons.size}" color="danger"/>
                </a>
              </td>
              <td>{requirement.title_en}</td>
              <td>
                
                <div class="field">
    
                  <div class="control">
      
                      <div class="select is-fullwidth">
                          <select bind:value={roleLevels[requirement.id]}>
                              <option value="0">Select ...</option>
      
                              {#each slevels as level}
                                  <option value="{level.level}">{level.title}</option>
                              {/each}
                          </select>
                      </div>
      
                  </div>
                </div>
                
              </td>
        
            </tr>
            {/each}
    
          </tbody>
    
        </table>

      </div>

    </div>

    {:else}

      <div class="notification is-warning">
        No skill requirements has been defined for this role yet.<br>
      </div>

    {/if}

    <Tree treeprops={treeprops} treedata={skilltree} iconprops={gui.icons} {nodeClick} addClick="false"/>

  </section>

</Layout>





<div class="modal" class:is-active="{showModal}">
  <div class="modal-background" on:click="{showInfo}"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Skill Level Selection Guideline</p>
      <button class="delete" aria-label="close" on:click="{showInfo}"></button>
    </header>
    <section class="modal-card-body">
      <LevelsInfo />
    </section>
  </div>
</div>