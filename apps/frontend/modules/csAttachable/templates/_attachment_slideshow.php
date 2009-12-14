<?php use_helper('Thumbnail', 'sfJQueryLightbox') ?>
<?php if ($attachments = $object->getAttachmentsByType('Image')): ?>
  <?php if ($attachments->count()): ?>
    <strong>Screenshots:</strong>
    <ul class='plugin-slideshow clearfix'>
    <?php foreach ($attachments as $attachment): ?>
      <li>
        <?php echo link_to(thumbnail_tag($attachment->getAttachmentRoute(), '128', '128', 'crop'), $attachment->getAttachmentRoute(), array('class' => 'lightbox','title' => $attachment->getTitle() )); ?>
      </li>  
    <?php endforeach ?>
    </ul>
  <?php endif ?>
<?php endif ?>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){$('.lightbox').lightBox()})
</script>
