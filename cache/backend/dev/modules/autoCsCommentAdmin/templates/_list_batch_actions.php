<div class="sf_admin_batch_actions_choice">
  <select name="batch_action">
    <option value=""><?php echo __('Choose an action', array(), 'sf_admin') ?></option>
    <option value="batchApprove"><?php echo __('Approve Selected', array(), 'sf_admin') ?></option>
    <option value="batchUnapprove"><?php echo __('Unapprove Selected', array(), 'sf_admin') ?></option>
    <option value="batchDelete"><?php echo __('Delete', array(), 'sf_admin') ?></option>
  </select>
  <input type="submit" value="<?php echo __('go', array(), 'sf_admin') ?>" />
</div>
