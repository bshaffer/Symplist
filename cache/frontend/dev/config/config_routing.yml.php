<?php
// auto-generated by sfRoutingConfigHandler
// date: 2009/08/07 21:44:32
return array(
'meta_data_edit' => new sfRoute('/seo/meta_data/edit', array (
  'module' => 'csSEO',
  'action' => 'editMetaData',
), array (
), array (
)),
'sitemap_xml_edit' => new sfRoute('/seo/sitemap_data/edit', array (
  'module' => 'csSEO',
  'action' => 'editSitemapData',
), array (
), array (
)),
'sitemap_xml' => new sfRoute('/sitemap.xml', array (
  'module' => 'csSEO',
  'action' => 'sitemap',
  'location_slug' => 'main',
  'format' => 'xml',
), array (
), array (
)),
'jsthumbnail' => new sfRoute('/jsThumbnail', array (
  'module' => 'jsThumbnail',
  'action' => 'thumbnail',
), array (
), array (
)),
'jsthumbnail_remote' => new sfRoute('/jsThumbnail/remote', array (
  'module' => 'jsThumbnail',
  'action' => 'remote',
), array (
), array (
)),
'cscomments_comments_add' => new sfRoute('/csComments/comments/add', array (
  'module' => 'csComments',
  'action' => 'add',
), array (
), array (
)),
'cscomments_comments_do_add' => new sfRoute('/csComments/comments/addComment', array (
  'module' => 'csComments',
  'action' => 'doAdd',
), array (
), array (
)),
'cscomments_comments_edit' => new sfRoute('/csComments/comments/editComment', array (
  'module' => 'csComments',
  'action' => 'doEdit',
), array (
), array (
)),
'cscomments_comments_delete' => new sfRoute('/csComments/comments/deleteComment', array (
  'module' => 'csComments',
  'action' => 'doDelete',
), array (
), array (
)),
'comment_csCommentAdmin' => new sfDoctrineRouteCollection(array (
  'model' => 'Comment',
  'module' => 'csCommentAdmin',
  'prefix_path' => 'csCommentAdmin',
  'column' => 'id',
  'with_wildcard_routes' => true,
  'name' => 'comment_csCommentAdmin',
  'requirements' => 
  array (
  ),
)),
'plugins' => new sfRoute('/plugins', array (
  'module' => 'plugin',
  'action' => 'list',
), array (
), array (
)),
'plugin_categories' => new sfRoute('/plugins/categories', array (
  'module' => 'plugin',
  'action' => 'categories',
), array (
), array (
)),
'plugins_by_category' => new sfRoute('/plugins/categories/:slug', array (
  'module' => 'plugin',
  'action' => 'byCategory',
), array (
), array (
)),
'plugin' => new sfRoute('/plugins/:title', array (
  'module' => 'plugin',
  'action' => 'show',
), array (
), array (
)),
'authors' => new sfRoute('/authors', array (
  'module' => 'author',
  'action' => 'index',
), array (
), array (
)),
'author' => new sfRoute('/authors/:username', array (
  'module' => 'author',
  'action' => 'index',
), array (
), array (
)),
'homepage' => new sfRoute('/', array (
  'module' => 'plugin',
  'action' => 'index',
), array (
), array (
)),
'default_index' => new sfRoute('/:module', array (
  'action' => 'index',
), array (
), array (
)),
'default' => new sfRoute('/:module/:action/*', array (
), array (
), array (
)),
);
