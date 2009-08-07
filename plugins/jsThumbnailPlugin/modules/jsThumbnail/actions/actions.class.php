<?php

/**
 * Thumbnail actions.
 *
 * @package    jsThumbnail
 * @subpackage jsThumbnailActions
 * @author     Julian Stricker julian {-at-] julianstricker.com, Jan Pietras mail {-at-] janpietras.nl 
 * @version
 */
function isAboveBasePath($path, $base)
{
  $path = realpath($path);
  $base = realpath($base);
  return 0 !== strncmp($path, $base, strlen($base));
}


class jsThumbnailActions extends sfActions
{
  public function preExecute()
  {
    $this->symfonyversion = explode('.', preg_replace('/\-\w+$/', '', SYMFONY_VERSION));

    $this->maxx = $this->getRequestParameter('maxx', 'inherit');
    $this->maxy = $this->getRequestParameter('maxy', 'inherit');
    $this->mode = $this->getRequestParameter('mode', 'normal');

    $this->imgname = $this->getRequestParameter('img');

    $this->namespace      = sfConfig::get('app_js_thumbnail_plugin_namespace', $this->getModuleName() . '_thumbnails');
    $this->file_cache_dir = sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . $this->namespace;
  }


  public function executeRemote()
  {
    $this->cachename = md5($this->imgname . $this->maxx . $this->maxy . $this->mode);

    // Create New Cache Object
    $cache = $this->newCache($this->file_cache_dir);

    // Is There a Cached Version?
    if ($cache->has($this->cachename))
    {
      // Display Cached Version
      $cached = $cache->get($this->cachename);

      if (!empty($cached))
      {
        // Output Image
        header("Content-Type: image/jpeg");
        echo unserialize($cached);
      }
    }
    else
    {
      // Fetch Image
      $image_file = $this->fetchImage($this->imgname);
      
      $this->info = getimagesize($image_file);
      
      // If maxx or maxy are set to inherit, uses the file's dimensions
      $this->checkXandY($this->info);
      
      // Generate Thumbnail
      $image = $this->generateThumbnail($image_file);
      
      // start a new output buffer
      ob_start();

      imagejpeg($image, NULL, 100);
      $ImageData = ob_get_contents();

      // stop this output buffer
      ob_end_clean();

      // Cache Image
      $this->setCached($cache, $ImageData);

      // Output Image
      header("Content-Type: image/jpeg");
      echo $ImageData;
      imagedestroy($image);
    }


    return sfView::NONE;
  }


  /**
   * Output thumbnail from cache (if exists) or create, cache and output thumbnail
   */
  public function executeThumbnail()
  {
    $imgbasedir = sfConfig::get('app_js_thumbnail_plugin_imgbasedir', sfConfig::get('sf_web_dir'));

    $this->forward404Unless(!isAboveBasePath($imgbasedir . DIRECTORY_SEPARATOR . $this->imgname, $imgbasedir));

    $this->imgname = $imgbasedir . $this->imgname;


    // Get Original File Info
    $this->info  = getimagesize($this->imgname);
    
    // If maxx or maxy are set to inherit, uses the file's dimensions
    $this->checkXandY($this->info);
    
    $ctime = filectime($this->imgname);

    $this->forward404Unless($this->info);


    // Create New Cache Object
    $cache = $this->newCache($this->file_cache_dir);

    $this->cachename = md5($this->imgname . $this->maxx . $this->maxy . $this->mode . $ctime);

    // Is There a Cached Version?
    if ($cache->has($this->cachename))
    {
      // Display Cached Version
      $cached = $cache->get($this->cachename);

      if (!empty($cached))
      {
        // Output Image
        header("Content-Type: image/jpeg");
        echo unserialize($cached);
      }
    }
    else
    {
      // Generate Thumbnail
      $image = $this->generateThumbnail($this->imgname);
      
      // start a new output buffer
      ob_start();

      imagejpeg($image, NULL, 100);
      $ImageData = ob_get_contents();

      // stop this output buffer
      ob_end_clean();

      // Cache Image
      $this->setCached($cache, $ImageData);

      // Output Image
      header("Content-Type: image/jpeg");
      echo $ImageData;
      imagedestroy($image);
    }

    return sfView::NONE;
  }


  private function newCache()
  {
    if ($this->symfonyversion[0] == '1')
    {
      switch (true)
      {
        case $this->symfonyversion[1] == '0':
          $cache = new sfFileCache($this->file_cache_dir);
          break;

        case $this->symfonyversion[1] == '1':
          $cache = new sfFileCache(array('cache_dir' => $this->file_cache_dir));
          break;

        case $this->symfonyversion[1] == '2':
          $cache = new sfFileCache(array('cache_dir' => $this->file_cache_dir));
          break;
      }
    
      return $cache;
    }
  }

  private function checkXandY($info)
  {
    // If maxx or maxy are set to inherit, uses the file's dimensions
    if ($this->maxx == 'inherit') 
    {
      $this->maxx = $info[0];
    }
    if ($this->maxy == 'inherit') 
    {
      $this->maxy = $info[1];
    }
  }
  private function setCached($cache, $ImageData)
  {
    if ($this->symfonyversion[0] == '1')
    {
      if ($this->symfonyversion[1] == '0')
      {
        $cache->set($this->cachename, self::DEFAULT_NAMESPACE, serialize($ImageData));
      }
      else
      {
        $cache->set($this->cachename, serialize($ImageData));
      }

      return true;
    }
  }
  
  
  private function generateThumbnail($image_name)
  {
    if ($this->info[2] == 1)
    {
      // Original is a GIF
      $oimage = imagecreatefromgif($image_name);
    }
    elseif ($this->info[2] == 2)
    {
      // Original is a JPG
      $oimage = imagecreatefromjpeg($image_name);
    }
    elseif ($this->info[2] == 3)
    {
      // Original is a PNG
      $oimage = imagecreatefrompng($image_name);
    }
    else
    {
      $this->forward404();
    }

    $ogrx = $this->info[0];
    $ogry = $this->info[1];

    switch ($this->mode)
    {
      case 'crop':
        if ($ogrx / $this->maxx > $ogry / $this->maxy)
        {
          // Breitformat
          $ngry = $this->maxy;
          $ngrx = ($ogrx * $this->maxy) / $ogry;
        }
        else
        {
          // Hochformat
          $ngrx = $this->maxx;
          $ngry = ($ogry * $this->maxx) / $ogrx;
        }
        break;
      
      default:
        if ($ogrx / $this->maxx > $ogry / $this->maxy)
        {
          // Breitformat
          $ngrx = $this->maxx;
          $ngry = ($ogry * $this->maxx) / $ogrx;
        }
        else
        {
          // Hochformat
          $ngry = $this->maxy;
          $ngrx = ($ogrx * $this->maxy) / $ogry;
        }
        break;
    }

    if ($this->info[2] == 2 || $this->info[2] == 3)
    {
      // PNG, JPG
      if ($this->mode == 'normal')
      {
        $image = imagecreatetruecolor($ngrx, $ngry);
      }
      else
      {
        $image = imagecreatetruecolor($this->maxx, $this->maxy);
      }
    }
    else
    {
      // GIF
      if ($this->mode == 'normal')
      {
        $image = imagecreate($ngrx, $ngry);
      }
      else
      {
        $image = imagecreate($this->maxx, $this->maxy);
      }
    }

    if ($this->info[2] == 3)
    {
      // PNG
      imagesavealpha($image, true);
      $farbe_body = imagecolorallocate($image, 255, 255, 255);
      $trans = imagecolortransparent($image, $farbe_body);
    }
    elseif ($this->info[2] == 1)
    {
      // GIF
      $farbe_body = imagecolorallocate($image, 255, 255, 255);
    }

    if ($this->mode == 'normal')
    {
      imagecopyresampled($image, $oimage, 0, 0, 0, 0, $ngrx, $ngry, $ogrx, $ogry);
    }
    elseif ($this->mode == 'crop')
    {
      imagecopyresampled($image, $oimage, - ($ngrx-$this->maxx) / 2, - ($ngry - $this->maxy) / 2, 0, 0, $ngrx, $ngry, $ogrx, $ogry);
    }
    elseif ($this->mode == 'stretch')
    {
      imagecopyresampled($image, $oimage, 0, 0, 0, 0, $this->maxx, $this->maxy, $ogrx, $ogry);
    }

    imagedestroy($oimage);
    
    return $image;
  }
  
  
  private function fetchImage($imageurl)
  {
    $ch = curl_init($imageurl);

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);

    $fp = fopen(DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'thumbnail_tmp.jpg', 'w');

    curl_setopt($ch, CURLOPT_FILE, $fp);

    $rawdata  = curl_exec($ch);

    curl_close($ch);
    fclose($fp);
    
    return DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'thumbnail_tmp.jpg';
  }
}

