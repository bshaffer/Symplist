<?php 
function has_helper($helper=null)
{
  if (is_null($helper)){
    throw new sfException('Missing first argument from has_helper');
  }
  else{
    try{
      use_helper($helper);
    }
    catch (Exception $e){
      return false;
    }

    return true;
  }
}