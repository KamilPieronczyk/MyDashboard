<form action="<?php echo get_directory() ?>/option.php?form=menu_item_add" method="POST">
  <fieldset class="form-group text-center">
    <label class="custom-control custom-radio">
      <input id="type-page" name="type" type="radio" value="page" class="custom-control-input" checked>
      <span class="custom-control-indicator"></span>
      <span class="custom-control-description">Page</span>
    </label>
    <label class="custom-control custom-radio">
      <input id="type-custom" name="type" type="radio" value="custom" class="custom-control-input">
      <span class="custom-control-indicator"></span>
      <span class="custom-control-description">Custom url</span>
    </label>
  </fieldset>

  <div class="form-group row">
    <label for="title" class="col-md-2 col-sm-12 col-form-label">Title</label>
    <div class="col-md-10 col-sm-12">
      <input type="text" class="form-control" name="title" value="">
    </div>
  </div>

  <div class="form-group row">
    <label for="title" class="col-md-2 col-sm-12 col-form-label">Visibility</label>
    <div class="col-md-10 col-sm-12">
      <label class="custom-control custom-radio">
        <input id="visibility" name="visibility" value="1" type="radio" class="custom-control-input" checked>
        <span class="custom-control-indicator"></span>
        <span class="custom-control-description">Visible</span>
      </label>
      <label class="custom-control custom-radio">
        <input id="visibility" name="visibility" value="0" type="radio" class="custom-control-input">
        <span class="custom-control-indicator"></span>
        <span class="custom-control-description">Hidden</span>
      </label>
    </div>
  </div>

  <div id="page-settings">
    <div class="form-group row">
      <label for="select" class="col-md-2 col-sm-12 col-form-label">Choose page</label>
      <div class="col-md-10 col-sm-12">
        <select class="custom-select" name="page" id="select">
          <option value ="NULL" selected>Choose page</option>
          <?php while(query_loop("SELECT * FROM pages ORDER BY title")) : ?>
          <option value="<?= get_result('id') ?>"><?= get_result('title') ?></option>
          <?php endwhile; ?>
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label for="number" class="col-md-2 col-sm-12 col-form-label">Choose number for this item</label>
      <div class="col-md-10 col-sm-12">
        <input type="number" name="number" value="" class="form-control">
      </div>
    </div>
  </div>

  <div id="custom-settings">
    <div class="form-group row">
      <label for="link" class="col-md-2 col-sm-12 col-form-label">Link</label>
      <div class="col-md-10 col-sm-12">
        <input type="url" class="form-control" id="link" name="url" value="">
      </div>
    </div>
  </div>

  <div class="form-group row">
    <label for="select" class="col-md-2 col-sm-12 col-form-label">Choose parent page</label>
    <div class="col-md-10 col-sm-12">
      <select class="custom-select" name="parent" id="select">
        <option value="NULL" selected>Choose parent</option>
        <?php while(query_loop("SELECT * FROM menu WHERE parent_id IS NULL ORDER BY title")) : ?>
        <option value="<?= get_result('id') ?>"><?= get_result('title') ?></option>
        <?php endwhile; ?>
      </select>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Add item</button>
</form>
