<?php sfProjectConfiguration::getActive()->loadHelpers(array('csAdminGen')); ?>
<?php if( has_helper("Thumbnail")): ?>
  <?php use_helper("Thumbnail") ?>
<?php endif; ?>
  <td class="sf_admin_text sf_admin_list_td_body" style="padding: 10px 10px 10px 10px; padding-top: 10px; padding-bottom: 10px;">
  <?php echo link_to($comment->getBody(), 'comment_csCommentAdmin_edit', $comment) ?>
</td>
  <td class="sf_admin_date sf_admin_list_td_created_at" style="padding: 10px 10px 10px 10px; padding-top: 10px; padding-bottom: 10px;">
  <?php echo false !== strtotime($comment->getCreatedAt()) ? format_date($comment->getCreatedAt(), "f") : '&nbsp;' ?>
</td>
  <td class="sf_admin_boolean sf_admin_list_td_approved" style="padding: 10px 10px 10px 10px; padding-top: 10px; padding-bottom: 10px;">
  <?php echo get_partial('csCommentAdmin/list_field_boolean', array('value' => $comment->getApproved())) ?>
</td>
