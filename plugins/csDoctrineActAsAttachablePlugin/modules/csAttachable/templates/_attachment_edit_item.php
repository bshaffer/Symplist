<?php $title = $attachment->getTitle() ? $attachment->getTitle() : $attachment->getUrl() ?>

<?php echo link_to($title, image_path($attachment->getAttachmentRoute()), 'class=link target=_blank') ?>

<?php $javascriptFunction = $javascriptHelper == 'jQuery' ? 'jq_link_to_remote' : 'link_to_remote' ?>

<?php echo $javascriptFunction('delete', 
            array(
              'url' => '@cs_attachable_delete?attachment_id='.$attachment->getId().
                                     '&object_id='.$object->getId().
                                     '&table='.$table.
                                     '&javascriptHelper='.$javascriptHelper,
              'update' => 'attachments_display',
            ), 
            array('class' => 'delete', 'confirm' => 'Are you sure?')
        ) ?>