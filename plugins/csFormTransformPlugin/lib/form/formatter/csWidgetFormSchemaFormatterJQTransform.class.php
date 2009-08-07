<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * 
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormSchemaFormatterTable.class.php 5995 2007-11-13 15:50:03Z fabien $
 */
class csWidgetFormSchemaFormatterJQTransform extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "<div class='row' id='%name%'>\n  %label%\n  %error%%field%%help%%hidden_fields%</div>\n",
    $errorRowFormat  = "<span class='error'>\n%errors%</span>\n",
    $helpFormat      = '<br />%help%',
    $decoratorFormat = "<div class='cs-form'>\n  %content%</div>",
    $rowName         = "";
  // Adds Schema Class to row decorator
  public function generateLabel($name, $attributes = array())
  {
    $this->rowName = $name;
    $labelName = $this->generateLabelName($name);

    if (false === $labelName)
    {
      return '';
    }

    if (!isset($attributes['for']))
    {
      $attributes['for'] = $this->widgetSchema->generateId($this->widgetSchema->generateName($name));
    }
    return $this->widgetSchema->renderContentTag('label', $labelName, $attributes);
  }
  public function formatRow($label, $field, $errors = array(), $help = '', $hiddenFields = null)
  {
    $name = $this->rowName;
    $this->rowName = "";
    return strtr($this->getRowFormat(), array(
      '%label%'         => $label,
      '%field%'         => $field,
      '%name%'          => $name,
      '%error%'         => $this->formatErrorsForRow($errors),
      '%help%'          => $this->formatHelp($help),
      '%hidden_fields%' => is_null($hiddenFields) ? '%hidden_fields%' : $hiddenFields,
    ));
  }
}
