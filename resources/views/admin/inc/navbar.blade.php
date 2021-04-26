<div>
    <b-navbar toggleable="lg" type="dark" variant="dark">
        <b-navbar-brand href="/admin"><i class="fas fa-hamburger"></i> {{ \Illuminate\Support\Facades\Config::get('constants.APP_NAME') }}</b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                <b-nav-item-dropdown>
                    <!-- Using 'button-content' slot -->
                    <template #button-content>
                        Food
                    </template>
                    <b-dropdown-item href="/admin/food/edit">Edit</b-dropdown-item>
                    <b-dropdown-item href="/admin/food">Create</b-dropdown-item>
                </b-nav-item-dropdown>
                <b-nav-item href="/admin/order">Order</b-nav-item>
                <b-nav-item href="/admin/food_type">Add Food Type</b-nav-item>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">

                <b-nav-item-dropdown right>
                    <!-- Using 'button-content' slot -->
                    <template #button-content>
                        <span class="ml-2"><i class="fas fa-user"></i> {{ "Hi, ".Auth::guard('admin')->user()->name }}</span>
                    </template>
                    <b-dropdown-item href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</div>
