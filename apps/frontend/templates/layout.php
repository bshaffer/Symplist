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
      <h1 id="site-title">Symplist</h1>
      
      <?php include_navigation(array('id' => 'nav')) ?>
    </div>

    <div id="page" class="container_16 clearfix">      
      <div id="content-area" class="grid_16">
        <?php echo $sf_content ?>
      </div>
    </div>

    <div id="footer">
      <ul id="footer-nav">
        <?php include_navigation(array('menu' => 'Footer')) ?>
      </ul>
    </div>
  </body>
</html>
