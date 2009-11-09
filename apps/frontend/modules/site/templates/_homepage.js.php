<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('#search-field').autocomplete('<?php echo url_for("@plugin_autocomplete_verbose") ?>', {
      delay:10,
			minChars:2,
			matchSubset:1,
			matchContains:1,
			cacheLength:1,
			autoFill:false,
			appendTo: '#search-results',
			noStyles: true,
			resultsClass: 'search-results-container',
			extraParams: {published_only: true},
			onFindValue: function(li){alert(li)}
    });
  });
  
  function filterAndRefresh (filtervalues) {
    var ac = $('#search-field')[0].autocompleter;
    ac.flushCache();
    ac.setExtraParams(filtervalues);
    ac.findValue();
  }
</script>