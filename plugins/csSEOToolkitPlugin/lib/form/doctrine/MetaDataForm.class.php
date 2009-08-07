<?php

/**
 * PluginMetaData form.
 *
 * @package    form
 * @subpackage MetaData
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class MetaDataForm extends PluginSeoPageForm
{
	public function setUp()
	{
		parent::setUp();
		unset($this['created_at'], $this['updated_at']);
		$this->hideFields(array('priority', 'changeFreq', 'exclude_from_sitemap'));
    $this->widgetSchema->setNameFormat('seo_page_meta_data[%s]');
	}
}