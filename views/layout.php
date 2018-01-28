<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Blog</title>

    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap-theme.css">

    <script src="/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="/js/app.js"></script
</head>
<div>
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button"
                        class="navbar-toggle collapsed"
                        data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="/">
                    Blog
                </a>
            </div>

            <div class="collapse navbar-collapse"
                 id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="/post/new">New post</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if ($logged) {
                    ?>
                    <li><a href="/logout">Logout</a></li>
                    <?php } else { ?>
                    <li><a href="/login">Login</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php include __DIR__ . "/../views/$content_view.php" ?>



</div>
</body>
</html>
