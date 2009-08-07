<?php
/*
 * (c) 2008 Julian Stricker <julian@julianstricker.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @author     Julian Stricker <julian@julianstricker.com>
 * @version    SVN: $Id$
 */



/**
 * Builds Image Tag for Thumbnail Image
 *
 * Example:
 * <code>
 *  <?php echo thumbnail_tag('uploads/pictures/testimage.jpg',100, 80, normal array('style' => 'border: 1px solid #ff0000')) ?>
 * </code>
 *
 * @param string IMG path on server to image
 * @param integer MAXX maximum width of image
 * @param integer MAXY maximum height of image  
 * @param integer MODE resize-mode (normal, crop or stretch)
 * @param array Other attributes for the tag. You can also pass string suitable for _parse_attributes()
 *
 * @return string An HTML img string
 *
 */
function thumbnail_tag($img, $maxx = '128', $maxy = '128', $mode = 'normal', $options = array())
{
  $options = _parse_attributes($options);
  $options['src']  = url_for('@jsthumbnail') . '?img=' . $img . '&maxx=' . $maxx . '&maxy=' . $maxy . '&mode=' . $mode;
	
  return tag('img', $options);
}


function thumbnail_remote_tag($img, $maxx = '128', $maxy = '128', $mode = 'normal', $options = array())
{
  $options = _parse_attributes($options);
  $options['src'] = url_for('@jsthumbnail_remote') . '?img=' . $img . '&maxx=' . $maxx . '&maxy=' . $maxy . '&mode=' . $mode;

  return tag('img', $options);
}


function thumbnail_path($img, $maxx = '128', $maxy = '128', $mode = 'normal', $absolute = false)
{
	$qs = is_array($maxx) ? get_thumbnail_qs_from_array($maxx) : 'maxx=' . $maxx . '&maxy=' . $maxy . '&mode=' . $mode;
	$absolute = is_array($maxx) && isset($maxx['absolute']) ? $maxx['absolute'] : $absolute;
	return url_for('@jsthumbnail', $absolute) . '?img=' . $img . '&'.$qs;
}


function thumbnail_remote_path($img, $maxx = '128', $maxy = '128', $mode = 'normal')
{
	return url_for('@jsthumbnail_remote') . '?img=' . $img . '&maxx=' . $maxx . '&maxy=' . $maxy . '&mode=' . $mode;
}

function get_thumbnail_qs_from_array($options)
{
  $qs = array();
	$qs[] = isset($options['maxx']) ? 'maxx='.$options['maxx'] : '';
	$qs[] = isset($options['maxy']) ? 'maxy='.$options['maxy'] : '';
	$qs[] = isset($options['mode']) ? 'mode='.$options['mode'] : '';
	return implode('&', array_filter($qs));
}
// Allows parameter from array (for use with app.yml imagecache presets)
function thumbnail($img, $options = array(), $attributes = array())
{
	$options = is_array($options) ? $options : sfConfig::get("app_imagecache_$options");
	$options['src'] = thumbnail_path($img, $options);
	unset($options['maxx'], $options['maxy'], $options['mode']);
	$options = array_merge($options, $attributes);
  return tag('img', $options);
}