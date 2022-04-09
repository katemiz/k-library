<script>
    import {params,gui} from '@/config/config.js'
    import { Inertia } from '@inertiajs/inertia'
    import Icon from '@/Pages/Shared/Icon.svelte'

    export let errors = {}
    export let status = false

    let processing = false

    let values = {
        email:null,
        password:null,
    }

    function handleSubmit() {

        Inertia.post('/login', values,{
            onStart: () => {processing = true},
            onFinish: () => {processing = false},
        })
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

        {#if status}

            <div class="notification is-primary is-light">
            Your password has been successfully reset.
            </div>

        {/if}

        <form on:submit|preventDefault={handleSubmit} class="mx-4">

            <!-- Email Address -->
            <div class="field">

                <label class="label has-text-info has-text-weight-light" for="email">Email</label>

                <div class="control has-icons-left has-icons-right">

                    <input class="input" bind:value={values.email} type="email" placeholder="Enter email" required >

                    <span class="icon is-left">
                        <Icon name="mail" size="{gui.icons.size}" color="{gui.icons.color}"/>
                    </span>

                    {#if errors.email}
                        <p class="help is-danger">{errors.email}</p>
                    {/if}
                </div>
            </div>

            <!-- Password -->
            <div class="field">

                <label class="label has-text-info has-text-weight-light" for="password" >Password</label>

                <div class="control has-icons-left has-icons-right">

                    <input class="input" bind:value={values.password}  type="password" name="password" placeholder="Enter your password" required autocomplete="current-password">

                    <span class="icon is-left">
                        <Icon name="password" size="{gui.icons.size}" color="{gui.icons.color}"/>
                    </span>

                    {#if errors.password}
                        <p class="help is-danger">{errors.password}</p>
                    {/if}
                </div>

            </div>

            <button class="button is-link my-6 is-fullwidth"  disabled={processing}>Login</button>

            <div class="columns">
                <div class="column is-half">
                    <p class="is-size-6 has-text-weight-light my-3">
                        <a href="/forgot-password">Forgot password?</a>
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