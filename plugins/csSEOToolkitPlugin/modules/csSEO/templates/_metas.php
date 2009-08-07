<?php if ($page): ?>

	<?php foreach ($metas as $data): ?>
		<?php echo $data ?>
	<?php endforeach ?>
	<title><?php echo $title ?></title>
	
	<?php if ($include_admin_bar): ?>
		<?php slot('seo_admin_bar') ?>
			<?php include_component('csSEO', 'seo_admin_bar', array('page' => $page)) ?>
		<?php end_slot() ?>		
	<?php endif ?>

<?php endif ?>
