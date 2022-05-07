<footer class="footer is-light">

    <div class="tile is-ancestor">

        <article class="tile is-child has-text-centered-mobile">
            <img src="/images/{{config('constants.company.logo')}}" width="28px" alt="{{config('constants.company.logo')}}">

            <p class="has-text-weight-light">{{config('constants.company.name')}}</p>
            <p class="has-text-weight-light has-text-link is-size-7">{{config('constants.company.motto')}}</p>
        </article>

        <article class="tile is-child is-3 has-text-centered my-6 mx-2">

            <div class="column has-text-centered has-text-weight-light">
                {{config('constants.app.title')}}
            </div>

            <div class="column mx-6">
                <img class="mt-3 mt-1-mobile pt-3 " src="/images/{{config('constants.app.app_footer_logo')}}"  alt="{{config('constants.app.app_footer_logo')}}">
            </div>

        </article>

        <article class="tile is-child">
            <p class="has-text-weight-light has-text-right has-text-centered-mobile">{{config('constants.app.copyright')}}</p>
            <p class="has-text-weight-light has-text-right has-text-link is-size-7 has-text-centered-mobile">{{config('constants.app.version')}}</p>
        </article>

    </div>

</footer>
