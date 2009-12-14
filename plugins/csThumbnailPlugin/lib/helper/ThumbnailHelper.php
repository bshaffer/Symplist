<?php
/*
 * (c) 2008 Julian Stricker <julian@julianstricker.com>
 * (c) 2009 Joshua Pruitt <jpruitt@centresource.com>
 * (c) 2009 Brent Shaffer <bshaffer@centresource.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @author     Julian Stricker <julian@julianstricker.com>
 * @author     Joshua Pruitt <jpruitt@centresource.com>
 * @author     Brent Shaffer <bshaffer@centresource.com>
 */

/**
 * Builds Image Tag for Thumbnail Image
 *
 * Example:
 * <code>
 *  <?php echo thumbnail_tag('uploads/pictures/testimage.jpg', 100, 80, 'normal', array('class' => 'test-image')) ?>
 *  <?php echo thumbnail_tag('http://localhost/testimage.jpg', 100, 80, 'crop', array('style' => 'border: 1px solid #ff0000')) ?>
 * </code>
 *
 * @param string $img path on server to image
 * @param integer $maxx maximum width of image
 * @param integer $maxy maximum height of image  
 * @param integer $mode resize-mode (normal, crop or stretch)
 * @param array Other attributes for the tag. You can also pass string suitable for _parse_attributes()
 *
 * @return string An HTML img string
 *
 */
function thumbnail_tag($img, $maxx = '128', $maxy = '128', $mode = 'normal', $options = array())
{
  $options = _parse_attributes($options);
  $options['src']  = url_for('@csthumbnail') . '?img=' . $img . '&maxx=' . $maxx . '&maxy=' . $maxy . '&mode=' . $mode;
  
  return tag('img', $options);
}

function thumbnail_path($img, $maxx = '128', $maxy = '128', $mode = 'normal', $absolute = false)
{
  $qs = is_array($maxx) ? get_thumbnail_qs_from_array($maxx) : 'maxx=' . $maxx . '&maxy=' . $maxy . '&mode=' . $mode;
  $absolute = is_array($maxx) && isset($maxx['absolute']) ? $maxx['absolute'] : $absolute;

  return url_for('@csthumbnail', $absolute) . '?img=' . $img . '&'.$qs;
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
  // Maintains Backwards Compatibility - you can pass a string or an array with [profile] set to pull
  // from YAML, or you can just pass the options in array format
  if (is_array($options)) 
  {
    if (isset($options['profile'])) 
    {
      $profile = $options['profile'];
      unset($options['profile']);
    }
    else
    {
      $profile = '';
    }
  }
  else
  {
    $profile = $options;
    $options = array();
  }
  
  //If a profile is set, pull the profile from YAML.  Else, just use the options
  //Note: you can override anything set in a profile by passing the overriden argument in options
  if ($profile) 
  {
    $options = array_merge(getImageCacheProfile($profile), $options);
    
    // You can also set attributes in your imagecache profile
    if (isset($options['attributes'])) 
    {
      $attributes = array_merge($attributes, $options['attributes']);
    }
  }
  
  $attributes['src'] = thumbnail_path($img, $options);
  

  
  return tag('img', $attributes);
}
function getImageCacheProfile($profile)
{
  return sfConfig::get("app_imagecache_$profile");
}
