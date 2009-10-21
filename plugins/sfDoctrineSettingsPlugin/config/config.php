<?php


$configCache = sfProjectConfiguration::getActive()->getConfigCache();
$configCache->registerConfigHandler('config/defaults.yml', 'sfSettingsConfigHandler');