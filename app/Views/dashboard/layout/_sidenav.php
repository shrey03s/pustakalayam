<div id="mainSidenav" class="sidenav">
    <aside class="menu">
        <p class="menu-label mx-2 has-text-light">
            General
        </p>
        <ul class="menu-list">
            <li><a id="sidenav-dashboard-stats" href="/"><i class="fas fa-th-large"></i><span class="px-2">Dashboard</span></a></li>
        </ul>
        <!--ul class="menu-list">
            <details id="sidenav-sub-report">
                <summary class="no-select">Report</summary>
                <ul>
                    <li><a id="sidenav-money-stats" href="/control/moneystat"><i class="fas fa-money-bill-wave"></i><span class="px-2">Money</a></li>
                    <li><a id="sidenav-mining-stats" href="/control/miningstat"><i class="fas fa-hammer"></i><span class="px-2">Mining</a></li>
                    <li><a id="sidenav-coal-stats" href="/control/coalstat"><i class="fas fa-shopping-bag"></i><span class="px-2">Coal Utility</a></li>
                    <li><a id="sidenav-depot-stats" href="/control/depotstat"><i class="fas fa-box"></i><span class="px-2">Depot</a></li>
                </ul>
            </details>
        </ul-->
        <ul class="menu-list">
            <details id="sidenav-sub-books">
                <summary class="no-select">Books</summary>
                <ul>
                    <li><a id="sidenav-books" href="/control/books"><i class="fas fa-stream"></i><span class="px-2">Books</a></li>
                    <li><a href="/control/books/create"><i class="fas fa-plus"></i><span class="px-2">Add Book</a></li>
                </ul>
            </details>
        </ul>
        <ul class="menu-list">
            <details id="sidenav-sub-issue">
                <summary class="no-select">Book Issuing</summary>
                <ul>
                    <li><a id="sidenav-issue" href="/control/issue"><i class="fas fa-book"></i><span class="px-2">Issuing Record</a></li>
                    <li><a href="/control/issue/create"><i class="fas fa-plus"></i><span class="px-2">Create Issue Record</a></li>
                </ul>
            </details>
        </ul>
        <ul class="menu-list">
            <details id="sidenav-sub-members">
                <summary class="no-select">Members</summary>
                <ul>
                    <li><a id="sidenav-members" href="/control/members"><i class="fa fa-user"></i><span class="px-2">Members</span></a></li>
                    <li><a href="/control/members/create"><i class="fa fa-plus"></i><span class="px-2">Add Members</span></a></li>
                    <li><a id="sidenav-membership" href="/control/membership"><i class="fa fa-address-card"></i><span class="px-2">Membership Record</span></a></li>
                </ul>
            </details>
        </ul>
        <ul class="menu-list">
            <details id="sidenav-sub-visitors">
                <summary class="no-select">Visitors</summary>
                <ul>
                    <li><a id="sidenav-visitors" href="/control/visitors"><i class="fa fa-user"></i><span class="px-2">Visitors</span></a></li>
                    <li><a href="/control/visitors/create"><i class="fa fa-plus"></i><span class="px-2">Add Visitors</span></a></li>
                </ul>
            </details>
        </ul>
        <?php if(has_permission('app.delete.entry')) { ?>
        <p class="menu-label  mx-2 has-text-light">
            Administration
        </p>
        <ul class="menu-list">
            <details id="sidenav-sub-accounts">
                <summary class="no-select">Staffs</summary>
                <ul>
                    <li><a id="sidenav-accounts" href="/control/accounts"><i class="fa fa-user-circle"></i><span class="px-2">Staffs</span></a></li>
                    <li><a href="/control/accounts/create"><i class="fa fa-plus"></i><span class="px-2">Add Staff</span></a></li>
                </ul>
            </details>
        </ul>
        <?php } ?>
        <p class="menu-label mx-2 has-text-light">
            Personal
        </p>
        <ul class="menu-list">
            <li><a id="sidenav-profile" href="/control/profile" class="has-ba"><i class="fa fa-user-circle"></i><span class="px-2">Profile</span></a></li>
            <li><a id="sidenav-logout" href="/logout"><i class="fa fa-sign-out-alt"></i><span class="px-2">Logout</span></a></li>
        </ul>
    </aside>
</div>
