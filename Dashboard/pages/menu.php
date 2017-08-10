<?php require '../../main-functions.php'; ?>
<?php get_header() ?>
<?php get_template_part_replace('templates/dashboard','top',array(
  'main' => 'Munu',
  'small' => 'Manage your menu',
  'icon' => 'fa-bars'
)); ?>
<?php go_to_sign_in(); ?>

<section id="breadcrumb">
  <div class="container">
    <?php get_alerts() ?>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo get_directory()?>">Home </a></li>
      <li class="breadcrumb-item active">Menu </li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">

      <div class="col-md-3">
        <?php get_template_part('templates/dashboard','menu') ?>
      </div>

      <div class="col-md-9">
        <div class="card">

          <div class="card-header bg-main white">
            Menu
          </div>
          <div class="card-body p-3">
            <div id="accordion" role="tablist" aria-multiselectable="true">
              <?php while(query_loop("SELECT * FROM menu WHERE parent_id IS NULL ORDER BY number")) : ?>
              <div class="row">
                <div class="col-md-10 offset-md-1">
                  <div class="card mb-1">
                    <div class="card-header" role="tab" id="heading<?php get_result_e('id') ?>" data-toggle="collapse" data-parent="#accordion" href="#item<?php get_result_e('id') ?>" aria-expanded="false" aria-controls="item<?php get_result_e('id') ?>">
                      <h5 class="mb-0">
                        <a data-toggle="collapse" id="item-id<?php get_result_e('id') ?>" data-parent="#accordion" href="#item<?php get_result_e('id') ?>" aria-expanded="false" aria-controls="item<?php get_result_e('id') ?>">
                          <?php get_result_e('title') ?>
                        </a>
                      </h5>
                    </div>

                    <div id="item<?php get_result_e('id') ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?php get_result_e('id') ?>">
                      <div class="card-block">
                        <form action="<?php echo get_directory()?>/option.php?form=menu_item_edit" method="post" class="form-inline">
                          <label for="edit_title" class="sr-only">Title</label>
                          <div class="input-group mr-sm-2 mb-2">
                            <div class="input-group-addon">Title</div>
                            <input type="text" name="title" value="<?php get_result_e('title') ?>" id="edit_title" class="form-control">
                          </div>
                          <label for="edit_number" class="sr-only">Number</label>
                          <div class="input-group mr-sm-2 col-md-4 mb-2">
                            <div class="input-group-addon">Number</div>
                            <input type="number" name="number" value="<?php get_result_e('number') ?>" id="edit_number" class="form-control">
                          </div>
                          <div class="input-group mr-sm-2 mb-2">
                            <label class="custom-control custom-radio">
                              <input name="visibility" type="radio" value="1" class="custom-control-input" <?php if (get_result('visibility')) echo 'checked'?>>
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-description">Visible</span>
                            </label>
                            <label class="custom-control custom-radio">
                              <input name="visibility" type="radio" value="0" class="custom-control-input" <?php if (!get_result('visibility')) echo 'checked'?>>
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-description">Hidden</span>
                            </label>
                          </div>
                          <?php if (get_result('type') == 'page'): ?>
                            <label class="mr-sm-2" for="edit_page">Page</label>
                              <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="edit_page" name="page">
                                <option selected value="<?php get_result_e('url') ?>"><?php get_result_e('title') ?></option>
                                <?php $page = new Query("SELECT * FROM pages WHERE id != '". get_result('url') ."' ORDER BY title") ?>
                                <?php while($page->query_loop()) : ?>
                                  <option value="<?php $page->get_result_e('id') ?>"><?php $page->get_result_e('title') ?></option>
                                <?php endwhile ?>
                              </select>
                          <?php else: ?>
                            <label for="edit_url" class="sr-only">Url</label>
                            <div class="input-group mr-sm-2 mb-2">
                              <div class="input-group-addon">Url</div>
                              <input type="url" name="url" value="<?php get_result_e('url') ?>" id="edit_url" class="form-control">
                            </div>
                          <?php endif; ?>
                          <div class="input-group">
                            <label class="mr-sm-2" for="edit_parent">Parent</label>
                              <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="edit_parent" name="parent">
                                <option selected value="">Choose parent</option>
                                <?php $parent = new Query("SELECT * FROM menu WHERE parent_id IS NULL AND id != '". get_result('id') ."' ORDER BY title") ?>
                                <?php while($parent->query_loop()) : ?>
                                  <option value="<?php $parent->get_result_e('id') ?>"><?php $parent->get_result_e('title') ?></option>
                                <?php endwhile ?>
                              </select>
                          </div>
                          <input type="hidden" name="item_id" value="<?php get_result_e('id') ?>">
                          <a class="btn btn-danger mr-2" onclick="send_href(this,'item-id<?php get_result_e('id') ?>')" href="<?php echo get_directory() ?>/option.php?form=menu_item_delete&item_id=<?php get_result_e('id') ?>" data-toggle="modal" data-target="#delete">Delete</a>
                          <input type="submit" name="submit" value="Save changes" class="btn btn-primary">
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                <?php $child = new Query("SELECT * FROM menu WHERE parent_id = '".get_result('id')."' ORDER BY number") ?>
                <?php while($child->query_loop()) : ?>
                <div class="row">
                  <div class="col-md-9 offset-md-2">
                    <div class="card mb-1">
                      <div class="card-header" role="tab" id="heading<?php $child->get_result_e('id') ?>" data-toggle="collapse" data-parent="#accordion" href="#item<?php $child->get_result_e('id') ?>" aria-expanded="false" aria-controls="item<?php $child->get_result_e('id') ?>">
                        <h5 class="mb-0">
                          <a data-toggle="collapse" id="item-id<?php $child->get_result_e('id') ?>" class="" data-parent="#accordion" href="#item<?php $child->get_result_e('id') ?>" aria-expanded="false" aria-controls="item<?php $child->get_result_e('id') ?>">
                            <?php fa_icon('fa-level-up') ?><?php $child->get_result_e('title') ?>
                          </a>
                        </h5>
                      </div>
                      <div id="item<?php $child->get_result_e('id') ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?php $child->get_result_e('id') ?>">
                        <div class="card-block">
                          <form action="<?php echo get_directory()?>/option.php?form=menu_item_edit" method="post" class="form-inline">
                            <label for="edit_title" class="sr-only">Title</label>
                            <div class="input-group mr-sm-2 mb-2">
                              <div class="input-group-addon">Title</div>
                              <input type="text" name="title" value="<?php $child->get_result_e('title') ?>" id="edit_title" class="form-control">
                            </div>
                            <label for="edit_number" class="sr-only">Number</label>
                            <div class="input-group mr-sm-2 col-md-4 mb-2">
                              <div class="input-group-addon">Number</div>
                              <input type="number" name="number" value="<?php $child->get_result_e('number') ?>" id="edit_number" class="form-control">
                            </div>
                            <div class="input-group mr-sm-2 mb-2">
                              <label class="custom-control custom-radio">
                                <input name="visibility" type="radio" value="1" class="custom-control-input" <?php if ($child->get_result('visibility')) echo 'checked'?>>
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Visible</span>
                              </label>
                              <label class="custom-control custom-radio">
                                <input name="visibility" type="radio" value="0" class="custom-control-input" <?php if (!$child->get_result('visibility')) echo 'checked'?>>
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Hidden</span>
                              </label>
                            </div>
                            <?php if ($child->get_result('type') == 'page'): ?>
                              <label class="mr-sm-2" for="edit_page">Page</label>
                                <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="edit_page" name="page">
                                  <option selected value="<?php get_result_e('url') ?>"><?php $child->get_result_e('title') ?></option>
                                  <?php $page = new Query("SELECT * FROM pages WHERE id != '". $child->get_result('url') ."' ORDER BY title") ?>
                                  <?php while($page->query_loop()) : ?>
                                    <option value="<?php $page->get_result_e('id') ?>"><?php $page->get_result_e('title') ?></option>
                                  <?php endwhile ?>
                                </select>
                            <?php else: ?>
                              <label for="edit_url" class="sr-only">Url</label>
                              <div class="input-group mr-sm-2 mb-2">
                                <div class="input-group-addon">Url</div>
                                <input type="url" name="url" value="<?php $child->get_result_e('url') ?>" id="edit_url" class="form-control">
                              </div>
                            <?php endif; ?>
                            <div class="input-group">
                              <label class="mr-sm-2" for="edit_parent">Parent</label>
                                <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="edit_parent" name="parent">
                                  <option selected value="<?php get_result_e('id') ?>"><?php get_result_e('title') ?></option>
                                  <?php $parent = new Query("SELECT * FROM menu WHERE parent_id IS NULL AND id != '". get_result('id') ."' ORDER BY title") ?>
                                  <?php while($parent->query_loop()) : ?>
                                    <option value="<?php $parent->get_result_e('id') ?>"><?php $parent->get_result_e('title') ?></option>
                                  <?php endwhile ?>
                                  <option value="NULL" class="text-danger">Unset</option>
                                </select>
                            </div>
                            <input type="hidden" name="item_id" value="<?php $child->get_result_e('id') ?>">
                            <a class="btn btn-danger mr-2" onclick="send_href(this,'item-id<?php $child->get_result_e('id') ?>')" href="<?php echo get_directory() ?>/option.php?form=menu_item_delete&item_id=<?php $child->get_result_e('id') ?>" data-toggle="modal" data-target="#delete">Delete</a>
                            <input type="submit" name="submit" value="Save changes" class="btn btn-primary">
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile ?>
            <?php endwhile ?>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header bg-main white">
            Add new item
          </div>
          <div class="card-body p-3">
            <?php get_template_part('templates/menu','additem'); ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger">Warning</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete <span id='item-title'></span>?</p>
      </div>
      <div class="modal-footer">
        <a href="" class="btn btn-danger" id="btn-delete">Delete</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#custom-settings').hide();
  $('#type-page').click(function() {
    $('#page-settings').show(300);
    $('#custom-settings').hide(300);
  });
  $('#type-custom').click(function() {
    $('#page-settings').hide(300);
    $('#custom-settings').show(300);
  });
</script>

<script>
  function send_href(btn,item) {
    var href = btn.href;
    $('#btn-delete').attr('href',href);

    $('#item-title').text($('#'+item).text());
  }
</script>

<?php get_footer() ?>
