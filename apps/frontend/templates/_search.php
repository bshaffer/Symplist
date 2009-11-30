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

<?php use_helper('Form') ?>
<?php echo form_tag('@plugin_search', array('class' => 'grid_6 search-controls', 'id' => 'search')) ?>
  <fieldset>
    <label for="search-field">Search for a plugin...</label>
    <?php echo input_tag('form[query]', '', 
              array('id' => 'search-field', 
                    'autocomplete' => 'off',
                    'onblur' => "if(this.value=='') this.value='Search Plugins...';", 'onfocus' => "if(this.value=='Search Plugins...') this.value='';")) ?>
                    
    <?php echo input_tag('', '', array('type' => 'image', 'src' => image_path('search-arrow.png'))) ?>
    <span id='indicator' style='display:none'><?php echo image_tag('ajax-loader.gif') ?></span>
  </fieldset>
</form>

<div id='ajax-search-results'></div>