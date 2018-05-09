<header class="clearfix">
    <div class="col-md-2">
        <h1 class="clearfix">
            <img src="//tapklik.com/assets/images/logo.png" alt="Logo"/>
        </h1>
    </div>
    <div class="col-md-1">
        <small class="pull-right" style="font-size: 14px; color: #fff; margin-top: 25px; ">v0.1.1</small>
    </div>
    <div class="col-md-9">
        <nav>
            <ul>
                <li class="<?php echo e(Request::is('dashboard') ? 'selected' : ''); ?>">
                    <a href="/dashboard">
                        Dashboard
                    </a>
                </li>
                <li class="<?php echo e(Request::is('accounts') ? 'selected' : ''); ?>">
                    <a href="/accounts">
                        Accounts
                    </a>
                </li>
                <li class="<?php echo e(Request::is('reports') ? 'selected' : ''); ?>">
                    <a href="/reports">
                        Reports
                    </a>
                </li>
                <li class="<?php echo e(Request::is('accounting') ? 'selected' : ''); ?>">
                    <a href="/accounting">
                        Accounting
                    </a>
                </li>
                <li class="<?php echo e(Request::is('logout') ? 'selected' : ''); ?>">
                    <a href="/logout">
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>