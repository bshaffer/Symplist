<?php

/**
 * keyword_encode
 * Adds keyword decorators to specified block
 * 
 * @param string $content - the HTML or text block to encode
 * @param string $selector - optional - limit HTML encoding to specified css selector
 * @return encoded HTML or text block
 * @author Brent Shaffer
 */
function keyword_encode($content, $selector = null)
{
  return SeoKeywordToolkit::getInstance()->parseBlock($content, $selector);
}

/**
 * include_seo_metas
 *
 * @param string $content - HTML block used to generate metas if none are available
 * @return meta tags
 * @author Brent Shaffer
 */
function include_seo_metas($content)
{
  echo get_component('csSEO', 'meta_data', array('sf_content' => $content));
}

function ie6_update()
{
  use_helper('Javascript');
  echo "<!--[if lte IE 6]>";
  javascript_tag();
  echo <<<EOF
    /*Load jQuery if not already loaded*/ if(typeof jQuery == 'undefined'){ document.write("<script type=\"text/javascript\"   src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js\"></"+"script>"); var __noconflict = true; } 
      var IE6UPDATE_OPTIONS = {
        icons_path: "http://static.ie6update.com/hosted/ie6update/images/"
      }
    </script>
    <script type="text/javascript" src="http://static.ie6update.com/hosted/ie6update/ie6update.js">
EOF;
  end_javascript_tag();
  echo "<![endif]-->";  
}

/**
 * seo_admin_bar
 *
 * @return includes an SEO menu bar in your project to edit meta and sitemap data
 * @author Brent Shaffer
 */
function seo_admin_bar()
{
  if(has_slot('seo_admin_bar'))
  {
    include_slot('seo_admin_bar');
  }
  else
  {
    include_component('csSEO', 'seo_admin_bar');
  }
}

function link_to_nofollow($name, $url, $options)
{
  return link_to($name, $url, array_merge(array('rel' => 'nofollow'), $options));
}
