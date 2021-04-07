<nav class="navbar-default navbar-side" role="navigation">
    <div id="sideNav" href=""><i class="fa fa-caret-right"></i></div>
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li>
                <a <?= (strpos($_SERVER['PHP_SELF'],'/dashboard/') > -1) ? 'class="active-menu"' : '' ?> href="../dashboard/"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a <?= (strpos($_SERVER['PHP_SELF'],'/subjects/') > -1) ? 'class="active-menu"' : '' ?> href="../subjects/"><i class="fa fa-book"></i> Fanlar</a>
            </li>
            <li>
                <a <?= (strpos($_SERVER['PHP_SELF'],'/questions/') > -1) ? 'class="active-menu"' : '' ?> href="../questions/"><i class="fa fa-question-circle"></i> Savollar</a>
            </li>
            <li>
                <a <?= (strpos($_SERVER['PHP_SELF'],'/groups/') > -1) ? 'class="active-menu"' : '' ?>  href="../groups/"><i class="fa fa-th-list"></i> Guruhlar</a>
            </li>
            <li>
                <a <?= (strpos($_SERVER['PHP_SELF'],'/students/') > -1) ? 'class="active-menu"' : '' ?> href="../students/"><i class="fa fa-users"></i> Talabalar</a>
            </li>
        </ul>
    </div>
</nav>