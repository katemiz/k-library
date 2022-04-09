<script>

import Layout from '../Shared/Layout.svelte'
import { page,Link } from '@inertiajs/inertia-svelte'
import Table from './Table.svelte'

export let projects
export let filters

</script>
  
  
<svelte:head>

    <title>Admin - Projects</title>
    <meta name="description" content="Your page description" />
    
</svelte:head>
  
  
<Layout>

    <section class="section container">

        <h1 class="title">Projects</h1>

        <div class="columns">

            <div class="column is-3">

                <aside class="menu">

                    <p class="menu-label">Menu</p>
            
                    <ul class="menu-list">
                        <li><Link href="/projects">Create</Link></li>
                        <li><Link href="/projects">Other</Link></li>
                    </ul>
            
                </aside>

            </div>

            <div class="column">

                <Table projects="{projects}" filters="{filters}"/>
                
            </div>
        </div>

    </section>

</Layout>