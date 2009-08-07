<?php
$config = array('setting_table'         =>  'sf_setting');

if( is_readable($config_file = sfConfig::get('sf_config_dir').'/sfDoctrineSettingsPlugin.yml') )
{
  $doctrine_comments_config = sfYaml::load($config_file);
  
  if(isset($doctrine_comments_config['schema']))
  {
    $config = array_merge($config, $doctrine_comments_config['schema']);
  }
}