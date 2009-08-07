<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<?php foreach ($items as $item): ?>
		<url>
			<loc><?php echo url_for(SeoToolkit::xmlencode($item->url)) ?></loc>
			<changeFreq><?php echo $item['changeFreq'] ?></changeFreq>
			<priority><?php echo $item['priority'] ?></priority>
			<lastmod><?php echo $item['updated_at'] ?></lastmod>
		</url>
	<?php endforeach ?>
</urlset>