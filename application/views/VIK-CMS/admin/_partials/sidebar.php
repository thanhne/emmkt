<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                </div>
                <!-- /input-group -->
            </li>
            <li>
                <a href="/admin/dashboard/"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li class="">
                <a href="/admin/campaign/email/list/" class=""><i class="fa fa-envelope-o"></i> Campaigns<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" aria-expanded="true" style="">
                    <li><a href="/admin/campaign/email/list/" disable>Lists</a></li>
                    <li><a href="/admin/campaign/email/add/setup/">Add a new campaign</a></li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li class="">
                <a href="/admin/campaign/template/list/" class=""><i class="fa fa-edit"></i> Templates<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" aria-expanded="true" style="">
                    <li><a href="/admin/campaign/template/list/">Lists</a></li>
                    <li><a href="/admin/campaign/template/add/">Add a new template</a></li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li class="">
                <a href="/admin/contact/group/list/" class=""><i class="fa fa-group"></i> Groups<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" aria-expanded="true" style="">
                    <li><a href="/admin/contact/group/list/">Lists</a></li>
                    <li><a href="/admin/contact/group/add/">Add a new group</a></li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li class="">
                <a href="/admin/contact/list/" class=""><i class="fa fa-user-md"></i> Contacts<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/admin/contact/list/">Lists</a></li>
                    <li><a href="/admin/contact/add/">Add a new contact</a></li>
                    <li><a href="/admin/contact/import/" onclick="vik.alert_msg('Coming soon');">Import from file</a></li>
                    <!-- <li><a href="#" onclick="vik.alert_msg('Coming soon');">Export to file</a></li> -->
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li class="">
                <a href="/admin/user/list/" class=""><i class="fa fa-user"></i> Users<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/admin/user/list/">Lists</a></li>
                    <li><a href="/admin/user/add/">Add a new contact</a></li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li class="">
                <a href="#" class=""><i class="fa fa-gear"></i> Setting<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="/admin/setting/">General</a></li>
                    <li><a href="/admin/setting/#email-setting">Email Seting</a></li>
                    <li><a href="#">API</a></li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->