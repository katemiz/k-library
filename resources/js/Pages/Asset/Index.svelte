<script>

  import { pageprops } from '@/config/config_category.js'

  import Notification from '@/Pages/Shared/Notification/Notification.svelte'
  import Header from '@/Pages/Shared/Header/Header.svelte'

  export let notification

</script>

<Header header="{{title:"Business Categories"}}" />
<Notification {notification} />

<p class="mb-3">
  {pageprops.description}
</p>

<figure class="image ">
  <img src="images/{pageprops.image}" alt="intro">
</figure>