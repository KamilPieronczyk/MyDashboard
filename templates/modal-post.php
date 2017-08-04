<div class="modal fade" id="post">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Post</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
          <form id="add-post" method="POST" action="<?php echo get_directory()?>/option.php?form=post_create" enctype="multipart/form-data">
            <fieldset class="form-group">
              <label for="page-title"><h5>Post title</h5></label>
              <input type="text" class="form-control" name="title" id="page-title" placeholder="Enter post title">
              <small class="text-muted">This will be show in the title attribute</small>
            </fieldset>
            <fieldset class="form-group">
              <label for="page-content"><h5>Content</h5></label>
              <textarea class="form-control" id="post-content" name="content" rows="3"></textarea>
              <script>
                CKEDITOR.replace( 'post-content' );
              </script>
            </fieldset>
            <fieldset>
              <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="published">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Published</span>
              </label>
            </fieldset>
            <fieldset>
              <div class="form-group">
                <label for="exampleInputFile">Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                <small id="fileHelp" class="form-text text-muted">Post thumbnail</small>
              </div>
            </fieldset>

        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" value="Submit">Save changes</button>
      </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
