<h1>Symfony Plugins</h1>

<p>
  Symplist currently has <?php echo $count ?> plugins registered.  Come be a part of the Symfony development community! 
</p>

  <h2>Search</h2>
  <?php //include_partial('plugin/auto_complete_search', array()) ?>
<?php $sf_response->addJavascript('jquery') ?>
<?php $sf_response->addJavascript('jquery.autocomplete.home.js') ?>
<?php $sf_response->addStylesheet('jquery.autocomplete.css') ?>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('#plugin_search_input').autocomplete('<?php echo url_for("@plugin_autocomplete_verbose") ?>', {
      delay:10,
			minChars:2,
			matchSubset:1,
			matchContains:1,
			cacheLength:1,
			autoFill:false,
			appendTo: '#homepage-search-results',
			noStyles: true,
			resultsClass: 'search-results-container',
			extraParams: {published_only: true},
			onFindValue: function(li){alert(li)}
    });
  });
</script>
<div class='plugin_search_form'>
<?php use_helper('Form') ?>
<?php echo form_tag('@plugin_search', array('class' => 'search-controls')) ?>
  <?php echo input_tag('q', 'Search Plugins...', array('id' => 'plugin_search_input', 'onblur' => "if(this.value=='') this.value='Search Plugins...';", 'onfocus' => "if(this.value=='Search Plugins...') this.value='';")) ?>
  <?php //echo submit_tag('Go', array('id' => 'plugin_search_button')) ?>
  <?php echo checkbox_tag('published_only', null, true, array('onclick' => "$('#plugin_search_input')[0].autocompleter.flushCache();$('#plugin_search_input')[0].autocompleter.setExtraParams({published_only: $(this)[0].checked});$('#plugin_search_input')[0].autocompleter.findValue();")) ?> Published Plugins Only
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
