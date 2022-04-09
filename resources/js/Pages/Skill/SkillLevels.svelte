<script>
    import { params } from '@/config/config.js'

    import Layout from '@/Pages/Shared/Layout.svelte'
    import LevelsInfo from '@/Pages/Skill/LevelsInfo.svelte'

</script>
        
  
<svelte:head>
    <title>{params.app.name} - (Skill) Proficiency Level Definitions</title>
</svelte:head>
    
<Layout>

    <section class="section container">

        <LevelsInfo />

    </section>

</Layout>