<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo mb-4 ">
            <a href="{{route('dashboard')}}" class="app-brand-link">
              <span class="app-brand-logo demo ">
                 <img src="{{asset('assets/img/avatars/km-new-logo.png')}}" width="150" />
              </span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
 

           <!-- Page -->
            <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle" ></i>
                  <div data-i18n="Dashboard"> Dashboard</div>
                </a>
            </li>
           @canany(['create-music', 'edit-music', 'delete-music'])
             @if(!Auth::user()->hasRole('Super Admin'))
              <!-- <li class="menu-item {{ request()->routeIs('musics.*') ? 'active' : '' }}">
                <a href="{{ route('musics.index') }}" class="menu-link">
                <i class="fa-solid fa-music menu-icon tf-icons"></i>
                  <div data-i18n="Catalog"> Catalog</div>
                </a>
              </li> -->
              <li class="menu-item {{ request()->routeIs('releases.*') ? 'active' : '' }}">
                <a  href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-music menu-icon tf-icons"></i>
                  <div data-i18n="Manage Release"> Manage Release</div>
                </a>
                <ul class="menu-sub">
                <li class="menu-item   {{ request()->routeIs('releases.index') ? 'active' : '' }}">
                  <a href="{{ route('releases.index') }}"  class="menu-link">
                    <div data-i18n="List">List</div>
                  </a>
                </li>
             
                <li class="menu-item  {{ request()->routeIs('releases.step1') ? 'active' : '' }}">
                  <a href="{{ route('releases.step1') }}" class="menu-link">
                    <div data-i18n="Add">Add</div>
                  </a>
                </li>
              </ul>
              </li>
             @endif
          
            @endcanany

            @canany(['create-user', 'edit-user', 'delete-user'])
            <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
              <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Manage User">Manage User</div>
              </a>
            </li>
            @endcanany
          
            @canany(['create-role', 'edit-role', 'delete-role'])
            <li class="menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
              <a href="{{ route('roles.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Manage Roles">Manage Roles</div>
              </a>
            </li>
            @endcanany

            <li class="menu-item">
                <a href="#" class="menu-link">
                <i class="fa-solid fa-headphones menu-icon tf-icons"></i>
                  <div data-i18n=" Manage Genere"> Manage Genere</div>
                </a>
              </li>

            <li class="menu-item ">
                <a href="#" class="menu-link">

                <i class="fa-solid   fa-line-chart menu-icon tf-icons"></i>
                  <div data-i18n="Analytics"> Analytics</div>
                </a>
              </li>

              <li class="menu-item ">
                <a href="#" class="menu-link">
                <i class="fa-solid fa-bullhorn menu-icon tf-icons"></i>
                  <div data-i18n="Promotion"> Promotion</div>
                </a>
              </li>

              <li class="menu-item ">
                <a href="#" class="menu-link">
                <i class="fa-solid fa-dollar menu-icon tf-icons"></i>
                  <div data-i18n="Finential"> Finential</div>
                </a>
              </li>
       
          </ul>
  </aside>

