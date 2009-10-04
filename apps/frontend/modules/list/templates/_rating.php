<span class='thumbs_rating'>
    <?php echo link_to('thumbs up', $sf_request->getUri(), array('class' => 'thumbs-up')) ?>
    <?php echo link_to('thumbs down', $sf_request->getUri(), array('class' => 'thumbs-down')) ?>
</span>