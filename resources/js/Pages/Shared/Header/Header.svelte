<script>

    export let header

    /*
    header = {
        title:"Title",
        subtitle:"Subtitle",
        isdefault:true
    }
    */

    if (header.isdefault == undefined) {
        header.isdefault = false
    }

</script>

<h1 class="title" class:mt-0={!header.isdefault} class:mb-6={!header.isdefault} class:has-text-weight-light={!header.isdefault}>{header.title}</h1>


{#if header.subtitle}
    <h2 class="subtitle is-4">{header.subtitle}</h2>
{/if}