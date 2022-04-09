<script>

    import {params} from '@/config/config.js'

    import { page, Link } from '@inertiajs/inertia-svelte'
    import Icon from '@/Pages/Shared/Icon.svelte'

    let iconColor = 'link'
    let iconSize = 'S'

    let user = false

    if ($page.props.auth) {

        user = $page.props.auth.user
    }

    console.log($page.props)

</script>

<nav class="navbar is-light is-transparent">

    <div class="navbar-brand">

        <Link href="/" class="navbar-item has-text-white">
            <img src="/images/{params.app.app_header_logo}" alt="Skill Management Logo" width="112" height="28" >        
        </Link>

        <Link href="/" class="navbar-item has-text-white">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>      
        </Link>

    </div>

    <div id="navbar_ana" class="navbar-menu">

        <div class="navbar-start" id="navstart">

            {#if user }

            <Link class="navbar-item" href="/"><Icon name="home" size="{iconSize}" color="{iconColor}"/></Link>
            <Link class="navbar-item" href="/roles"><Icon name="role" size="{iconSize}" color="{iconColor}"/>&nbsp;Roles</Link>
            <Link class="navbar-item" href="/skills"><Icon name="skill" size="{iconSize}" color="{iconColor}"/>&nbsp;Skills</Link>
            <Link class="navbar-item" href="/"><Icon name="training" size="{iconSize}" color="{iconColor}"/>&nbsp;Trainings</Link>
            <Link class="navbar-item" href="/"><Icon name="measurement" size="{iconSize}" color="{iconColor}"/>&nbsp;measurement</Link>

            <div class="navbar-item has-dropdown is-hoverable">

                <p class="navbar-link" href="/Admin">Admin</p>

                <div class="navbar-dropdown">

                    <Link href="/simpleitem/project" class="navbar-item">Projects</Link>

                    <hr class="navbar-divider">

                    <Link href="/bcategory" class="navbar-item">Business Categories</Link>
                    <Link href="/" class="navbar-item">Training Categories</Link>
                    <Link href="/simpleitem/profession" class="navbar-item">Professions</Link>
                    <Link href="/simpleitem/diploma" class="navbar-item">Diploma</Link>
                    <Link href="/simpleitem/language" class="navbar-item">Language</Link>

                    <hr class="navbar-divider">

                    <Link href="/slevels" class="navbar-item">Skill Levels</Link>

                </div>

            </div>

            <div class="navbar-item has-dropdown is-hoverable">

                <p class="navbar-link" href="/Admin">About Us</p>
                <div class="navbar-dropdown">

                    <Link href="/aboutus" class="navbar-item">Who are we?</Link>
                    <Link href="/services" class="navbar-item">Services we provide</Link>
                </div>
            </div>

            {:else}
                <Link class="navbar-item" href="/aboutus"><Icon name="people" size="{iconSize}" color="{iconColor}"/>&nbsp;Who Are We?</Link>
                <Link class="navbar-item" href="/services"><Icon name="service" size="{iconSize}" color="{iconColor}"/>&nbsp;Services</Link>
            {/if}

        </div>


        <div class="navbar-end" >

            <div class="navbar-item">
                <div class="buttons">

                {#if user}

                    <div class="navbar-item has-dropdown is-hoverable">
                        <p class="navbar-link">
                            <Icon name="user" size="{iconSize}" color="{iconColor}"/>&nbsp;{user.lastname.toUpperCase()}
                        </p>
                
                        <div class="navbar-dropdown">

                            <p class="navbar-item">{user.name} {user.lastname}</p>

                            <Link href="/projects" class="navbar-item">Projects</Link>
                            <Link href="/logout" class="navbar-item" method="post">Logout</Link>

                        </div>
                    </div>

                {:else}

                    <Link href="/login" class="button is-ghost" as="button" preserveScroll>
                        <Icon name="user" size="{iconSize}" color="{iconColor}"/>&nbsp;Login
                    </Link>

                    <Link href="/register" class="button is-ghost" as="button" preserveScroll>
                        <Icon name="register" size="{iconSize}" color="{iconColor}"/>&nbsp;Register
                    </Link>

                {/if}

                </div>
            </div>

        </div>

    </div>

</nav>