<script>
    import Icon from '@/Pages/Shared/Icon.svelte'

    export let item

    const addtime = new Date(item.created_at)
    const updatetime = new Date(item.updated_at)

    let ishidden = true

    function toggle () {
        ishidden = !ishidden
    }

</script>


<div class="column has-text-right">
    <button class="button is-ghost" on:click="{toggle}">
        <span class="icon is-small">
            <Icon name="info" size="S" color="link"/>
        </span>
      </button>
</div>


<div class="columns mt-3" class:is-hidden="{ishidden}">

    <div class="column is-half">
        <p class="has-text-weight-light is-size-7">Created By</p>
        <p>{item.created_by.email}</p>
        <p class="has-text-weight-light is-size-7">{addtime.toString()}</p>
        <p class="has-text-weight-light is-size-7">{item.created_diff}</p>
    </div>
    
    {#if item.updated_at && item.updated_by}
    <div class="column has-text-right">
        <p class="has-text-weight-light is-size-7">Last Updated By</p>
        <p>{item.updated_by.email}</p>
        <p class="has-text-weight-light is-size-7">{updatetime.toString()}</p>
        <p class="has-text-weight-light is-size-7">{item.updated_diff}</p>
    </div>
    {/if}

</div>