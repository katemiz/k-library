<script>
    import {params,gui} from '@/config/config.js'
    import { useForm } from '@inertiajs/inertia-svelte'
    import Icon from '@/Pages/Shared/Icon.svelte'

    let form = useForm({
        email:'',
    })

    let submit = () => {
        $form.post('/forgot-password')
    }

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

    <div class="column is-half is-offset-one-quarter">

        <a href="{params.company.link}">
            <img src="/images/{params.company.logo}" alt="Intro" width="24px">
        </a>

    </div>

    <div class="column is-half is-offset-one-quarter has-background-white">

        <div class="column is-offset-3 is-offset-4-mobile is-6 is-4-mobile my-6">
            <figure class="image"><img src="/images/{params.app.app_header_logo}" alt="deneme"></figure>
        </div>

        <div class="notification is-warning is-light">
            Forgot your password? No problem.
            Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

        <form on:submit|preventDefault={submit} class="mx-4">

            <!-- Email Address -->
            <div class="field">

                <label class="label has-text-weight-light" for="email">Email</label>

                <div class="control has-icons-left has-icons-right">

                    <input class="input" bind:value={$form.email} type="email" placeholder="Enter email" required >

                    <span class="icon is-left">
                        <Icon name="mail" size="{gui.icons.size}" color="{gui.icons.color}"/>
                    </span>

                    {#if $form.errors.email}
                        <p class="help is-danger">{$form.errors.email}</p>
                    {/if}
                </div>
            </div>

            <button class="button is-danger my-6 is-fullwidth">Reset My Password</button>

            <div class="columns">
                <div class="column is-half">
                    <p class="is-size-6 has-text-weight-light my-3">
                        <a href="/login">Login</a>
                    </p>
                </div>

                <div class="column">
                    <p class="has-text-right is-size-6 has-text-weight-light my-3">
                        <a href="/register">Register</a>
                    </p>
                </div>
            </div>

        </form>

    </div>


    <div class="column is-half is-offset-one-quarter has-text-right">
        <a href="{params.company.link}">{params.company.name}</a>
    </div>

</section>