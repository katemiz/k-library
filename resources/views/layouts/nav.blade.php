<nav class="navbar is-light is-transparent">

    <div class="navbar-brand">

      <a  href="/" class="navbar-item has-text-white">
        <img src="{{ asset('/images/app_header_logo.svg') }}" alt="{{ config('constants.app.app_header_logo') }}">
      </a>

      {{-- <a  href="/" class="navbar-item has-text-white"> --}}
    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar_ana">
        <span aria-hidden="true" />
        <span aria-hidden="true" />
        <span aria-hidden="true" />
      </a>

    </div>

    <div id="navbar_ana" class="navbar-menu">

      <div class="navbar-start" id="navstart">

        @if(Auth::check())

           <a href="{{route('dashboard')}}" class="navbar-item">
                <span class="icon">
                    <x-icon icon="home" fill="{{config('constants.icons.color.active')}}"/>
                </span>
            </a>

            <a href="/list-records/asset" class="navbar-item">
                <span class="icon">
                    <x-icon icon="bag" fill="{{config('constants.icons.color.active')}}"/>
                </span>
                <span class="ml-1">My Assets</span>
            </a>

            <a href="/list-records/assetf" class="navbar-item">
                <span class="icon">
                    <x-icon icon="bag-file" fill="{{config('constants.icons.color.active')}}"/>
                </span>
                <span class="ml-1">My Files</span>
            </a>

            <div class="navbar-item has-dropdown is-hoverable">

                <p class="navbar-link" href="/Admin">Add</p>

                <div class="navbar-dropdown">
                    <a href="/assets-form" class="navbar-item">
                        <span class="icon">
                            <x-icon icon="add-asset" fill="{{config('constants.icons.color.active')}}"/>
                        </span>
                        <span class="ml-1">Add Asset</span>
                    </a>

                    <a href="/assets-addfiles" class="navbar-item">
                        <span class="icon">
                            <x-icon icon="add-file" fill="{{config('constants.icons.color.active')}}"/>
                        </span>
                        <span class="ml-1">Add Files</span>
                    </a>
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
