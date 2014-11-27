<!DOCTYPE>
<html>
<head>
    {{$template->meta}}
    <title>{{$template->title}}</title>
    <style type="text/css">
        {{$template->css}}
    </style>
</head>
<body>
{{$template->header}}
{{$mailing->contnet}}
{{$template->footer}}
</body>
</html>