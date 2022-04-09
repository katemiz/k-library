<script>
    import {params} from '@/config/config.js'
</script>


<footer class="footer has-background-ligher" id="footer">

    <div class="tile is-ancestor">

        <article class="tile is-child notification has-text-centered-mobile">
            <img src="/images/{params.company.logo}" width="28px" alt="Company Icon">

            <p class="has-text-weight-light">{params.company.name}</p>
            <p class="has-text-weight-light">{params.company.motto}</p>
        </article>

        <article class="tile is-child notification has-text-centered my-6">
            <p class="has-text-weight-light">{params.app.title}</p>
            <img class="mt-3 mt-1-mobile pt-3 pt-1-mobile" src="/images/{params.app.app_footer_logo}" width="80px" alt="App Logo">
        </article>

        <article class="tile is-child notification">
            <p class="has-text-weight-light has-text-right has-text-centered-mobile">{params.app.copyright}</p>
            <p class="has-text-weight-light has-text-right has-text-centered-mobile">{params.app.version}</p>
        </article>

    </div>

</footer>

<nav class="breadcrumb is-centered has-bullet-separator is-small" aria-label="breadcrumbs">
    <ul>
        {#each params.stack as tech }
        <li>
        <a href="{tech.url}">{tech.name}</a>  
        </li>
        {/each}      
    </ul>
</nav>