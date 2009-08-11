<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @package form
 * @package sf_guard_user
 */
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm
{
  public function configure()
  {
    parent::configure();
    unset($this['is_super_admin'], $this['is_active'], $this['permissions_list'], $this['groups_list']);
  }
}