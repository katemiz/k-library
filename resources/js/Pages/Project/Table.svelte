<script>

    import { page, useForm,Link } from '@inertiajs/inertia-svelte'

    export let projects
    export let filters;

    let queryFilter = filters.search;
    let timer

    function filterTable() {

        timer = setTimeout(() => {

            console.log("runs",queryFilter)

            Inertia.get('/users',{search:queryFilter},{
                preserveState:true,
                replace:true
            })

        } , 750);
    }

</script>


{#if projects.length > 0}

    <h1 class="title">Users</h1>

    <div class="field has-addons">
        <div class="control">
        <input class="input" type="text" bind:value={queryFilter} placeholder="Find a repository" on:input={() => filterTable()}>
        </div>
        <div class="control">
        <a class="button is-info" href="{"#"}">Search</a>
        </div>
    </div>

    <table class="table is-fullwidth">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </tfoot>
        <tbody>

            {#each projects.data as project}

                <tr>
                    <td>{project.name}</td>
                    <td>{project.email}</td>
                    <td>{project.created_at}</td>

                    <td><Link href="/users/{project.id}">Edit</Link></td>
                </tr>

            {/each}
        </tbody>
    </table>

    <nav class="pagination is-centered" aria-label="pagination">

        <Link
            class="pagination-previous {!projects.prev_page_url ? 'is-disabled' :''}"
            href="{projects.prev_page_url ? projects.prev_page_url :'#'}">
            Previous
        </Link>

        <Link
            class="pagination-next {!projects.next_page_url ? 'is-disabled' :''}"
            href="{projects.next_page_url ? projects.next_page_url :'#'}">
            Next Page
        </Link>

        <ul class="pagination-list">

            {#each projects.links as link,i}
                {#if i >0 && i < projects.links.length-1}

                    <li>
                        <a
                            class="pagination-link {link.active ? 'is-current':''}"
                            href="{link.url}"
                            aria-label="Goto page {link.url}">
                            {link.label}
                        </a>
                    </li>

                {/if}
            {/each}

        </ul>
    </nav>


{:else}

    <article class="message is-warning">
        <div class="message-body">
        No project found in system.
        </div>
    </article>

{/if}

