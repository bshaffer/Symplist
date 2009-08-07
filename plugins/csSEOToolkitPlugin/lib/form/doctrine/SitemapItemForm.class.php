<?php

/**
 * PluginSitemapItem form.
 *
 * @package    form
 * @subpackage SitemapItem
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class SitemapItemForm extends PluginSeoPageForm
{
	public function setUp()
	{
		parent::setUp();
		unset($this['created_at'], $this['updated_at']);
		$this->hideFields(array('title', 'description', 'keywords'));
		$this->widgetSchema['priority'] = new sfWidgetFormInput(array(), array('class' => 'value_display', 'onfocus' => 'blur(this);', 'id' => 'priority_slider'));
		$this->widgetSchema->setLabel('priority', false);
    $this->widgetSchema->setNameFormat('seo_page_sitemap_info[%s]');
	}
}