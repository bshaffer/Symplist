<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('#search-field').autocomplete('<?php echo url_for("@plugin_autocomplete") ?>', {
      delay:10,
			minChars:2,
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			autoFill:false
    });
  });
</script>

<form action="<?php echo url_for('@plugin_search') ?>" class="grid_6 search-controls" id="search">
  <fieldset>
    <label for="search-field">Search for a plugin...</label>
    <input type="text" id="search-field" name="form[query]" autocomplete="off" onblur="if(this.value=='') this.value='Search Plugins...';" onfocus="if(this.value=='Search Plugins...') this.value='';"></input>
    <input type="image" src="<?php echo image_path('search-arrow.png') ?>">                
    <span id='indicator' style='display:none'><?php echo image_tag('ajax-loader.gif') ?></span>
  </fieldset>
</form>

<div id='ajax-search-results'></div>