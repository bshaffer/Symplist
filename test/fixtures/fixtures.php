<?php

Doctrine::getTable('PluginAuthor')->findAll()->delete();
Doctrine::getTable('SymfonyPlugin')->findAll()->delete();
Doctrine::getTable('CommunityList')->findAll()->delete();
Doctrine::getTable('sfGuardUser')->findAll()->delete();

$user = new sfGuardUser();
$user['username'] = 'test';
$user['password'] = 'test';
$user->save();

$plugin1 = new SymfonyPlugin();
$plugin1->fromArray(array('title' => 'sfFooPlugin'));
$plugin1->save();

$plugin2 = new SymfonyPlugin();
$plugin2->fromArray(array('title' => 'sfBarPlugin'));
$plugin2->save();

$plugin3 = new SymfonyPlugin();
$plugin3->fromArray(array('title' => 'sfChunkyPlugin'));
$plugin3->save();

$plugin4 = new SymfonyPlugin();
$plugin4->fromArray(array('title' => 'sfBaconPlugin'));
$plugin4->save();

$plugin5 = new SymfonyPlugin();
$plugin5->fromArray(array('title' => 'sfBetterPlugin', 'Ratings' => array(array('rating' => '5'), array('rating' => '5'))));
$plugin5->save();

$plugin6 = new SymfonyPlugin();
$plugin6->fromArray(array('title' => 'sfWorsePlugin', 'Ratings' => array(array('rating' => '1'), array('rating' => '1'), array('rating' => '1'))));
$plugin6->save();