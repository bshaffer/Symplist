<?php

include(dirname(__FILE__).'/../bootstrap/Doctrine.php');
include(dirname(__FILE__).'/../fixtures/fixtures.php');

$t = new lime_test(21, new lime_output_color());

include(dirname(__FILE__).'/../fixtures/fixtures.php');
// Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures');

$t->comment('testing plugin');
$p = new SymfonyPlugin();
$p['title'] = 'sfThisIsATestPlugin';
$p->save();

$t->is($p->getIndexableTitle(), 'sf this is a test', 'correct string for Lucene indexing');
$t->is($p->isRegistered(), false, 'plugin is not registered');
$t->is($p['symfony_plugin_homepage'], 'http://www.symfony-project.org/plugins/sfThisIsATestPlugin', 'plugin URL matches Symfony Plugins URL');
$t->is($p['repository'], 'http://svn.symfony-project.com/plugins/sfThisIsATestPlugin', 'default repository set');
$t->is($p['num_votes'], 0, 'no votes');
$t->is($p['rating'], 0, 'no rating');

$t->comment('add a rating of 5');
$p->addRating(5);
$t->is($p['num_votes'], 1, 'number of votes is now 1');
$t->is($p['rating'], 5, 'rating is now 5');

$t->comment('add a rating of 3');
$p->addRating(3);
$t->is($p['num_votes'], 2, 'number of votes is now 2');
$t->is($p['rating'], 4, 'rating is now 4');

$t->comment('add another rating of 3');
$p->addRating(3);
$t->is($p['num_votes'], 3, 'number of votes is now 3');
$t->is($p['rating'], 3, '3.667 rating rounds down to 3');

$t->comment('add another rating of 4');
$p->addRating(4);
$t->is($p['num_votes'], 4, 'number of votes is now 4');
$t->is($p['rating'], 4, '3.75 rating rounds up to 4');

$top = Doctrine::getTable('SymfonyPlugin')->getHighestRanking(1);
$t->is($top[0]['rating'], 5, 'pulled highest ranking plugin');

$top = Doctrine::getTable('SymfonyPlugin')->getHighestRanking(5);
$t->is($top[0]['rating'], 5, 'pulled highest ranking plugin, ordered by highest');

$top = Doctrine::getTable('SymfonyPlugin')->getHighestRanking(5);
$t->is($top[1]['id'], $p['id'], 'test plugin is number 2, ordered by highest');
$t->is($top->count(), 3, 'all rated plugins are included (plugins with rating > 0)');

$top = Doctrine::getTable('SymfonyPlugin')->getHighestRanking(5, 2);
$t->is($top->count(), 2, 'only plugins with a rating larger than 2 are included');

$most = Doctrine::getTable('SymfonyPlugin')->getMostVotes(5);

$t->is($most[0]['id'], $p['id'], 'pulled most voted plugin, ordered by most votes');
$t->is($most->count(), 3, 'only plugins with votes are pulled');
