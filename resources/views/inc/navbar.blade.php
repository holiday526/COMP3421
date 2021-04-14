<!-- Navigation -->
<div>
    <b-navbar toggleable="lg" type="dark" variant="info">
        <b-navbar-brand href="/"><i class="fas fa-hamburger"></i> {{ \Illuminate\Support\Facades\Config::get('constants.APP_NAME') }}</b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                <b-nav-item href="/food_menu" class="mx-2"><i class="fas fa-utensils mr-1"></i> Menu</b-nav-item>
                <b-nav-form>
                    <b-input-group class="mx-2">
                        <b-form-input placeholder="Search food..."></b-form-input>
                        <b-input-group-append>
                            <b-button variant="outline-light"><i class="fas fa-search"></i></b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-nav-form>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">
                @auth
                <b-nav-item href="#"><i class="fas fa-shopping-cart"></i> Cart</b-nav-item>
                <b-nav-item-dropdown right>
                    <template #button-content>
                        <span class="ml-2"><i class="fas fa-user"></i> {{ "Hi, ".Auth::user()->name }}</span>
                    </template>
                    <b-dropdown-item href="#"><i class="fas fa-id-badge mr-1"></i> Profile</b-dropdown-item>
                    <b-dropdown-item href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </b-dropdown-item>
                </b-nav-item-dropdown>
                @else
                <b-nav-item-dropdown right>
                    <template #button-content>
                        <em class="ml-2"><i class="fas fa-user"></i></em>
                    </template>
                    <b-dropdown-item href="/login"><i class="fas fa-sign-in-alt mr-1"></i> Login</b-dropdown-item>
                    <b-dropdown-item href="/register"><i class="fas fa-user-plus"></i> Register</b-dropdown-item>
                </b-nav-item-dropdown>
                @endauth
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</div>
