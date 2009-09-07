<?php

include(dirname(__FILE__).'/../bootstrap/Doctrine.php');

$t = new lime_test(3, new lime_output_color());

$t->comment('initializing test database...');

Doctrine::getTable('SymfonyPlugin')->createQuery('p')->delete()->execute();


$t->comment('testing plugin');
$p = new SymfonyPlugin();
$p['title'] = 'sfThisIsATestPlugin';
$p->save();

$t->is($p->getIndexableTitle(), 'sf this is a test', 'correct string for Lucene indexing');
$t->is($p->isRegistered(), false, 'plugin is not registered');
$t->is($p['symfony_plugins_url'], 'http://www.symfony-project.org/plugins/sfThisIsATestPlugin', 'plugin URL matches Symfony Plugins URL');
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
$t->is($p['rating'], 3.5, '3.667 rating rounds down to 3.5');

$t->comment('add another rating of 4');
$p->addRating(4);
$t->is($p['num_votes'], 4, 'number of votes is now 4');
$t->is($p['rating'], 4, '3.75 rating rounds up to 4');