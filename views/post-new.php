<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New post
                </div>
                <div class="panel-body">
                    <form>
                        <div class="form-group">
                            <label class="control-label" for="title">
                                Title
                            </label>
                            <div>
                                <input type="text"
                                       class="form-control"
                                       id="title"
                                       name="title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="body">
                                Body
                            </label>
                            <div>
                                <textarea class="form-control"
                                          id="body"
                                          name="body"
                                          rows="5">
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" id="submit">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/post-new.js"></script>