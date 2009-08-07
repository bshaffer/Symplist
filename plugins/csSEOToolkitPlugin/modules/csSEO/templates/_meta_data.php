<?php include_http_metas() ?>
<!-- user-set / autogen metas -->
<?php if ($meta = get_component('csSEO', 'metas', array())): ?>
	<?php echo $meta ?>
<?php elseif($sf_response->getStatusCode() == 200): ?>
	<?php SeoToolkit::generateMetaData($sf_content, $sf_request) ?>
	<?php include_component('csSEO', 'metas', array()) ?>
<?php endif ?>