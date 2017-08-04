<div class="modal fade" id="page">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Page</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
          <form id="add-page" method="POST" action="<?php echo get_directory()?>/option.php?form=page_create" enctype="multipart/form-data">
            <fieldset class="form-group">
              <label for="page-title"><h5>Page title</h5></label>
              <input type="text" class="form-control" name="title" id="page-title" placeholder="Enter page title">
              <small class="text-muted">This will be show in the title attribute</small>
            </fieldset>
            <fieldset class="form-group">
              <label for="page-content"><h5>Content</h5></label>
              <textarea class="form-control" id="page-content" name="content" rows="3"></textarea>
              <script>
                CKEDITOR.replace( 'page-content' );
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
              <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="special">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Custom theme</span>
                <small class="text-muted">Default none</small>
              </label>
            </fieldset>
            <fieldset>
              <div class="form-group">
                <label for="exampleInputFile">Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                <small id="fileHelp" class="form-text text-muted">Page thumbnail</small>
              </div>
            </fieldset>
          </form>

        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="add-page" class="btn btn-primary" value="Submit">Save changes</button>
      </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
