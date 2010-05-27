<?php

class myUser extends sfGuardSecurityUser
{
  public function getId()
  {
    return $this->isAuthenticated() ? $this->getGuardUser()->getId() : null;
  }
  
  public function existsInUsers($users)
  {
    foreach ($users as $user) 
    {
      if ($this->isUser($user)) return true;
    }
    return false;
  }

  public function isUser(sfGuardUser $user)
  {
    return $this->isUserId($user['id']);
  }
  
  public function isUserId($id)
  {
    return ($this->isAuthenticated() && $this->getGuardUser()->id == $id);
  }
}
