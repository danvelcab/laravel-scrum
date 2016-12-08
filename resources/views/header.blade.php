<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="index.html"><span>SCRUM</span></a>

            <!-- start: Header Menu -->
            <div class="nav-no-collapse header-nav">
                <ul class="nav pull-right">
                    <li class="dropdown hidden-phone">
                        <a class="btn dropdown-toggle" href="{{URL::asset('productBacklogs/0')}}">
                            Product Backlog
                        </a>
                    </li>
                    <li class="dropdown hidden-phone">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Sprint
                        </a>
                        <ul class="dropdown-menu tasks">
                            <li class="dropdown" style="background: #1C2B36">
                                <a class="btn dropdown-toggle" href="{{URL::asset('sprintBacklogs/0')}}">
                                    Sprint Backlog
                                </a>
                            </li>
                            <li class="dropdown" style="background: #1C2B36">
                                <a class="btn dropdown-toggle" href="{{URL::asset('mySprintBacklogs/0')}}">
                                    <p>Mi Sprint Backlog</p>
                                </a>
                            </li>
                            <li class="dropdown" style="background: #1C2B36">
                                <a class="btn dropdown-toggle" href="{{URL::asset('sprintBacklogs/burndown/0')}}">
                                    Burndown
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown hidden-phone">
                        <a class="btn dropdown-toggle" href="{{URL::asset('changes')}}">
                            Historial de cambios
                        </a>
                    </li>
                    <!-- start: User Dropdown -->
                    <li class="dropdown">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="halflings-icon white user"></i> {{Auth::user()->username}}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{URL::asset('logout')}}">Logout</a></li>
                        </ul>
                    </li>
                    <!-- end: User Dropdown -->
                </ul>
            </div>
            <!-- end: Header Menu -->

        </div>
    </div>
</div>

