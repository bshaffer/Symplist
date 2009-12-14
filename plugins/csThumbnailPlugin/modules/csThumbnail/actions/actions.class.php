<?php

/**
 * Thumbnail actions.
 *
 * @package    csThumbnail
 * @subpackage csThumbnailActions
 * @author     Julian Stricker julian {-at-] julianstricker.com, Jan Pietras mail {-at-] janpietras.nl
 * @author     Joshua Pruitt jpruitt {-at] centresource.com, Brent Shaffer brent {-at] centresource.com
 */
class csThumbnailActions extends sfActions
{  
  public function preExecute()
  {
    define('GIF', 1);
    define('JPG', 2);
    define('PNG', 3);

    $namespace = sfConfig::get('app_cs_thumbnail_plugin_namespace', 'csThumbnailPlugin');

    $this->fileCacheDir   = sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . $namespace;
    $this->symfonyVersion = explode('.', preg_replace('/\-\w+$/', '', SYMFONY_VERSION));
    $this->defaultImage   = 'csThumbnailPlugin/images/not-found.png';
  }

  /**
   * Output thumbnail from cache (if exists) or create, cache and output thumbnail
   */
  public function executeThumbnail(sfWebRequest $request)
  {
    $imageName = $request->getParameter('img');
    $maxWidth  = $request->getParameter('maxx', '');
    $maxHeight = $request->getParameter('maxy', '');
    $cropMode  = $request->getParameter('mode', 'normal');

    // remote or local image?
    if (preg_match('/^http:\/\//', $imageName))
    {
      $remote        = true;
      $pathInfo      = pathinfo($imageName);
      $fileExtension = $pathInfo['extension'];
      $cacheName     = md5($imageName . $maxWidth . $maxHeight . $cropMode) . '.' . $pathInfo['extension'];
    }
    else
    {
      $remote = false;

      $imageBaseDirectory = sfConfig::get('app_js_thumbnail_plugin_imgbasedir', sfConfig::get('sf_web_dir'));

      $this->forward404Unless(!$this->isAboveBasePath($imageBaseDirectory . DIRECTORY_SEPARATOR . $imageName,
                                 $imageBaseDirectory));

      if (!$this->isAboveBasePath($imageBaseDirectory . DIRECTORY_SEPARATOR . $imageName, $imageBaseDirectory))
      {
        $imageName = $imageBaseDirectory . $imageName;
      }
      else
      {
        $imageName = $this->defaultImage;
      }

      $pathInfo      = pathinfo($imageName);
      $fileExtension = $pathInfo['extension'];
      $cTime         = filectime($imageName);
      $cacheName     = md5($imageName . $maxWidth . $maxHeight . $cropMode . $cTime) . '.' . $fileExtension;      
    }

    // instantiate a new cache
    $cache = $this->newCache($this->symfonyVersion, $this->fileCacheDir);

    // is there a cached version?
    if ($cache->has($cacheName))
    {
      $cached = $cache->get($cacheName);

      if (!empty($cached))
      {
        // output image
        header("Content-Type: image/" . $fileExtension);
        echo unserialize($cached);
      }
    }
    else
    {
      // fetch image if remote
      if (true === $remote)
      {
        $imageFile = $this->fetchImage($imageName);
      }
      else
      {
        $imageFile = $imageName;
      }

      $fileInfo = getimagesize($imageFile);

      // generate thumbnail
      $image = $this->generateThumbnail($imageFile, $maxWidth, $maxHeight, $cropMode, $fileInfo, $fileExtension);

      // cache and display image
      ob_start();

      if ('png' == $fileExtension)
      {
        imagepng($image);
      }
      elseif ('gif' == $fileExtension)
      {
        imagegif($image);
      }
      else
      {
        imagejpeg($image, null, 95);
      }

      $imageData = ob_get_contents();

      // stop this output buffer
      ob_end_clean();

      // cache image
      $this->setCached($cache, $cacheName, $this->symfonyVersion, $imageData);

      // output image
      header("Content-Type: image/" . $fileExtension);
      echo $imageData;
      imagedestroy($image);
    }

    return sfView::NONE;
  }

  private function newCache($symfonyVersion, $fileCacheDir)
  {
    if ('1' == $symfonyVersion[0])
    {
      if ('0' == $symfonyVersion[1])
      {
        $cache = new sfFileCache($fileCacheDir);
      }
      else
      {
        $cache = new sfFileCache(array('cache_dir' => $fileCacheDir));
      }

      return $cache;
    }
  }

  private function setCached($cache, $cacheName, $symfonyVersion, $imageData)
  {
    if ('1' == $symfonyVersion[0])
    {
      if ('0' == $symfonyVersion[1])
      {
        $cache->set($cacheName, self::DEFAULT_NAMESPACE, serialize($imageData));
      }
      else
      {
        $cache->set($cacheName, serialize($imageData));
      }

      return true;
    }
  }
  

  private function generateThumbnail($imageFile, $maxWidth, $maxHeight, $cropMode, $fileInfo)
  {
    if (GIF == $fileInfo[2])
    {
      $originalImage = imagecreatefromgif($imageFile);
    }
    elseif (JPG == $fileInfo[2])
    {
      $originalImage = imagecreatefromjpeg($imageFile);
    }
    elseif (PNG == $fileInfo[2])
    {
      $originalImage = imagecreatefrompng($imageFile);
    }
    else
    {
      $fileInfo       = getimagesize($this->defaultImage);
      $originalImage  = imagecreatefrompng($this->defaultImage);
    }

    $originalWidth  = $fileInfo[0];
    $originalHeight = $fileInfo[1];
    
      
    // If maxx or maxy are set to inherit, uses the file's dimensions
    if ($maxWidth == 'inherit' || $maxWidth == '') 
    {
      $maxWidth = $originalWidth;
    }
    if ($maxHeight == 'inherit' || $maxHeight == '') 
    {
      $maxHeight = $originalHeight;
    }
    
    // If the image is smaller than the size, return just the image (for normal mode only)
    if ($cropMode == 'normal' && $originalHeight <= $maxHeight && $originalWidth <= $maxWidth) 
    {
      return $originalImage;
    }
    
    switch ($cropMode)
    {
      case 'crop':
        if ($originalWidth / $maxWidth > $originalHeight / $maxHeight)
        {
          // landscape
          $newHeight = $maxHeight;
          $newWidth  = round(($originalWidth * $maxHeight) / $originalHeight);
        }
        else
        {
          // portrait
          $newWidth  = $maxWidth;
          $newHeight = round(($originalHeight * $maxWidth) / $originalWidth);
        }
        break;

      default:
        if ($originalWidth / $maxWidth > $originalHeight / $maxHeight)
        {
          // landscape
          $newWidth  = $maxWidth;
          $newHeight = round(($originalHeight * $maxWidth) / $originalWidth);
        }
        else
        {
          // portrait
          $newHeight = $maxHeight;
          $newWidth  = round(($originalWidth * $maxHeight) / $originalHeight);
        }
        break;
    }

    if (PNG == $fileInfo[2] || JPG == $fileInfo[2])
    {
      if ('normal' == $cropMode)
      {
        $image = imagecreatetruecolor($newWidth, $newHeight);
      }
      else
      {
        $image = imagecreatetruecolor($maxWidth, $maxHeight);
      }
    }
    else
    {
      if ('normal' == $cropMode)
      {
        $image = imagecreate($newWidth, $newHeight);
      }
      else
      {
        $image = imagecreate($maxWidth, $maxHeight);
      }
    }

    if (PNG == $fileInfo[2] || GIF == $fileInfo[2])
    {
      imagealphablending($image, false);
      imagesavealpha($image, true);
      $bodyColor = imagecolorallocate($image, 255, 255, 255);
      $trans     = imagecolortransparent($image, $bodyColor);
    }

    if ('normal' == $cropMode)
    {
      imagecopyresampled($image, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
    }
    elseif ('crop' == $cropMode)
    {
      imagecopyresampled($image, $originalImage, - ($newWidth - $maxWidth) / 2, - ($newHeight - $maxHeight) / 2, 0, 0,
                           $newWidth, $newHeight, $originalWidth, $originalHeight);
    }
    elseif ('stretch' == $cropMode)
    {
      imagecopyresampled($image, $originalImage, 0, 0, 0, 0, $maxWidth, $maxHeight, $originalWidth, $originalHeight);
    }

    imagedestroy($originalImage);

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

  private function isAboveBasePath($path, $base)
  {
    $path = realpath($path);
    $base = realpath($base);

    return 0 !== strncmp($path, $base, strlen($base));
  }
}
