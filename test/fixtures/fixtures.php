<?php

Doctrine::getTable('PluginAuthor')->findAll()->delete();
Doctrine::getTable('SymfonyPlugin')->findAll()->delete();
Doctrine::getTable('CommunityList')->findAll()->delete();

