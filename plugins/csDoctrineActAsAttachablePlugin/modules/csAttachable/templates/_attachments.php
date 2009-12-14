<?php use_helper($javascriptHelper) ?>
<?php $sf_response->addStylesheet('/csDoctrineActAsAttachablePlugin/css/attachments.css'); ?>

<div id='attachments_display'>

  <?php if (count($types)): ?>
    <?php foreach ($types as $type): ?>
      <?php $type_form = $type . '_form' ?>
      <?php include_component('csAttachable','attachments_group', 
          array('table'            => $table, 
                'attachments'      => $$type, 
                'attachment'       => $$type_form,
                'type'             => $type, 
                'form'             => $form,
                'javascriptHelper' => $javascriptHelper)) ?>
    <?php endforeach ?>
  <?php else: ?>
    <?php include_component('csAttachable', 'attachments_group', 
        array('table'            => $table, 
              'attachments'      => $attachments, 
              'attachment'       => $attachment,
              'type'             => '', 
              'form'             => $form,
              'javascriptHelper' => $javascriptHelper)) ?>
  <?php endif ?>

  <script>
  function attachment_refresh_form()
  {
    jQuery('#attachments_display').load('<?php echo url_for("@cs_attachable_refresh?javascriptHelper=" . $javascriptHelper . "&table=" . $table . "&object_id=" . $form->getObject()->getId()); ?>')
  }
  </script>
</div>

<iframe name="hiddenIframe" style="display: none" ></iframe>
