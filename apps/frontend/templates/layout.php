<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <meta name="description" content="sympLIST is a community-oriented site for finding high quality Symfony plugins and developers for your web apps." />
    <meta name="keywords" content="symfony, plugins, developers, nashville, brent shaffer" />

    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
  
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
</head>
  <body class="interior" id="module-<?php echo $sf_request->getParameter('module') ?>-action-<?php echo $sf_request->getParameter('action') ?>">
  <?php use_helper('Navigation') ?>

<!-- Begin Header -->
<div id="header" class="clearfix">
  <div class="container_12">

    <!-- Begin Navigation -->
    <?php include_navigation(array('id' => 'nav-main')) ?>
    <?php include_partial('site/secondary_nav', array()) ?>
    <!-- End Navigation -->

    <h1 class="grid_6"><?php echo link_to('sympLIST', '@homepage') ?></h1>

    <?php include_partial('global/search', array()) ?>  

  </div>
</div>
    
<div id="content-wrapper" class="container_12">   
   
  <div id="content-main" class="<?php echo $sf_user->getFlash('full-page') ? 'grid_12' : 'grid_8' ?>">
    <div class="inner">

    <?php include_partial('global/flashes') ?>


    <?php echo $sf_content ?>
      
    </div>
  </div>

  <?php if (!$sf_user->getFlash('full-page')): ?>
    <!-- Sidebar -->
    <div id="sidebar" class="stats grid_4 omega">
      <?php if (has_slot('sidebar')): ?>  
        <?php include_slot('sidebar') ?>
      <?php else: ?>
        <?php include_component('site', 'sidebarDefault') ?>
      <?php endif ?>    
    </div>
    <!-- End Sidebar -->
  <?php endif ?>
</div>

<div id="footer" class="container_12">
  <?php include_navigation(array('menu' => 'Footer', 'id' => 'nav-secondary', 'class' => 'grid_6 alpha')) ?>
  <div class="copyright grid_6 omega">
    <p>©2009 Brent Shaffer. Design by <a href="#">The Black Elephant</a></p>
  </div>
</div>

</body>
</html>
