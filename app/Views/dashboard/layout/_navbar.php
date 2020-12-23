<nav class="navbar is-fixed-top is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" onclick="sidenav()">
            <i class="fas fa-archive"></i>
        </a>
        <a class="navbar-item" href="/">
            Mining Company
        </a>
        
        <a role="button" class="navbar-burger burger" data-target="navbarBasicExample">
            <i class="fa fa-user-circle" style="width: 40%; height: 40%; margin: 30%"></i>
        </a>
    </div>
    
    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-end">
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <i class="fa fa-user-circle mx-2"></i>
                    <?= user()->username ?>
                </a>

                <div class="navbar-dropdown">
                    <a class="navbar-item" href="/control/profile">
                        Profile
                    </a>
                    <a class="navbar-item" href="/logout">
                        Logout
                    </a>
                </div>
            </div>
        </div>
      </div>
</nav>