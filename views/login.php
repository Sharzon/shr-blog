<div class="container">
    <?php
    if (isset($data->wrong)) { ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-danger">
                    Wrong username and password
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Login
                </div>
                <div class="panel-body">
                    <form class="form-horizontal"
                          role="form"
                          method="POST"
                          action="/login">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="login">
                                Username
                            </label>
                            <div class="col-md-6">
                                <input type="text"
                                       class="form-control"
                                       id="username"
                                       name="username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="password">
                                Password
                            </label>
                            <div class="col-md-6">
                                <input type="password"
                                       class="form-control"
                                       id="password"
                                       name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>