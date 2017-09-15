<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Login / Register / Reset password / Restrict access</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>


<nav id="navigation">
    <a href="/logout" class="logout">Logout</a>
    <a href="/">Login</a>
    <a href="/register">Register</a>
    <a href="/forgot">Forgot password?</a>
</nav>

<div class="row">

    <div class="large-6 medium-8 small-12 columns large-offset-3 medium-offset-2">

        <div class="content">

            @yield('content')

        </div>

    </div>

</div>

<script src="/assets/js/app.js"></script>
</body>
</html>

