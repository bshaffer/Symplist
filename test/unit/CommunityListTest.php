<?php

include(dirname(__FILE__).'/../bootstrap/Doctrine.php');
include(dirname(__FILE__).'/../fixtures/fixtures.php');

$t = new lime_test(1, new lime_output_color());

$list = new CommunityList();
$user = Doctrine::getTable('sfGuardUser')->createQuery()->fetchOne();

$list->fromArray(array('title' => "This is a test list that will be last", 'submitted_by' => $user['id']));
for ($i=0; $i < 10; $i++) 
{ 
  $item = new CommunityListItem();
  $item->fromArray(array('title' => 'Test Item', 'score' => 1, 'submitted_by' => $user['id']));

  $list['Items'][] = $item;
}

$list->save();

$list2 = new CommunityList();
$list2->fromArray(array('title' => "This is a test list that will be first", 'submitted_by' => $user['id']));
for ($i=0; $i < 10; $i++) 
{ 
  $item = new CommunityListItem();
  $item->fromArray(array('title' => 'Test Item', 'score' => 5, 'submitted_by' => $user['id']));
  $list2['Items'][] = $item;
}

$list2->save();

$top = Doctrine::getTable('CommunityList')->getPopularListsQuery()->fetchOne();
$t->is($top['id'], $list2['id'], 'verify the most popular lists are pulled by aggregate score');
