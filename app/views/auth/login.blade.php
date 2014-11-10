<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{!empty($this->title) ? $this->title: Config::get("app.name")}}</title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{trans('main.signIn')}}</h3>
                </div>
                <div class="panel-body">
                    @if(!empty($errors->get('login')[0]))
                        <label class="alert alert-warning">{{$errors->get('login')[0]}}</label>
                    @endif
                    {{ Form::open(array('url' => 'login','role'=>'form')) }}
                        <fieldset>
                            <div class="form-group">
                                {{ Form::email('email',null,array('class'=>'form-control','placeholder'=>'Email','autofocus'=>'autofocus')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::password('password',array('class'=>'form-control','placeholder'=>trans('main.Password'))) }}
                            </div>
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox('remember',false,array()) }} {{trans('main.rememberMe')}}
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            {{ Form::submit('Login', array('class' => 'btn btn-lg btn-success btn-block')) }}
                        </fieldset>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery Version 1.11.0 -->
<script src="/js/jquery-1.11.0.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="/js/plugins/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="/js/sb-admin-2.js"></script>

</body>

</html>
