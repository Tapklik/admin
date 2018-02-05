<header class="clearfix">
    <div class="col-md-2">
        <h1 class="clearfix">
            <img src="//tapklik.com/assets/images/logo.png" alt="Logo"/>
        </h1>
    </div>
    <div class="col-md-1">
        <small class="pull-right" style="font-size: 14px; color: #fff; margin-top: 25px; ">v0.1.4-ALPHA</small>
    </div>
    <div class="col-md-9">
        <nav>
            <ul>
                <li class="{{ Request::is('dashboard') ? 'selected' : '' }}">
                    <a href="/dashboard">
                        Dashboard
                    </a>
                </li>
                <li class="{{ Request::is('accounts') ? 'selected' : '' }}">
                    <a href="/accounts">
                        Accounts
                    </a>
                </li>
                <li class="{{ Request::is('reports') ? 'selected' : '' }}">
                    <a href="/reports">
                        Reports
                    </a>
                </li>
                <!--
                <li class="{{ Request::is('accounting') ? 'selected' : '' }}">
                    <a href="/accounting">
                        Accounting
                    </a>
                </li>
                -->
                <li class="{{ Request::is('support') ? 'selected' : '' }}">
                    <a href="/support">
                        Support
                    </a>
                </li>
                <li class="{{ Request::is('logout') ? 'selected' : '' }}">
                    <a href="/logout">
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
