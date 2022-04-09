<script>

    export let headers
    export let footer=false

    let baslik,ayaklik

    if (!footer) {
        baslik = '<thead>'
        ayaklik = '</thead>'

    } else{
        baslik = '<tfoot>'
        ayaklik = '</tfoot>'
    }

</script>

{@html baslik}

    <tr>
        {#each headers as header}
            <th>{header}</th>
        {/each}
    </tr>

{@html ayaklik}
