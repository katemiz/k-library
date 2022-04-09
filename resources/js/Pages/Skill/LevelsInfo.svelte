<script>
    import { slevels } from '@/config/config_slevels.js'
</script>

<h1 class="title has-text-weight-semibold">Skill Levels</h1>
<h2 class="subtitle has-text-info">Proficiency Level Definitions</h2>

<p class="mb-3">
    Proficiency Levels shown below can be used to identify skill/knowledge requirements for professions/titles/roles identified.
</p>

<p class="mb-3">
    The number of levels may depend upon the complexity of the process or an existing company approach. 
    <a href="https://www.sae.org/iaqg/projects/pcap001.pdf">[See Ref]</a>
</p>

<div class="tile is-ancestor my-4">

    <div class="tile is-vertical">

        {#each slevels as slevel}
        <div class="tile">

            <div class="tile is-4 m-1">
                <article class="tile is-child notification has-background-info-light">
                    <h1 class="title has-text-weight-semibold is-size-4">{slevel.title}</h1>
                    <h2 class="subtitle has-text-info is-size-5">Level {slevel.level}</h2>
                    <figure class="image ">
                        <img src="/images/{slevel.image}" alt="{slevel.title}">
                    </figure>
                </article>
            </div>

            <div class="tile m-1">

                <div class="tile is-vertical">

                    <div class="tile">
                        <article class="tile is-child notification">
                            <h1 class="title has-text-weight-light mb-0 is-size-5 has-text-info-dark">Knowledge</h1>
                            <p>{slevel.knowledge}</p>
                        </article>
                    </div>

                    <div class="tile my-1">
                        <article class="tile is-child notification">
                            <h1 class="title has-text-weight-light mb-0 is-size-5 has-text-info-dark">Experience</h1>
                            <p>{slevel.experience}</p>
                        </article>
                    </div>

                    <div class="tile">
                        <article class="tile is-child notification">
                            <h1 class="title has-text-weight-light mb-0 is-size-5 has-text-info-dark">Autonomy</h1>
                            <p>{slevel.autonomy}</p>
                        </article>
                    </div>

                </div>
            </div>
        </div>
        {/each}

    </div>
</div>