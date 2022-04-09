<script>

    import {params,gui} from '@/config/config.js'
    import { Inertia } from '@inertiajs/inertia'
    import Icon from '@/Pages/Shared/Icon.svelte'

    export let errors = {}

    let processing = false

    let values = {
        name:null,
        lastname:null,
        email:null,
        password:null,
        password_confirmation:null
    }

    function handleSubmit() {
        Inertia.post('/register', values,{
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
            <figure class="image"><img src="/images/{params.app.app_header_logo}" alt="app_header_logo"></figure>
        </div>

        <form on:submit|preventDefault={handleSubmit} class="mx-4">

            <div class="columns">

                <div class="column is-half">

                    <!-- Name -->
                    <div class="field">

                        <label class="label has-text-weight-light" for="name">Name</label>

                        <div class="control has-icons-left has-icons-right">

                            <input class="input" bind:value={values.name} type="text" placeholder="Enter your name">

                            <span class="icon is-left">
                                <Icon name="user" size="{gui.icons.size}" color="{gui.icons.color}"/>
                            </span>

                            {#if errors.name}
                                <p class="help is-danger">{errors.name}</p>
                            {/if}
                        </div>
                    </div>

                </div>

                <div class="column">

                    <!-- Lastname -->
                    <div class="field">

                        <label class="label has-text-weight-light" for="lastname">Lastname</label>

                        <div class="control has-icons-left has-icons-right">

                            <input class="input" bind:value={values.lastname} type="text" placeholder="Enter your lastname">

                            <span class="icon is-left">
                                <Icon name="user" size="{gui.icons.size}" color="{gui.icons.color}"/>
                            </span>

                            {#if errors.lastname}
                                <p class="help is-danger">{errors.lastname}</p>
                            {/if}
                        </div>
                    </div>

                </div>
            </div>


            <!-- Email Address -->
            <div class="field">

                <label class="label has-text-weight-light" for="email">Email</label>

                <div class="control has-icons-left has-icons-right">

                    <input class="input" bind:value={values.email} type="email" placeholder="Enter email">

                    <span class="icon is-left">
                        <Icon name="mail" size="{gui.icons.size}" color="{gui.icons.color}"/>
                    </span>

                    {#if errors.email}
                        <p class="help is-danger">{errors.email}</p>
                    {/if}
                </div>
            </div>


            <div class="columns">

                <div class="column is-half">
                    <!-- Password -->
                    <div class="field">

                        <label class="label has-text-weight-light" for="password">Password</label>

                        <div class="control has-icons-left has-icons-right">

                            <input class="input" bind:value={values.password} type="password" name="password" placeholder="Enter your password" autocomplete="current-password">

                            <span class="icon is-left">
                                <Icon name="password" size="{gui.icons.size}" color="{gui.icons.color}"/>
                            </span>

                            {#if errors.password}
                                <p class="help is-danger">{errors.password}</p>
                            {/if}
                        </div>

                    </div>
                </div>

                <div class="column">
                    <!-- Confirmation Password -->
                    <div class="field">

                        <label class="label has-text-weight-light" for="password">Confirm Password</label>

                        <div class="control has-icons-left has-icons-right">

                            <input class="input" bind:value={values.password_confirmation}  type="password" name="password_confirmation" placeholder="Enter your password (again)" autocomplete="current-password">

                            <span class="icon is-left">
                                <Icon name="password" size="{gui.icons.size}" color="{gui.icons.color}"/>
                            </span>

                            {#if errors.password}
                                <p class="help is-danger">{errors.password}</p>
                            {/if}
                        </div>

                    </div>
                </div>

            </div>


            <button class="button is-primary my-6 is-fullwidth" disabled={processing}>Register</button>

            <div class="columns">
                <div class="column is-half">
                    <p class="is-size-6 has-text-weight-light my-3">
                        <a href="/forgot-password">Forgot password?</a>
                    </p>
                </div>

                <div class="column">
                    <p class="has-text-right is-size-6 has-text-weight-light my-3">
                        <a href="/login">Login</a>
                    </p>
                </div>
            </div>

        </form>

    </div>


    <div class="column is-half is-offset-one-quarter has-text-right">
        <a href="{params.company.link}">{params.company.name}</a>
    </div>

</section>