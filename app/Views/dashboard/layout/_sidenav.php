<div id="mainSidenav" class="sidenav">
    <aside class="menu">
        <p class="menu-label mx-2 has-text-light">
            General
        </p>
        <ul class="menu-list">
            <li><a id="sidenav-dashboard-stats" href="/"><i class="fas fa-user"></i><span class="px-2">Dashboard</span></a></li>
        </ul>
        <ul class="menu-list">
            <details id="sidenav-sub-report">
                <summary class="no-select">Report</summary>
                <ul>
                    <li><a id="sidenav-money-stats" href="/control/moneystat"><i class="fas fa-money-bill-wave"></i><span class="px-2">Money</a></li>
                    <li><a id="sidenav-mining-stats" href="/control/miningstat"><i class="fas fa-hammer"></i><span class="px-2">Mining</a></li>
                    <li><a id="sidenav-coal-stats" href="/control/coalstat"><i class="fas fa-shopping-bag"></i><span class="px-2">Coal Utility</a></li>
                    <li><a id="sidenav-depot-stats" href="/control/depotstat"><i class="fas fa-box"></i><span class="px-2">Depot</a></li>
                </ul>
            </details>
        </ul>
        <ul class="menu-list">
            <details id="sidenav-sub-mining">
                <summary class="no-select">Mining</summary>
                <ul>
                    <li><a id="sidenav-mining" href="/control/mining"><i class="fas fa-hammer"></i><span class="px-2">Self Mining Record</a></li>
                    <li><a href="/control/mining/create"><i class="fas fa-plus"></i><span class="px-2">Create Mining Entry</a></li>
                    <li><a id="sidenav-depots" href="/control/depots"><i class="fas fa-box"></i><span class="px-2">Depots</a></li>
                    <li><a id="sidenav-mines" href="/control/mines"><i class="fas fa-igloo"></i><span class="px-2">Mines</a></li>
                </ul>
            </details>
        </ul>
        <ul class="menu-list">
            <details id="sidenav-sub-utility">
                <summary class="no-select">Coal Utility</summary>
                <ul>
                    <li><a id="sidenav-purchased" href="/control/purchased"><i class="fa fa-shopping-bag"></i><span class="px-2">Purchased</a></li>
                    <li><a href="/control/purchased/create"><i class="fa fa-plus"></i><span class="px-2">Create Purchased Entry</a></li>
                    <li><a id="sidenav-sold" href="/control/sold"><i class="fa fa-handshake"></i><span class="px-2">Sold</a></li>
                    <li><a href="/control/sold/create"><i class="fa fa-plus"></i><span class="px-2">Create Sold Entry</a></li>
                    <li><a id="sidenav-processed" href="/control/processed"><i class="fa fa-magic"></i><span class="px-2">Processed</a></li>
                    <li><a href="/control/processed/create"><i class="fa fa-plus"></i><span class="px-2">Create Processed Entry</a></li>
                    <li><a id="sidenav-customers" href="/control/customers"><i class="fa fa-user"></i><span class="px-2">Coal Customer</a></li>
                    <li><a id="sidenav-suppliers" href="/control/suppliers"><i class="fa fa-user"></i><span class="px-2">Coal Suppliers</a></li>
                </ul>
            </details>
        </ul>
        <ul class="menu-list">
            <details id="sidenav-sub-rent">
                <summary class="no-select">Rent</summary>
                <ul>
                    <li><a id="sidenav-rent" href="/control/rent"><i class="fa fa-truck-moving"></i><span class="px-2">Rent</a></li>
                    <li><a href="/control/rent/create"><i class="fa fa-plus"></i><span class="px-2">Create Rent Entry</a></li>
                    <li><a id="sidenav-renters" href="/control/renters"><i class="fa fa-user"></i><span class="px-2">Renters</a></li>
                </ul>
            </details>
        </ul>
        <ul class="menu-list">
            <details id="sidenav-sub-assets">
                <summary class="no-select">Assets</summary>
                <ul>
                    <li><a id="sidenav-assets" href="/control/assets"><i class="fa fa-truck-loading"></i><span class="px-2">Assets</a></li>
                    <li><a href="/control/assets/create"><i class="fa fa-plus"></i><span class="px-2">Create Asset Entry</a></li>
                    <li><a id="sidenav-assettypes" href="/control/assettypes"><i class="fa fa-truck-loading"></i><span class="px-2">Asset Types</a></li>
                </ul>
            </details>
        </ul>
        <?php if(has_permission('app.attendance')) { ?>
        <ul class="menu-list">
            <details id="sidenav-sub-attendance">
                <summary class="no-select">Attendance</summary>
                <ul>
                    <li><a id="sidenav-attendance" href="/control/attendance"><i class="fa fa-table"></i><span class="px-2">Attendance</a></li>
                    <li><a href="/control/attendance/create"><i class="fa fa-plus"></i><span class="px-2">Create Attendance Entry</a></li>
                    <li><a id="sidenav-attendancebulk" href="/control/attendancebulk"><i id="sidenav-coal-processed" class="fa fa-plus-circle"></i><span class="px-2">Bulk Attendance</a></li>
                </ul>
            </details>
        </ul>
        <?php } ?>
        <?php if(has_permission('app.salary')) { ?>
        <ul class="menu-list">
            <details id="sidenav-sub-payroll">
                <summary class="no-select">Payroll</summary>
                <ul>
                    <li><a id="sidenav-payroll" href="/control/payroll"><i class="fa fa-money-bill-wave"></i><span class="px-2">Payroll</a></li>
                    <li><a href="/control/payroll/create"><i class="fa fa-plus"></i><span class="px-2">Create Payroll Entry</a></li>
                </ul>
            </details>
        </ul>
        <?php } ?>
        <p class="menu-label  mx-2 has-text-light">
            Administration
        </p>
        <?php if(has_permission('app.delete.entry')) { ?>
        <ul class="menu-list">
            <details id="sidenav-sub-accounts">
                <summary class="no-select">Accounts</summary>
                <ul>
                    <li><a id="sidenav-accounts" href="/control/accounts"><i class="fa fa-user-circle"></i><span class="px-2">Accounts</span></a></li>
                    <li><a href="/control/accounts/create"><i class="fa fa-plus"></i><span class="px-2">Create Account</span></a></li>
                </ul>
            </details>
        </ul>
        <?php } ?>
        <?php if(has_permission('app.salary')) { ?>
        <ul class="menu-list">
            <details id="sidenav-sub-employees">
                <summary class="no-select">Employees</summary>
                <ul>
                    <li><a id="sidenav-employees" href="/control/employees"><i class="fa fa-user"></i><span class="px-2">Employees</span></a></li>
                    <li><a href="/control/employees/create"><i class="fa fa-plus"></i><span class="px-2">Create Employee</span></a></li>
                    <li><a id="sidenav-departmenttypes" href="/control/departmenttypes"><i class="fa fa-truck-loading"></i><span class="px-2">Department Types</a></li>
                </ul>
            </details>
        </ul>
        <?php } ?>
        <ul class="menu-list">
            <details id="sidenav-sub-vehicles">
                <summary class="no-select">Vehicle</summary>
                <ul>
                    <li><a id="sidenav-vehicles" href="/control/vehicles"><i class="fa fa-user"></i><span class="px-2">Vehicle</span></a></li>
                    <li><a href="/control/vehicles/create"><i class="fa fa-plus"></i><span class="px-2">Create Vehicle</span></a></li>
                </ul>
            </details>
        </ul>
        
        <p class="menu-label mx-2 has-text-light">
            Personal
        </p>
        <ul class="menu-list">
            <li><a id="sidenav-profile" href="/control/profile" class="has-ba"><i class="fa fa-user-circle"></i><span class="px-2">Profile</span></a></li>
            <li><a id="sidenav-logout" href="/logout"><i class="fa fa-sign-out-alt"></i><span class="px-2">Logout</span></a></li>
        </ul>
    </aside>
</div>
