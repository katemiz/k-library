<script>
  import { params } from '@/config/config.js'
  import Layout from '@/Pages/Shared/Layout.svelte'

  function hilight(el) {
    let secilen = el.target.dataset.type
    console.log(secilen)

    let selected = asset_types.filter((el) => el.type == secilen)[0]

    selected.hilight = !selected.hilight
  }

  const asset_types = [
    {
      title: 'Images-Pictures',
      type: 'image',
      image: 'type_image.svg',
      hilight: false,
    },
    {
      title: 'Videos-Movies',
      type: 'video',
      image: 'type_video.svg',
      hilight: false,
    },

    {
      title: 'Books',
      type: 'book',
      image: 'type_book.svg',
      hilight: false,
    },

    {
      title: 'Other - Any Type',
      type: 'file',
      image: 'type_file.svg',
      hilight: false,
    },
  ]
</script>

<svelte:head>
  <title>{params.app.name} - Select Digital Asset Type</title>
</svelte:head>

<Layout>

  <div class="section container">

    <h1 class="title mt-6 has-text-weight-light is-size-1 has-text-left">
      Asset Type Selection
    </h1>
    <h1 class="subtitle has-text-weight-light">Select Digital Asset Type</h1>

    <div class="columns mt-6">

      {#each asset_types as type}
        <div class="column">

          <div class="card">
            <div class="card-image">
              <a href="/assets-form/{type.type}">
                <figure class="image is-4by3">
                  <img src="/images/{type.image}" alt={type.type} />
                </figure>
              </a>
            </div>
          </div>

          <div class="card-content">
            <div class="media">

              <div class="media-content has-text-centered">
                <a
                  href="/assets-form/{type.type}"
                  class="title is-5 has-text-weight-light">
                  {type.title}
                </a>
              </div>
            </div>

          </div>

        </div>
      {/each}

    </div>

  </div>
</Layout>
