<?php

$css = '/rateablePlugin/css/rateable.css';
use_stylesheet($css);

$javascript = '/rateablePlugin/js/rateable.js';
use_javascript($javascript);

use_helper('Javascript');
// $response->addStylesheet($css);

/**
 * Return the HTML code for a unordered list showing rating stars
 * 
 * @param  BaseObject  $object  Doctrine object instance
 * @param  array       $options        Array of HTML options to apply on the HTML list
 * @throws csDoctrineActAsRateablePluginException
 * @return string
 **/

function getStarRating()
{

} 

function getThumbRating()
{

} 

function getTenBasedRating()
{

}