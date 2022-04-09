<script>

  import {params} from '@/config/config.js'
  import {pageprops} from '@/config/config_roles.js'

  import Layout from '@/Pages/Shared/Layout.svelte'
  import Header from '@/Pages/Shared/Header/Header.svelte'

</script>

<svelte:head>
    <title>{params.app.name} - {pageprops.page.title}</title>
</svelte:head>

<Layout>

  <section class="section container">

    <Header header="{{ title:pageprops.page.title,subtitle:pageprops.page.subtitle,type:pageprops.page.type.type }}" />

    <div class="columns">

      <div class="column is-3">

        <aside class="menu">
          
          <p class="menu-label">Menu</p>
          <ul class="menu-list">
            <li><a href="/roles-list">List Available</a></li>
            <li><a href="/roles/form/new">Add New Role</a></li>
          </ul>
          
        </aside> 
      </div>

      <div class="column">
        <p>{pageprops.description}</p>
        <figure class="image ">
          <img src="images/{pageprops.image}" alt="Roles intro">
        </figure>
      </div>

    </div>

  </section>
    
</Layout>