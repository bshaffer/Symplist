<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormSelectDoubleList represents a multiple select displayed as a double list.
 *
 * This widget needs some JavaScript to work. So, you need to include the JavaScripts
 * files returned by the getJavaScripts() method.
 *
 * If you use symfony 1.2, it can be done automatically for you.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormSelectDoubleList.class.php 12412 2008-10-29 14:19:06Z fabien $
 */
class sfWidgetFormStarRating extends sfWidgetForm
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * choices:            An array of possible choices (required)
   *  * class:              The main class of the widget
   *  * class_select:       The class for the two select tags
   *  * label_unassociated: The label for unassociated
   *  * label_associated:   The label for associated
   *  * unassociate:        The HTML for the unassociate link
   *  * associate:          The HTML for the associate link
   *  * template:           The HTML template to use to render this widget
   *                        The available placeholders are:
   *                          * label_associated
   *                          * label_unassociated
   *                          * associate
   *                          * unassociate
   *                          * associated
   *                          * unassociated
   *                          * class
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('template', <<<EOF
<div id="%%id%%" class='rate_this'>
  <ul class="star_rating star_rating_editable" class="clearfix">
    <li class="one-star"><a id="1">1</a></li>
    <li class="two-stars"><a id="2">2</a></li>
    <li class="three-stars"><a id="3">3</a></li>
    <li class="four-stars"><a id="4">4</a></li>
    <li class="five-stars"><a id="5">5</a></li>
  </ul>
  %%input%%
  %%javascript%%
</div>
EOF
);
  }

  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $input = new sfWidgetFormInputHidden();
    return strtr($this->getOption('template'), array(
        '%%id%%'    => $name.'_star_rating',
        '%%input%%' => $input->render($name),
        '%%javascript%%' => $this->getJavascriptListeners($name)
      ));
  }

  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavascripts()
  {
    return array('/sfFormExtraPlugin/js/double_list.js');
  }
  
  public function getJavascriptListeners($name)
  {
    $id = $name.'_star_rating';
    $js = "<script type='text/javascript'>
      $('#$name li a').click(function(){ alert('CLICKED'); $('#$name').input.attr('value', this.value) });
    </script>";
    return $js;
  }
  
  // public function getStylesheets()
  // {
  //   return array('/sfFormExtraPlugin/css/jquery.autocompleter.css' => 'all');
  // }
  // 
  // /**
  //  * Gets the JavaScript paths associated with the widget.
  //  *
  //  * @return array An array of JavaScript paths
  //  */
  // public function getJavascripts()
  // {
  //   return array('/sfFormExtraPlugin/js/jquery.autocompleter.js');
  // }
}
