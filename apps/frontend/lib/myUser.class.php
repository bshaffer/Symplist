<?php

class myUser extends sfGuardSecurityUser
{
  public function getId()
  {
    return $this->isAuthenticated() ? $this->getGuardUser()->getId() : null;
  }
}
