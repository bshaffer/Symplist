<td colspan="3">
  <?php echo __('%%body%% - %%created_at%% - %%approved%%', array('%%body%%' => link_to($comment->getBody(), 'comment_csCommentAdmin_edit', $comment), '%%created_at%%' => false !== strtotime($comment->getCreatedAt()) ? format_date($comment->getCreatedAt(), "f") : '&nbsp;', '%%approved%%' => get_partial('csCommentAdmin/list_field_boolean', array('value' => $comment->getApproved()))), 'messages') ?>
</td>
