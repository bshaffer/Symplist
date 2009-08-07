<?php if (isset($this->params['css'])): ?> 
[?php use_stylesheet('<?php echo $this->params['css'] ?>', 'first') ?] 
<?php else: ?> 
[?php use_stylesheet('<?php echo sfConfig::get('sf_admin_module_web_dir').'/css/global.css' ?>', 'first') ?] 
[?php use_stylesheet('<?php echo sfConfig::get('sf_admin_module_web_dir').'/css/default.css' ?>', 'first') ?] 
[?php use_stylesheet('/csAdminGeneratorPlugin/css/cs-backend.css') ?] 
<?php endif; ?>

<?php if (isset($this->params['js'])): ?> 
	<?php foreach ($this->params['js'] as $js): ?>
		[?php use_javascript('<?php echo $js ?>', 'first') ?] 		
	<?php endforeach ?>
<?php else: ?> 
[?php use_javascript('/csAdminGeneratorPlugin/js/cs-backend.js', 'last') ?] 
<?php endif; ?>