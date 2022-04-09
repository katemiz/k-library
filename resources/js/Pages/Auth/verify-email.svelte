<script>
    import {params} from '@/config/config.js'
    import { inertia } from '@inertiajs/inertia-svelte'

    export let status

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
    
          <div class="columns is-mobile">
              <div class="column is-4 is-offset-4">
                  <figure class="image">
                      <img src="/images/{params.app.app_header_logo}" alt="app main logo">
                  </figure>
              </div>
          </div>
  
          <div class="card-content">
            <div class="content">

                <p>
                    Thanks for signing up! Before getting started, could you verify your email address by 
                    clicking on the link we just emailed to you? If you didn't receive the email,
                    we will gladly send you another.
                </p> 
  
            </div>

            {#if status == 'verification-link-sent' }
            <div class="notification is-primary is-light">
                A new verification link has been sent to the email address you provided during registration.
            </div>
            {/if}
          </div>
    
      </div>

        <div class="column has-text-centered">

        <button use:inertia={{ method: 'post', href: '/email/verification-notification' }} class="button is-dark">Resend Verification Email</button>

        </div>

  </section>