<?php
// auto-generated by sfLuceneProjectConfigHandler
// date: 2009/08/07 21:44:50

$config = array();



// processing  SiteSearch now...
$config['SiteSearch'] = array (
  'models' => 
  array (
    'SymfonyPlugin' => 
    array (
      'route' => '%route%',
      'partial' => 'sfLucene/searchResult',
      'fields' => 
      array (
        'id' => 
        array (
          'type' => 'unindexed',
          'boost' => 1,
          'transform' => NULL,
        ),
        'title' => 
        array (
          'type' => 'text',
          'boost' => 1.5,
          'transform' => NULL,
        ),
        'description' => 
        array (
          'type' => 'text',
          'boost' => 1,
          'transform' => NULL,
        ),
        'route' => 
        array (
          'type' => 'unindexed',
          'boost' => 1,
          'transform' => NULL,
        ),
      ),
      'title' => 'title',
      'description' => 'description',
      'indexer' => NULL,
      'peer' => 'SymfonyPluginPeer',
      'rebuild_limit' => 250,
      'validator' => NULL,
      'categories' => 
      array (
      ),
    ),
  ),
  'index' => 
  array (
    'encoding' => 'utf-8',
    'cultures' => 
    array (
      0 => 'en',
    ),
    'stop_words' => 
    array (
      0 => 'a',
      1 => 'an',
      2 => 'at',
      3 => ' the',
      4 => 'and',
      5 => 'or',
      6 => 'is',
      7 => 'am',
      8 => 'are',
      9 => 'of',
    ),
    'short_words' => 2,
    'analyzer' => 'textnum',
    'case_sensitive' => false,
    'mb_string' => false,
    'param' => 
    array (
    ),
  ),
  'factories' => 
  array (
    'indexers' => 
    array (
    ),
    'results' => 
    array (
    ),
  ),
);
