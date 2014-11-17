<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>

                <a @if(Route::getCurrentRoute()->getPath()=='/') class="active" @endif href="{{Config::get('app.url')}}"><i class="fa fa-dashboard fa-fw"></i> {{trans('main.Dashboard')}}</a>
            </li>
            <li
                @if(strpos(Route::getCurrentRoute()->getPath(),'mailing')!==false) class="active" @endif
            >

                <a href="#"><i class="fa fa-envelope-o fa-fw"></i> {{trans('main.Mailing')}}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a @if(Route::getCurrentRoute()->getPath()=='mailing') class="active" @endif href="{{URL::action('MailingController@index')}}">{{trans('main.List')}}</a>
                    </li>
                    <li>
                        <a @if(Route::getCurrentRoute()->getPath()=='mailing/create') class="active" @endif href="{{URL::action('MailingController@create')}}">{{trans('main.Add')}}</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li @if(strpos(Route::getCurrentRoute()->getPath(),'templates')!==false) class="active" @endif>
                <a href="#"><i class="fa fa-files-o fa-fw"></i> {{trans('main.MailTemplates')}}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a @if(Route::getCurrentRoute()->getPath()=='templates') class="active" @endif href="{{URL::action('TemplatesController@index')}}">{{trans('main.List')}}</a>
                    </li>
                    <li>
                        <a @if(Route::getCurrentRoute()->getPath()=='templates/create') class="active" @endif href="{{URL::action('TemplatesController@create')}}">{{trans('main.Create')}}</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li @if(strpos(Route::getCurrentRoute()->getPath(),'subscriber')!==false) class="active" @endif>
                <a href="#"><i class="fa fa-user fa-fw"></i> {{trans('main.Subscribers')}}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a @if(Route::getCurrentRoute()->getPath()=='subscriber') class="active" @endif href="{{URL::action('SubscriberController@index')}}">{{trans('main.List')}}</a>
                    </li>
                    <li>
                        <a @if(Route::getCurrentRoute()->getPath()=='subscriber/create') class="active" @endif href="{{URL::action('SubscriberController@create')}}">{{trans('main.Add')}}</a>
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
            <li @if(strpos(Route::getCurrentRoute()->getPath(),'group')!==false) class="active" @endif>
                <a href="#"><i class="fa fa-users fa-fw"></i> {{trans('main.SubscribersGroup')}}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a @if(Route::getCurrentRoute()->getPath()=='group') class="active" @endif href="{{URL::action('GroupController@index')}}">{{trans('main.GroupList')}}</a>
                    </li>
                    <li>
                        <a @if(Route::getCurrentRoute()->getPath()=='group/create') class="active" @endif href="{{URL::action('GroupController@create')}}">{{trans('main.AddGroup')}}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>