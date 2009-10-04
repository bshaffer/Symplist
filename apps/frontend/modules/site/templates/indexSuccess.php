<?php use_helper('Form') ?>
<h1>Symfony Plugins</h1>

<p>
  Symplist currently has <?php echo $count ?> plugins registered.  Come be a part of the Symfony development community! 
</p>

<h2>Search</h2>

<?php include_partial('site/homepage.js') ?>

<div class='plugin_search_form'>
<?php echo form_tag('@plugin_search', array('class' => 'search-controls')) ?>
  <?php echo input_tag('q', 'Search Plugins...', array('id' => 'plugin_search_input', 'onblur' => "if(this.value=='') this.value='Search Plugins...';", 'onfocus' => "if(this.value=='Search Plugins...') this.value='';")) ?>
  <?php echo select_tag('version', options_for_select(array('1.2' => '1.2', '1.1', '1.0', 'all'), '1.2'), array('onchange' => "filterAndRefresh({ version: $(this)[0].value })") ) ?>
  <?php echo checkbox_tag('published_only', null, true, array('onclick' => "filterAndRefresh('published_only', $(this)[0].checked);")) ?> Published Plugins Only

  <span id='indicator' style='display:none'><?php echo image_tag('ajax-loader.gif') ?></span>
</form>

<div id='homepage-search-results'></div>
</div>

<?php slot('right_column') ?>

<div id='highest-ranking' class='plugin-block'>
  <?php include_component('plugin', 'highest_ranking', array('limit' => 5)) ?>
</div>

<div id='recently-added' class='plugin-block'>
  <?php include_component('plugin', 'recently_added', array('limit' => 5)) ?>
</div>


<div id='most-votes' class='plugin-block'>
  <?php include_component('plugin', 'most_votes', array('limit' => 5)) ?>
</div>

<?php end_slot() ?>
