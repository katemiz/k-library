<script>
    import Icon from '@/Pages/Shared/Icon.svelte'
    import { Link } from '@inertiajs/inertia-svelte'

    export let pagination
    export let iconprops 
</script>

{#if pagination.last_page > 1}
<nav class="pagination is-small is-centered" aria-label="pagination">

    {#if pagination.prev_page_url != null}
    <Link
        class="pagination-previous {!pagination.prev_page_url ? 'is-disabled' :''}"
        href="{pagination.prev_page_url ? pagination.prev_page_url :'#'}">
        <Icon name="previous" size="{iconprops.size}" color="{iconprops.color}"/>
    </Link>
    {/if}

    {#if pagination.next_page_url != null}
    <Link
        class="pagination-next {!pagination.next_page_url ? 'is-disabled' :''}"
        href="{pagination.next_page_url ? pagination.next_page_url :'#'}">
        <Icon name="next" size="{iconprops.size}" color="{iconprops.color}"/>
    </Link>
    {/if}

    <ul class="pagination-list">

        {#each pagination.links as link,i}
            {#if i >0 && i < pagination.links.length-1}

                <li>
                    <Link
                        class="pagination-link {link.active ? 'is-current':''}"
                        href="{link.url}"
                        aria-label="Goto page {link.url}">
                        {link.label}
                </Link>
                </li>

            {/if}
        {/each}

    </ul>
</nav>
{/if}
