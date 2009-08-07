<?php


$configCache = sfProjectConfiguration::getActive()->getConfigCache();
$configCache->registerConfigHandler('config/navigation.yml', 'csNavigationConfigHandler');