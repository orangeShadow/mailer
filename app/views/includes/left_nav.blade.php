<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <?/*
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
            </li>*/?>
            <li>
                <a class="active" href="{{Config::get('app.url')}}"><i class="fa fa-dashboard fa-fw"></i> {{trans('main.Dashboard')}}</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-envelope-o fa-fw"></i> {{trans('main.Mailing')}}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{URL::action('MailingController@index')}}">{{trans('main.List')}}</a>
                    </li>
                    <li>
                        <a href="{{URL::action('MailingController@create')}}">{{trans('main.Add')}}</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-files-o fa-fw"></i> {{trans('main.MailTemplates')}}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{URL::action('TemplatesController@index')}}">{{trans('main.List')}}</a>
                    </li>
                    <li>
                        <a href="{{URL::action('TemplatesController@create')}}">{{trans('main.Create')}}</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i> {{trans('main.Subscribers')}}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{URL::action('SubscriberController@index')}}">{{trans('main.List')}}</a>
                    </li>
                    <li>
                        <a href="{{URL::action('SubscriberController@create')}}">{{trans('main.Add')}}</a>
                    </li>
                    <li>
                        <a href="{{URL::action('GroupController@index')}}">{{trans('main.GroupList')}}</a>
                    </li>
                    <li>
                        <a href="{{URL::action('GroupController@create')}}">{{trans('main.AddGroup')}}</a>
                    </li>
                    <li>
                        <a href="#">{{trans('main.AddCSV')}}</a>
                    </li>
                    <li>
                        <a href="#">{{trans('main.DeleteCSV')}}</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>