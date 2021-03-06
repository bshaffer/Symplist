<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>

<body class="home">
<?php use_helper('Navigation') ?>

<!-- Begin Header -->
<div id="header" class="clearfix">
  <div class="container_12">
    
    <!-- Begin Navigation -->
    <?php include_navigation(array('id' => 'nav-main')) ?>
    <?php include_partial('site/secondary_nav', array()) ?>
    <!-- End Navigation -->
    
    <h1 class="grid_6"><?php echo link_to('sympLIST', '@homepage') ?></h1>
    
    <p id="intro" class="grid_6">sympLIST is the place for finding high quality Symfony plugins
    and developers for your web apps. <a href="<?php echo url_for('@about') ?>">LEARN MORE &raquo;</a></p>
    
  </div>
</div>
<!-- End Header -->

<!-- Begin Homepage Search and Featured -->
<div id="search-featured" class="clearfix">
  <div class="container_12">
    <?php echo form_tag('@plugin_search', array('id' => 'search')) ?>
      <fieldset>
        <label for="search-field">Type &amp; search for a plugin...</label>
        <input name="q" type="text" id="search-field" autocomplete="off"></input>
        <span id='indicator' style='display:none'><?php echo image_tag('ajax-loader.gif') ?></span>
      </fieldset>
    </form>
    
    <script type='text/javascript'>
      $(document).ready(function(){
        var timeout = null;
        $('#search-field').keyup(function(e){
          switch(e.keyCode) {
            case 9:  // tab
            case 13: // return
              break;
            default:
              if(timeout) clearTimeout(timeout);
              timeout = setTimeout('load_autocomplete("'+this.value+'")', 400);
          }
        })
      });
      function load_autocomplete(val){
        $('#search-results').load("<?php echo url_for('@plugin_autocomplete_home') ?>", { q: val }, function() { $('.rating input[type=radio]').rating()});
      }
    </script>
  
    <!-- Search Results -->
    <div id="search-results" class="grid_12">

    </div>
    <!-- End Search Results -->
    
    <!-- Begin Homepage Featured -->
    <div class="grid_12">
      <h3>Featured Plugins</h3>

       <?php echo $sf_content ?>
    </div>
    <!-- End Homepage Featured -->
    
  </div>
</div>
<!-- End Homepage Search and Featured -->

<div class="stats container_12 clearfix">
  <div class="grid_12">
    <?php include_slot('bottom_row') ?>
  </div>
</div>

<?php include_partial('global/footer') ?>

</body>
</html>