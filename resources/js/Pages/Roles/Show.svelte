<script>
    import { params,gui } from '@/config/config.js'
    import { pageprops,formprops,diplomaOptions,professionCriteria } from '@/config/config_roles.js'
    import { slevels } from '@/config/config_slevels.js'
    import { langlevels } from '@/config/config_langlevels.js'
    
    import Layout from '@/Pages/Shared/Layout.svelte'
    import Icon from '@/Pages/Shared/Icon.svelte'
    import Notification from '@/Pages/Shared/Notification/Notification.svelte'

    export let item
    export let skills
    export let languages
    export let diplomas
    export let professions

    export let notification

    console.log(item)
    console.log(professions)

</script>

<svelte:head>
    <title>{params.app.name} - {pageprops.headers.show}</title>
</svelte:head>

<Layout>

    <section class="section container">

        <!-- <div class="columns">

            <div class="column">
                <h1 class="title has-text-weight-semibold">{item.title_en}</h1>
                <h2 class="subtitle has-text-info">Summary</h2>
            </div>

            <div class="column is-1 is-pulled-right">
                <a href="/roles/form/{item.id}">
                <Icon name="edit" size="{gui.icons.size}" color="{gui.icons.color}"/>
                </a>
            </div>

        </div> -->


        <h1 class="title has-text-weight-semibold">{item.title_en}</h1>
        <h2 class="subtitle has-text-info">Summary</h2>

        <Notification {notification} />


        <!-- DESCRIPTION       -->
        <div class="columns">

            <div class="column">
                <h6 class="subtitle is-size-6 my-4 has-text-grey-light">Description</h6>
            </div>

            <div class="column is-1 is-pulled-right">
                <a href="/roles/form/{item.id}">
                <Icon name="edit" size="{gui.icons.size}" color="{gui.icons.color}"/>
                </a>
            </div>

        </div>

        {#if item.desc_en.length > 0}
            {@html item.desc_en}
        {/if}

        
        {#if item.desc_tr.length > 0}
            {@html item.desc_tr}
        {/if}

    
        <!-- DIPLOMA EDUCATION LEVELS -->
        <div class="columns">

            <div class="column">
                <h6 class="subtitle is-size-6 my-4 has-text-grey-light">Diploma/Education Level</h6>
            </div>

            <div class="column is-1 is-pulled-right">
                <a href="/role-diploma/{item.id}">
                <Icon name="edit" size="{gui.icons.size}" color="{gui.icons.color}"/>
                </a>
            </div>

        </div>

        {#if diplomas.length > 0}
        <table class="table is-narrow is-fullwidth">

            <thead>
            <tr>
                <th>No</th>
                <th>Diploma/Education Level</th>
                <th class="has-text-right">Provision</th>
            </tr>
            </thead>

            {#each diplomas as diploma,key}
            <tr>
                <td>{key+1}</td>
                <td>{diploma.title}</td>

                {#if parseInt(diploma.pivot.status) > 0 }
                    <td class="has-text-right">{diplomaOptions.filter(el => el.id === parseInt(diploma.pivot.status))[0].title}</td>
                {:else}
                    <td class="has-text-right">Not Set</td>
                {/if}
            </tr>
            {/each}

        </table>
        {:else}

            <div class="notification is-warning is-light">
            No diploma/education level requirement for this role yet.
            </div>

        {/if}




        <!-- PROFESSION       -->
        <div class="columns">

            <div class="column">
                <h6 class="subtitle is-size-6 my-4 has-text-grey-light">Professions</h6>
            </div>

            <div class="column is-1 is-pulled-right">
                <a href="/role-profession/{item.id}">
                <Icon name="edit" size="{gui.icons.size}" color="{gui.icons.color}"/>
                </a>
            </div>

        </div>

        {#if professions.length > 0}
        <table class="table is-narrow is-fullwidth">

            <thead>
            <tr>
                <th>No</th>
                <th>Profession</th>
                <th class="has-text-right">Provision</th>
            </tr>
            </thead>

            {#each professions as profession,key}
            <tr>
                <td>{key+1}</td>
                <td>{profession.title}</td>

                {#if parseInt(profession.pivot.provision) > 0 }
                    <td class="has-text-right">{professionCriteria.filter(el => el.id === parseInt(profession.pivot.provision))[0].title}</td>
                {:else}
                    <td class="has-text-right">Not Set</td>
                {/if}
            </tr>
            {/each}

        </table>
        {:else}

            <div class="notification is-warning is-light">
            No profession requirement for this role yet.
            </div>

        {/if}


        <!-- EXPERIENCE          -->
        <div class="columns">

            <div class="column">
                <h6 class="subtitle is-size-6  my-4 has-text-grey-light">Experience</h6>
            </div>

            <div class="column is-1 is-pulled-right">
                <a href="/role-experience/{item.id}">
                <Icon name="edit" size="{gui.icons.size}" color="{gui.icons.color}"/>
                </a>
            </div>

        </div>


        {#if item.experience.length > 0}

            {@html item.experience}

        {:else}

        <div class="notification is-warning is-light">
            No experience has been added for this role yet.
            </div>
        {/if}


        <!-- SKILLS          -->
        <div class="columns">

            <div class="column">
                <h6 class="subtitle is-size-6 my-4 has-text-grey-light">Required Skills and Skill Levels</h6>
            </div>

            <div class="column is-1 is-pulled-right">
                <a href="/role-skills/{item.id}">
                <Icon name="edit" size="{gui.icons.size}" color="{gui.icons.color}"/>
                </a>
            </div>

        </div>


        {#if skills.length > 0}
        <table class="table is-narrow is-fullwidth">

            <thead>
            <tr>
                <th>No</th>
                <th>Skill</th>
                <th class="has-text-right">Skill Level</th>
            </tr>
            </thead>

            {#each skills as skill,key}
            <tr>
                <td>{key+1}</td>
                <td>{skill.title_en}</td>

                {#if skill.pivot.level >0 }
                <td class="has-text-right">{skill.pivot.level} - { slevels.filter(el => el.level === skill.pivot.level)[0].title}</td>
                {:else}
                <td class="has-text-right">Not Set</td>
                {/if}
            </tr>

            {/each}

        </table>
        {:else}

            <div class="notification is-warning is-light">
            No skills for this role yet.
            </div>

        {/if}


        <!-- LANGUAGE          -->

        <div class="columns">

            <div class="column">
                <h6 class="subtitle is-size-6 my-4 has-text-grey-light">Language Knowledge</h6>
            </div>

            <div class="column is-1 is-pulled-right">
                <a href="/role-language/{item.id}">
                <Icon name="edit" size="{gui.icons.size}" color="{gui.icons.color}"/>
                </a>
            </div>

        </div>


        {#if languages.length > 0}
        <table class="table is-narrow is-fullwidth">

            <thead>
            <tr>
                <th>No</th>
                <th>Language</th>
                <th class="has-text-right">Level</th>
            </tr>
            </thead>

            {#each languages as lang,key}
            <tr>
                <td>{key+1}</td>
                <td>{lang.title}</td>

                {#if lang.pivot.level }
                <td class="has-text-right">{lang.pivot.level} - { langlevels.filter(el => el.level == lang.pivot.level)[0].title}</td>
                {:else}
                <td class="has-text-right">Not Set</td>
                {/if}
            </tr>

            {/each}

        </table>
        {:else}

            <div class="notification is-warning is-light">
            No language requirement for this role yet.
            </div>

        {/if}



    </section>
      
  </Layout>