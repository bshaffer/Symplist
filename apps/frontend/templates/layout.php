<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
  <body>
    <?php use_helper('Navigation') ?>
    <div id="header">
      <div class='content'>
        <?php include_component('sfLucene', 'search_bar', array()) ?>
        <a href='<?php echo url_for('@homepage') ?>'>
          <span id="site-logo">Symplist</span>
        </a>
        <?php include_navigation(array('id' => 'nav')) ?>
        <?php include_partial('site/secondary_nav', array()) ?>
      </div>
    </div>
    <div id="page" class="container_16 clearfix">      
      <div id="content-area" class="grid_16">
        <?php include_partial('global/flashes') ?>
        <div class='content'>
          <?php echo $sf_content ?>
        </div>
      </div>
    </div>

    <div id="footer">
      <ul id="footer-nav">
        <?php include_navigation(array('menu' => 'Footer')) ?>
      </ul>
    </div>
  </body>
</html>
