<?php if ($attachments = $object->getAttachments()): ?>
  <?php if ($attachments->count()): ?>
    <ul class='<?php echo strtolower(get_class($object)) ?>-attachments-list'>
    <?php foreach ($attachments as $attachment): ?>
      <li><?php echo link_to($attachment->getTitle(), $attachment->getAttachmentRoute(), 'target=blank') ?></li>
    <?php endforeach ?>
    </ul>
  <?php endif ?>
<?php endif ?>