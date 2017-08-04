<div class="card">
  <div class="card-header">
    Latest users
  </div>
  <div class="card-block">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Login</th>
          <th>E-mail</th>
          <th>Name</th>
          <th>Permissions</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php while(query_loop("SELECT * FROM users ORDER BY updated DESC LIMIT 10")) : ?>
          <tr>
            <td><?php get_result_e('login') ?></td>
            <td><?php get_result_e('email') ?></td>
            <td><?php get_result_e('name') ?></td>
            <td><?php echo get_power(get_result('permission')) ?></td>
            <td><?php get_result_e('updated') ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
