<script>

  import {params} from '@/config/config.js'

  import Layout from '@/Pages/Shared/Layout.svelte'
  import Hero from '@/Pages/Components/Hero.svelte'
  import Greet from '@/Pages/Components/Greet.svelte'


  /* 
    import Swal from "sweetalert2"

    let urlparams = new URLSearchParams(window.location.search);

    if ( urlparams.get('logout') ) {

        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Logout has been performed',
            showConfirmButton: false,
            timer: 1800
        })
    } 
  */




</script>


<svelte:head>

  <title>{params.app.title}</title>
  <meta name="description" content="{params.app.description}" />
    
</svelte:head>


<Layout>

  <!-- <Hero /> -->


  <Greet />

</Layout>