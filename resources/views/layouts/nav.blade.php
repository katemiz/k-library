<nav class="navbar is-light is-transparent">

    <div class="navbar-brand">

      <a  href="/" class="navbar-item has-text-white">
        <img src="{{ asset('/images/app_header_logo.svg') }}" alt="{{ config('constants.app.app_header_logo') }}">
      </a>

      <a  href="/" class="navbar-item has-text-white">
        <span aria-hidden="true" />
        <span aria-hidden="true" />
        <span aria-hidden="true" />
      </a>

    </div>

    <div id="navbar_ana" class="navbar-menu">

      <div class="navbar-start" id="navstart">

        @if(Auth::check())

            <a href="{{route('myassets')}}" class="navbar-item">
                <span class="icon">
                    <x-icon icon="home" fill="{{config('constants.icons.color.active')}}"/>
                </span>
            </a>


            <a href="/assets-form" class="navbar-item">
                <span class="icon">
                    <x-icon icon="add-asset" fill="{{config('constants.icons.color.active')}}"/>
                </span>
                <span class="ml-1">Add</span>
            </a>



          <div class="navbar-item has-dropdown is-hoverable">

            <p class="navbar-link" href="/Admin">Admin</p>

            <div class="navbar-dropdown">

              <a  href="/simpleitem/project" class="navbar-item">Settings</a>

              <hr class="navbar-divider" />

              <a  href="/bcategory" class="navbar-item">
                Business Categories
              </a>
              <a  href="/" class="navbar-item">Training Categories</a>
              <a  href="/simpleitem/profession" class="navbar-item">
                Professions
              </a>
              <a  href="/simpleitem/diploma" class="navbar-item">Diploma</a>
              <a  href="/simpleitem/language" class="navbar-item">
                Language
              </a>

              <hr class="navbar-divider" />

              <a  href="/slevels" class="navbar-item">Skill Levels</a>

            </div>

          </div>


          @endif

      </div>

      <div class="navbar-end">

        <div class="navbar-item">
          <div class="buttons">

              @if(Auth::check())

                {{-- //HERE IS WHAT WILL APPEAR IF THE USER IS LOGGED IN --}}
                <div class="navbar-item has-dropdown is-hoverable">
                    <p class="navbar-link">
                        <x-icon icon="user" fill="{{config('constants.icons.color.active')}}"/>
                        &nbsp;{{ Auth::user()->name }}
                    </p>

                    <div class="navbar-dropdown">

                      {{-- <p class="navbar-item">{{ Auth::user()->lastname }}</p> --}}

                      <a  href="/projects" class="navbar-item">Settings</a>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a :href="route('logout')" class="navbar-item"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                        </a>
                        </form>

                    </div>
                  </div>
              @else
                {{-- //HERE IS WHAT WILL APPEAR IF THE USER IS NOT LOGGED IN --}}
                <a href="{{route('login')}}" class="navbar-item">
                    <span class="icon">
                        <x-icon icon="user" fill="{{config('constants.icons.color.active')}}"/>
                    </span>
                    <span class="ml-1">Login</span>
                </a>

              @endif

          </div>
        </div>

      </div>

    </div>

  </nav>
