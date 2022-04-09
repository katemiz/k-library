<script>
  import {params} from '@/config/config.js'
  import { inertia } from '@inertiajs/inertia-svelte'

  export let user

</script>

<svelte:head>
  <style>

    html {
        height:100%;
    }
    body {
        background:#e6e6e6;
        min-height:100%;
    }
  </style>
</svelte:head>


<section class="section container is-max-desktop">

    <div class="card">

        <div class="card-content">
            <p class="title has-text-centered my-4">One Last Step</p>
        </div>

        <div class="columns is-mobile">
          <div class="column is-4 is-offset-4">
              <figure class="image">
                  <img src="/images/{params.app.app_header_logo}" alt="app main logo">
              </figure>
          </div>
        </div>

        <div class="card-content">
          <div class="content">
            <p class="mb-4">Dear {user.fullname},</p>

            <p>We have <strong>just</strong> sent an email with a confirmation link to your email address.</p>
            <p>Please allow 5-10 minutes for this message to arrive and also check your <strong>spam</strong> folder</p>

          </div>
        </div>

    </div>

    <div class="column has-text-centered">
      <button use:inertia={{ method: 'get', href: '/login' }} class="button is-dark">Login Page</button>
      <!-- <button use:inertia={{ method: 'post', href: '/email/verification-notification' }} class="button is-dark">Resend Verification Email</button> -->
    </div>

</section>