<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Echo</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/jquery.Jcrop.css">
      <script src="/js/jquery-2.1.4.min.js"></script>
      <script src="/js/jquery.Jcrop.min.js"></script>
      <script src="/js/bootstrap.min.js"></script>
      <script src="/js/jquery.form.js"></script>
      <script src="/js/vue.min.js"></script>
      <script src="/js/vue-resource.min.js"></script>
<meta id="token" name="token" value="{{csrf_token()}}">
</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/index">Echo</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">首页</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li>
                        <a id="drop1" type="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" role="button" href="#">
                            {{Auth::user()->name}}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/user/avatar"><i class="fa fa-user"></i> 更换头像</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i> 更换密码</a></li>
                            <li><a href="#"><i class="fa fa-heart"></i> 特别感谢</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="/logout"><i class="fa fa-sign-out"></i> 退出登录</a></li>
                        </ul>
                    </li>
                    <li><img src="{{Auth::user()->avatar}}" class="img-circle" width="50" alt=""></li>
                @else
                <li><a href="user/login">登 入</a></li>
                <li><a href="user/register">注 册</a></li>
                    <li><a href="/logout">登 出</a></li>
                    @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
@yield('content')
</body>
</html>