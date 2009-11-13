<?php use_helper('Comment') ?>

<h2><?php echo $plugin['title'] ?></h2>

<p><?php echo $plugin['description'] ?></p>

<?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->id == $plugin->user_id): ?>
  <?php echo link_to('[edit]', '@plugin_edit?title='.$plugin['title']) ?>
<?php endif ?>

<div class='plugin-info <?php echo $plugin['title'] ?>'>
  <dl>
    
    <dt>Repository</dt>
    <dd><?php echo link_to($plugin->getRepository(), $plugin->getRepository(), array('style' => 'white-space:nowrap;')) ?></dd>

    <dt>More Info</dt>
    <dd><?php echo link_to($plugin->getHomepage(), $plugin->getHomepage(), array('style' => 'white-space:nowrap;')) ?></dd>


    <dt>Last Updated</dt>
    <dd><?php echo date('F jS, Y', strtotime($plugin->getUpdatedAt())) ?></dd>
  
    <dt>Releases</dt>
    <dd>
      <?php if ($plugin['Releases']->count()): ?>
        <?php foreach ($plugin['Releases'] as $release): ?>
          <?php echo $release['version'] ?>&nbsp;&nbsp;&nbsp;
        <?php endforeach ?>
      <?php else: ?>
        None
      <?php endif ?>
    </dd>

    <dt>Rate this Plugin</dt>
    <dd>
      <form class="rating" method='post' action="<?php echo url_for('@plugin_rate_ajax?title='.$plugin['title']) ?>">
      <?php for($i = 1; $i <= 5; $i++): ?>
        <input value="<?php echo $i ?>" name="rating" type="radio" class="star-rating" <?php echo ($rating == $i)?'checked':'' ?> /> 
      <?php endfor ?>
      (<?php echo $plugin->getNumVotes() . ($plugin->getNumVotes() == 1 ? ' vote' : ' votes') ?>)</span>
      </form>

    </dd>

<script type='text/javascript'>
  $(document).ready(function(){
    $('.rating input[type=radio]').rating({
      callback: function(value, link){ 
        if ($.cookie("<?php echo $plugin['title'] ?>.rating")) { 
          $('.plugin-info').before("<div class='message important'>You have already rated this plugin</div>");
          return false;
        };
        $('form.rating').load(this.form.action, { 'rating': value }, function() { 
            $('.plugin-info').before("<div class='message info'>Thank you for rating this plugin</div>");
            $('.rating input[type=radio]').rating(); // Set Rating Styles
            $.cookie("<?php echo $plugin['title'] ?>.rating", value);
        }); 
      }
    });    
  });
</script>

<?php if ($plugin->isRegistered()): ?>
    <dt>Owner</dt>
    <dd><?php echo link_to($plugin['User']->getUsername(), $plugin['User']->getRoute(), array('class' => 'author-link')) ?></dd>
  </dl>
<?php else: ?>
  </dl>

  <?php echo link_to('Claim This Plugin', '@plugin_claim?title='.$plugin['title'], array('class' => 'button')) ?>
<?php endif ?>


</div>

<?php echo get_comments($plugin) ?>