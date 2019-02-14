<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
            <router-link to="{!! ('/dashboard') !!}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt text-teal"></i>
              <p>Dashboard</p>
            </router-link>
          </li>
          
           <!-- Student -------------------->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-user"></i>
              <p> Students
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-3">
                <router-link to="/students" class="nav-link">
                  <p>All Students</p>
                </router-link>
              </li>
            </ul>
          </li>
          <!-- Subject -------------------->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-bookmark"></i>
              <p> Subject
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-3">
                <router-link to="/subjects" class="nav-link">
                  <p>All Subjects</p>
                </router-link>
              </li>
            </ul>
          </li>

           <!-- Departments -------------------->
          <li class="nav-item has-treeview">
            <router-link to="#" class="nav-link">
              <i class="fas fa-dollar-sign"></i>
              <p> Departments
                <i class="right fa fa-angle-left"></i>
              </p>
            </router-link>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-3">
                <router-link to="/departments" class="nav-link">
                  <p>All Departments</p>
                </router-link>
              </li>
            </ul>
          </li>

          <!-- Library -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-book-reader"></i>
              <p> Library
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <p>All Library Assets</p>
                </a>
                <a href="#" class="nav-link">
                  <p>Add Library Asset</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Fees -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-dollar-sign"></i>
              <p> Fees
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <p>Fees Collection</p>
                </a>
                <a href="#" class="nav-link">
                  <p>Add Fee Payment</p>
                </a>
              </li>
            </ul>
          </li>
          
          <!-- Profile -->
          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
              <i class="fas fa-user nav-icon"></i>
              <p>Profile</p>
            </router-link>
          </li>

          <!-- QA -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-ribbon"></i>
              <p> Quality Assurance
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <p>Students Attendance</p>
                </a>
                <a href="#" class="nav-link">
                  <p>Add Attendance</p>
                </a>
              </li>
            </ul>
          </li>

         <!-- Management Treeview -->
          <li class="nav-item has-treeview menu-open">
            <router-link to="/dashboard" class="nav-link">
            <i class="fa fa-th nav-icon text-orange"></i>
              <p>
                Management
                <i class="right fa fa-angle-left text-orange"></i>
              </p>
            </router-link>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-3">
                <router-link to="{!! ('/users') !!}" class="nav-link">
                  <p>
                  <i class="fas fa-users"></i>
                    Users
                  </p>
                </router-link>
              </li>
             
            </ul>
          </li> 
          <!-- logout processing -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
              <i class="fas fa-power-off nav-icon text-red"></i>
              <p>
                {{ __('Logout') }}
              </p>
            </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
          </li>
        </ul>