<?php

include(dirname(__FILE__).'/../bootstrap/Doctrine.php');

$t = new lime_test(1, new lime_output_color());

// Doctrine::loadData(sfConfig::get('sf_test_dir').'/fixtures');

$list = new CommunityList();
$list['title'] = "This is a test list that will be last";
for ($i=0; $i < 10; $i++) 
{ 
  $item = new CommunityListItem();
  $item->fromArray(array('title' => 'Test Item', 'score' => 1));
  $list['Items'][] = $item;
}
$list->save();

$list2 = new CommunityList();
$list2['title'] = "This is a test list that will be first";
for ($i=0; $i < 10; $i++) 
{ 
  $item = new CommunityListItem();
  $item->fromArray(array('title' => 'Test Item', 'score' => 5));
  $list2['Items'][] = $item;
}
$list2->save();

$top = Doctrine::getTable('CommunityList')->getPopularListsQuery()->fetchOne();
$t->is($top['id'], $list2['id'], 'verify the most popular lists are pulled by aggregate score');