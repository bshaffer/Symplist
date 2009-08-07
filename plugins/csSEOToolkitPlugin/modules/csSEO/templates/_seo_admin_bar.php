<?php if ($validated): ?>
<script>
  function hideMetaData(meta_form, e)
  {
    var sitemap_form = meta_form ? meta_form : document.getElementById('meta_form');
    var link = e ? e : document.getElementById('meta_link');
    sitemap_form.style.display = 'none'; 
    link.innerHTML = 'Edit Metadata'; 
  }
  function hideSitemapData(sitemap_form, e)
  {
    var sitemap_form = document.getElementById('sitemap_form');
    var link = document.getElementById('sitemap_link');
    sitemap_form.style.display = 'none'; 
    link.innerHTML = 'Edit Sitemap Data'; 
  }
  function toggleMetaData(e)
  {
    hideSitemapData();
    var meta_form = document.getElementById('meta_form');
    if(meta_form.style.display == 'block')
    {
      hideMetaData(meta_form, e)
    }
    else
    {
      meta_form.style.display = 'block'; 
      e.innerHTML = 'Hide Metadata';
    }
  }
  function toggleSitemapData(e)
  {
    hideMetaData();
    var sitemap_form = document.getElementById('sitemap_form');
    if(sitemap_form.style.display == 'block')
    {
      hideSitemapData(sitemap_form, e);
    }
    else
    {
      sitemap_form.style.display = 'block'; 
      e.innerHTML = 'Hide Sitemap Data';
    }
  }
  
</script>
<div id='seo_admin_bar'>
<ul id='seo_admin_buttons'>
  <?php if (isset($metaform)): ?>
  <li class='metadata'>
    <a id="meta_link" href="#" onclick="toggleMetaData(this)">Edit Metadata</a>
  </li>
  <?php endif ?>
  <?php if (isset($sitemapform)): ?>
  <li class='sitemap'>
    <a id="sitemap_link" href="#" onclick="toggleSitemapData(this)">Edit Sitemap Data</a>
  </li>
  <?php endif ?>
</ul>
<ul id='seo_admin_forms'>
  <?php if (isset($metaform)): ?>
  <li>
    <div id='meta_form' style='display:none'>
      <?php use_helper('Form') ?>
      <?php echo form_tag('@meta_data_edit') ?>
      <?php echo $metaform ?>
      <?php echo submit_tag('Submit') ?>  
      </form>
    </div>
  </li>
  <?php endif ?>
  <?php if (isset($sitemapform)): ?>
  <li>
    <div id='sitemap_form' style='display:none'>
      <?php use_helper('Form') ?>
      <?php echo form_tag('@sitemap_xml_edit') ?>
      <label style='clear:both;float:left'>Priority:</label>
      <div class="horizontal_track" >
        <div class="horizontal_slit" >&nbsp;</div>
        <div class="horizontal_slider"
          id="your_slider_id"
          style="left: <?php echo (100 * $sitemapform->getObject()->getPriority()) ?>px"
          onmousedown="slide(event,
          'horizontal', 100, 0, 1, 101,
          1, 'priority_slider');" >&nbsp;</div>
      </div>
      <?php echo $sitemapform['priority']->renderRow() ?>
      <?php echo $sitemapform['changeFreq']->renderRow() ?>
      <?php echo $sitemapform['exclude_from_sitemap'] ?>
      <?php echo $sitemapform['exclude_from_sitemap']->renderLabel() ?>
      <?php echo $sitemapform['id'] ?>
      <?php echo $sitemapform['url'] ?>
      <?php echo $sitemapform['title'] ?>     
      <?php echo $sitemapform['description'] ?>     
      <?php echo $sitemapform['keywords'] ?>      
      <?php echo submit_tag('Submit') ?>
      </form>
    </div>
  </li>
  <?php endif; ?>
</ul>
</div>
<?php endif ?>