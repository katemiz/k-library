<script>
  import {params} from '@/config/config.js'
  import { inertia } from '@inertiajs/inertia-svelte'
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
            <p class="subtitle has-text-centered my-4">Password Reset Request</p>
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

            <p>We have sent you an email with a password reset <strong>link</strong> upon your request.</p>
            <p>Password reset link will expire in 60 minutes.</p>

          </div>
        </div>

    </div>

    <div class="column has-text-centered">
      <button use:inertia={{ method: 'get', href: '/login' }} class="button is-dark">Login Page</button>
    </div>

</section>