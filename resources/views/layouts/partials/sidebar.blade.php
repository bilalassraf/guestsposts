<style type="text/css">
    .main-sidebar
    {
      position: fixed !important;
    }
    .user-panel img {
      height: 11.5vh !important;
    }
    .user-panel .image {
      padding-left: 0% !important;
    }
  </style>
  <aside class="main-sidebar bg-green elevation-4">
      <h4 class="brand-text font-weight-light" style="text-align: center; margin-top: 10px;">Guest Panel </h4>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center justify-content-center flex-column">
          <div class="image">
            @if(auth()->user()->profile)
              <img src="{{ asset(auth()->user()->profile) }}" class="img-circle rounded-circle" alt="User Image" height="200px" width="200px">
            @else()
              <img src="{{ asset('./images/00000b.png') }}" class="img-circle rounded-circle" alt="User Image" height="200px" width="200px">
            @endif
          </div>
          <div class="info">
            @if(auth()->user()->type == 'Admin')
            <a href="{{ route('user.profile',auth()->user()->id) }}" class="d-block text-white text-center">{{ auth()->user()->name }}</a>
            @else
            <a href="#" class="d-block text-white text-center">{{ auth()->user()->name }}</a>
            @endif
            @if(auth()->user()->type == 'Admin')
            <a href="{{ route('user.profile',auth()->user()->id) }}" class="d-block text-white">{{ auth()->user()->email }} <i class="fa fa-pencil-square-o"></i></a>
            @else
            <a href="{{ route('user.profile',auth()->user()->id) }}" class="d-block text-white">{{ auth()->user()->email }} <i class="fa fa-pencil-square-o"></i></a>
            @endif
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2 pt-2" style="border-top:1px solid #fff;">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            @if(auth()->user()->type == 'Admin')
              <li class="nav-item">
                  <a href="{{route('dashboard')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                  </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.info') }}" class="nav-link text-white {{ (\Request::route()->getName() == 'user.info') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-users"></i>
                  <p>User Info</p>
                </a>
              </li>
              <li class="nav-item @if(Route::currentRouteName()=='admin.show.categories') menu-is-opening menu-open @endif">
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-list-alt text-white"></i>
                  <p class="text-white">Categories<i class="fas fa-angle-left right text-white"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="" class="nav-link text-white" data-toggle="modal" data-target="#addCategory">
                      <i class="far fa-menu nav-icon"></i>
                      <p>Add Category</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('admin.show.categories')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.show.categories') ? 'active' : '' }}">
                      <i class="far fa-menu nav-icon "></i>
                      <p>View Categories</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item @if(Route::currentRouteName()=='admin.add.casino.request' || Route::currentRouteName()=='admin.show.casino.request' ||Route::currentRouteName()=='admin.casino.deleted.requests') menu-is-opening menu-open @endif">
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-television text-white"></i>
                  <p class="text-white">Casino Post<i class="fas fa-angle-left right text-white"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  
                    <li class="nav-item active">
                      <a href="{{ route('admin.add.casino.request') }}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.add.casino.request') ? 'active' : '' }}">
                        <i class="far fa-menu nav-icon"></i>
                        <p >Add Websites</p>
                      </a>
                    </li>
        
                    <li class="nav-item">
                      <a href="{{ route('admin.show.casino.request') }}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.show.casino.request') ? 'active' : '' }}">
                        <i class="far fa-menu nav-icon "></i>
                        <p >View Websites</p>
                      </a>
                    </li>
                 
                    <li class="nav-item">
                      <a href="{{route('admin.casino.deleted.requests')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.guest.deleted.requests') ? 'active' : '' }}">
                        <i class="far fa-menu nav-icon "></i>
                        <p >Deleted Websites</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="{{route('admin.casino.spam.requests')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.guest.deleted.requests') ? 'active' : '' }}">
                        <i class="far fa-menu nav-icon "></i>
                        <p >Spam Websites</p>
                      </a>
                    </li>
                 
                </ul>
              </li>
              <li class="nav-item @if(Route::currentRouteName()=='admin.add.guest.request' || Route::currentRouteName()=='admin.show.guest.request' ||Route::currentRouteName()=='admin.guest.deleted.requests') menu-is-opening menu-open @endif">
                <a href="#" class="nav-link text-white">
                  <i class="nav-icon fa fa-television text-white"></i>
                  <p>Guest Post<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item active">
                    <a href="{{ route('admin.add.guest.request') }}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.add.guest.request') ? 'active' : '' }}">
                      <i class="far fa-menu nav-icon"></i>
                      <p>Add Websites</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('admin.show.guest.request')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.show.guest.request') ? 'active' : '' }}">
                      <i class="far fa-menu nav-icon"></i>
                      <p>View Websites</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('admin.guest.deleted.requests')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.guest.deleted.requests') ? 'active' : '' }}">
                      <i class="far fa-menu nav-icon"></i>
                      <p>Deleted Websites</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('admin.guest.spam.requests')}}" class="nav-link text-white">
                      <i class="far fa-menu nav-icon "></i>
                      <p >Spam Websites</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item @if(Route::currentRouteName()=='admin.add.niche' || Route::currentRouteName()=='admin.show.niches' ||Route::currentRouteName()=='admin.show.deleted.niche') menu-is-opening menu-open @endif">
                <a href="#" class="nav-link">
                  <i class="nav-icon fa fa-list-alt text-white"></i>
                  <p class="text-white"> Niche Edits <i class="fas fa-angle-left right text-white"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item active">
                    <a href="{{ route('admin.add.niche') }}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.add.niche') ? 'active' : '' }}">
                      <i class="far fa-menu nav-icon"></i>
                      <p>Add Website</p>
                    </a>
                  </li>
                  <li class="nav-item active">
                    <a href="{{route('admin.show.niches')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.show.niches') ? 'active' : '' }}">
                      <i class="far fa-menu nav-icon"></i>
                      <p>View Websites</p>
                    </a>
                  </li>
                  <li class="nav-item active">
                    <a href="{{route('admin.show.deleted.niche')}}" class="nav-link text-white{{ (\Request::route()->getName() == 'admin.show.deleted.niche') ? 'active' : '' }}">
                      <i class="far fa-menu nav-icon "></i>
                      <p>Deleted Websites</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('admin.niche.spam.requests')}}" class="nav-link text-white">
                      <i class="far fa-menu nav-icon "></i>
                      <p >Spam Websites</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endif
            @if(auth()->user()->type == 'User' || auth()->user()->type == 'Outreach Coordinator' || auth()->user()->type == 'Moderator')
              <li class="nav-item active">
                <a href="{{route('dashboard')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'dashboard') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              {{-- <li class="nav-item active">
                  <a href="{{route('user.requests')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'user.requests') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-list-alt"></i>
                    <p>Requests</p>
                  </a>
              </li> --}}
              {{-- permission part --}}
              @if(auth()->user()->user_info == 'on')
                  <li class="nav-item active">
                    <a href="{{ route('user.info') }}" class="nav-link text-white {{ (\Request::route()->getName() == 'user.info') ? 'active' : '' }}">
                      <i class="nav-icon fas fa-users"></i>
                        <p>User Info </p>
                    </a>
                  </li>
              @endif
              @if(auth()->user()->add_category == 'on' || auth()->user()->view_all_categories == 'on')
                <li class="nav-item active @if(\Request::route()->getName()=='admin.show.categories') menu-is-opening menu-open @endif">
                  <a href="#" class="nav-link text-white ">
                    <i class="nav-icon fa fa-list-alt"></i>
                    <p>Categories <i class="fas fa-angle-left right"></i></p>
                  </a>
                  <ul class="nav nav-treeview">
                    @if(auth()->user()->add_category == 'on')
                      <li class="nav-item">
                        <a href="" class="nav-link" data-toggle="modal" data-target="#addCategory">
                          <i class="far fa-menu nav-icon text-white"></i>
                          <p class="text-white">Add Category</p>
                        </a>
                      </li>
                    @endif
                    @if(auth()->user()->view_all_categories == 'on')
                      <li class="nav-item active">
                        <a href="{{route('admin.show.categories')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.show.categories') ? 'active' : '' }}">
                          <i class="far fa-menu nav-icon "></i>
                          <p >view Categories</p>
                        </a>
                      </li>
                    @endif
                  </ul>
                </li>
              @endif
              @if(auth()->user()->add_casino_post == 'on' || auth()->user()->view_all_casino_post == 'on' || auth()->user()->view_deleted_casino_post == 'on' )
                <li class="nav-item @if(Route::currentRouteName()=='admin.add.casino.request' || Route::currentRouteName()=='admin.show.casino.request' ||Route::currentRouteName()=='admin.casino.deleted.requests') menu-is-opening menu-open @endif">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-television text-white"></i>
                    <p class="text-white">Casino Post<i class="fas fa-angle-left right text-white"></i></p>
                  </a>
                  <ul class="nav nav-treeview">
                    @if(auth()->user()->add_casino_post == 'on')
                      <li class="nav-item active">
                        <a href="{{ route('admin.add.casino.request') }}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.add.casino.request') ? 'active' : '' }}">
                          <i class="far fa-menu nav-icon"></i>
                          <p >Add Websites</p>
                        </a>
                      </li>
                    @endif
                    @if(auth()->user()->view_all_casino_post == 'on')
                      <li class="nav-item">
                        <a href="{{ route('admin.show.casino.request') }}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.show.casino.request') ? 'active' : '' }}">
                          <i class="far fa-menu nav-icon "></i>
                          <p >View Websites</p>
                        </a>
                      </li>
                    @endif
                    @if(auth()->user()->view_deleted_casino_post == 'on')
                      <li class="nav-item">
                        <a href="{{route('admin.casino.deleted.requests')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.guest.deleted.requests') ? 'active' : '' }}">
                          <i class="far fa-menu nav-icon "></i>
                          <p >Deleted Websites</p>
                        </a>
                      </li>
                    @endif
                  </ul>
                </li>
              @endif
              @if(auth()->user()->add_guest_post == 'on' || auth()->user()->view_all_guest_post == 'on' || auth()->user()->view_deleted_guest_post == 'on' )
                <li class="nav-item @if(Route::currentRouteName()=='admin.add.guest.request' || Route::currentRouteName()=='admin.show.guest.request' ||Route::currentRouteName()=='admin.guest.deleted.requests') menu-is-opening menu-open @endif">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-television text-white"></i>
                    <p class="text-white">Guest Post<i class="fas fa-angle-left right text-white"></i></p>
                  </a>
                  <ul class="nav nav-treeview">
                    @if(auth()->user()->add_guest_post == 'on')
                      <li class="nav-item active">
                        <a href="{{ route('admin.add.guest.request') }}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.add.guest.request') ? 'active' : '' }}">
                          <i class="far fa-menu nav-icon"></i>
                          <p >Add Websites</p>
                        </a>
                      </li>
                    @endif
                    @if(auth()->user()->view_all_guest_post == 'on')
                      <li class="nav-item">
                        <a href="{{ route('admin.show.guest.request') }}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.show.guest.request') ? 'active' : '' }}">
                          <i class="far fa-menu nav-icon "></i>
                          <p >View Websites</p>
                        </a>
                      </li>
                    @endif
                    @if(auth()->user()->view_deleted_guest_post == 'on')
                      <li class="nav-item">
                        <a href="{{route('admin.guest.deleted.requests')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.guest.deleted.requests') ? 'active' : '' }}">
                          <i class="far fa-menu nav-icon "></i>
                          <p >Deleted Websites</p>
                        </a>
                      </li>
                    @endif
                  </ul>
                </li>
              @endif
              @if(auth()->user()->add_niche == 'on' |auth()->user()->view_niches == 'on'| auth()->user()->deleted_niches == 'on')
                <li class="nav-item @if(Route::currentRouteName()=='admin.add.niche' || Route::currentRouteName()=='admin.show.niches' ||Route::currentRouteName()=='admin.show.deleted.niche') menu-is-opening menu-open @endif">
                  <a href="" class="nav-link ">
                    <i class="nav-icon fa fa-television text-white"></i>
                    <p class="text-white">
                      Niche Edits
                      <i class="fas fa-angle-left right text-white"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    @if(auth()->user()->add_niche == 'on' )
                      <li class="nav-item active">
                        <a href="{{ route('admin.add.niche') }}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.add.niche') ? 'active' : '' }}">
                          <i class="far fa-menu nav-icon "></i>
                          <p >Add Website</p>
                        </a>
                      </li>
                    @endif
                    @if(auth()->user()->view_niches == 'on')
                      <li class="nav-item">
                        <a href="{{route('admin.show.niches')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.show.niches') ? 'active' : '' }}">
                          <i class="far fa-menu nav-icon "></i>
                          <p >View Websites</p>
                        </a>
                      </li>
                    @endif
                    @if(auth()->user()->deleted_niches == 'on')
                      <li class="nav-item">
                        <a href="{{route('admin.show.deleted.niche')}}" class="nav-link text-white {{ (\Request::route()->getName() == 'admin.show.deleted.niche') ? 'active' : '' }}">
                          <i class="far fa-menu nav-icon "></i>
                          <p >Deleted Websites</p>
                        </a>
                      </li>
                    @endif
                  </ul>

                </li>
                @endif
                @endif
                <li class="nav-item">
                  <a href="{{ route('user.profile',auth()->user()->id) }}" class="nav-link text-white {{ (\Request::route()->getName() == 'user.profile') ? 'active' : '' }}">
                    <i class="nav-icon fa fa-user"></i>
                    <p>View Profile</p>
                  </a>
                </li>
                <li class="nav-item active" style="list-style:none;">
                  <a href="{{ route('logout') }}" class="nav-link text-white">
                      <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>Logout</p>
                  </a>
                </li>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    @include('modals.category')
