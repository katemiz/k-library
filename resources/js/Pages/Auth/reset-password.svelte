<script>
    import {params,gui} from '@/config/config.js'
    import { useForm } from '@inertiajs/inertia-svelte'
    import Icon from '@/Pages/Shared/Icon.svelte'

    export let errors = {}
    export let request

    let urlpath = window.location.pathname.split('/')
    let token = urlpath[urlpath.length-1]

    let values = {
        password:null,
        password_confirmation:null,
    }

    let form = useForm({
        email:request.email,
        password:null,
        password_confirmation:null,
        token:token
    })

    let submit = () => {
        $form.post('/reset-password',values)
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
        <nav class="breadcrumb has-dot-separator" aria-label="breadcrumbs">
            <ul>
                <li id="tr">
                    <a href="xx" aria-current="page">TR</a>
                </li>
                <li id="en">
                    <a href="xx" aria-current="page">EN</a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="column is-half is-offset-one-quarter has-background-white">

        <div class="column is-offset-3 is-offset-4-mobile is-6 is-4-mobile my-6">
            <figure class="image"><img src="/images/{params.app.app_header_logo}" alt="deneme"></figure>
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


            <!-- Password Reset Token -->
            <input type="hidden" name="token" bind:value="{$form.token}">


            <!-- Password -->
            <div class="field">

                <label class="label has-text-weight-light" for="password">Password</label>

                <div class="control has-icons-left has-icons-right">

                    <input class="input" bind:value={$form.password} type="password" name="password" placeholder="Enter your password" autocomplete="current-password">

                    <span class="icon is-left">
                        <Icon name="password" size="{gui.icons.size}" color="{gui.icons.color}"/>
                    </span>

                    {#if errors.password}
                        <p class="help is-danger">{errors.password}</p>
                    {/if}
                </div>

            </div>

            <!-- Confirmation Password -->
            <div class="field">

                <label class="label has-text-weight-light" for="password_confirmation">Confirm Password</label>

                <div class="control has-icons-left has-icons-right">

                    <input class="input" bind:value={$form.password_confirmation}  type="password" name="password_confirmation" placeholder="Enter your password (again)" autocomplete="current-password">

                    <span class="icon is-left">
                        <Icon name="password" size="{gui.icons.size}" color="{gui.icons.color}"/>
                    </span>

                    {#if errors.password_confirmation}
                        <p class="help is-danger">{errors.password}</p>
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


    <div class="column is-half is-offset-one-quarter">

        <div class="columns is-vcentered">

            <div class="column">
                <img src="/images/{params.company.logo}" alt="Intro" width="24px">
            </div>

            <div class="column has-text-right">{params.company.name}</div>

        </div>

    </div>

</section>