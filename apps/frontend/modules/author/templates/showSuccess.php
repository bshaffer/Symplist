<h2><?php echo $user->getUsername() ?></h2>

<?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->id == $user->id): ?>
  <span style='font-size:.7em'><?php echo link_to('edit', '@author_edit?username='.$user['username']) ?></span>
  <br style='clear:both' />
<?php endif ?>

<?php if ($user['Author']): ?>
  <?php use_helper("Gravatar") ?>

  <?php echo gravatar_image_tag($user['Author']['email']) ?>
  <?php if ($user['Author']['first_name']): ?>
    <p>
      <strong>Name:</strong>  
      <span class='author-name'>
        <?php echo mail_to($user['Author']['email'], $user['Author']['first_name'].' '.$user['Author']['last_name']) ?>
      </span>
    </p>  
  <?php endif ?>

  <?php if (trim($user['Author']['bio'])): ?>
    <strong>Bio:</strong>
    <p>
      <?php echo $user['Author']['bio'] ?>
    </p>
  <?php endif ?>
<?php else: ?>
  <strong>This user has yet to enter any profile information</strong>
<?php endif ?>



<?php if ($user['Plugins']->count() > 0): ?>
  <h3>Plugins <span class='plugin-count'>(<?php echo (string)$user['Plugins']->count() ?>)</span></h3>
  <ol>
  <?php foreach ($user['Plugins'] as $plugin): ?>
    <li class="plugin">
    <h6><?php echo link_to($plugin['title'], $plugin['route'], array('class' => 'plugin-title')) ?>
    <?php if ($isUser): ?>
      <?php echo link_to('[remove]', '@plugin_author_delete?plugin_id='.$plugin['id'].'&author_id='.$user['id'], array('method' => 'delete', 'class' => 'delete')) ?>
    <?php endif ?>
    </h6>

    <form class="rating">
      <?php for($i = 1; $i <= 5; $i++): ?>
      <input name="star1" type="radio" class="star" <?php echo ($plugin['rating'] == $i)?'checked':'' ?> disabled /> 
      <?php endfor ?>
    </form>
    <p><?php echo $plugin['summary'] ?></p>
    </li>
  <?php endforeach ?>
  </ul>
<?php else: ?>
  <p>This user has yet to register any plugins</p>
<?php endif ?>
