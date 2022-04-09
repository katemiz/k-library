<script>
    import Layout from '../Shared/Layout.svelte'
    import { page, useForm,Link } from '@inertiajs/inertia-svelte'

    export let users







    export let filters;

    let queryFilter = filters.search;
    let timer

    function filterTable() {



        timer = setTimeout(() => {
			//val = counter;

            console.log("runs",queryFilter)

            Inertia.get('/users',{search:queryFilter},{
                preserveState:true,
                replace:true
            })

        } , 750);

    }












</script>

<svelte:head>

    <title>List of Users</title>
    <meta name="description" content="Your page description" />

</svelte:head>


<Layout>


    <Link href="/signup" class="button is-ghost" as="button" >Sign Up</Link>


    <section class="section container">

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

                {#each users.data as user}

                    <tr>
                        <td>{user.name}</td>
                        <td>{user.email}</td>
                        <td>{user.created_at}</td>

                        <td><Link href="/users/{user.id}">Edit</Link></td>
                    </tr>

                {/each}
            </tbody>
        </table>

        <nav class="pagination is-centered" aria-label="pagination">

            <Link
                class="pagination-previous {!users.prev_page_url ? 'is-disabled' :''}"
                href="{users.prev_page_url ? users.prev_page_url :'#'}">
                Previous
            </Link>

            <Link
                class="pagination-next {!users.next_page_url ? 'is-disabled' :''}"
                href="{users.next_page_url ? users.next_page_url :'#'}">
                Next Page
            </Link>

            <ul class="pagination-list">

                {#each users.links as link,i}
                    {#if i >0 && i < users.links.length-1}

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

    </section>

</Layout>