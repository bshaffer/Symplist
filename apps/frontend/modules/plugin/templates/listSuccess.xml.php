<plugins>
<?php foreach ($pager->getResults() as $plugin): ?>
  <plugin id="<?php echo $plugin->id ?>">
    <name><?php echo $plugin['title'] ?></name>
    <summary><?php echo $plugin['summary'] ?></summary>
    <description>
      <![CDATA[
        <?php echo $plugin['description'] ?>
      ]]>
    </description>
    <image><?php echo $plugin['image'] ?></image>
    <link><?php echo $plugin['homepage'] ?></link>
    <stability><?php echo $plugin['stability'] ?></stability>
    <last_updated_at><?php echo $plugin['updated_at'] ?></last_updated_at>
    <authors>
      <?php foreach ($plugin['Authors'] as $author): ?>
        <author id="<?php echo $author['id'] ?>">
          <name><?php echo $author ?></name>
        </author>
      <?php endforeach ?>
    </authors>
    <tags>
      <?php foreach ($plugin['Tags'] as $tag): ?>
        <tag id="<?php echo $tag['id'] ?>">
          <name><?php echo $tag ?></name>
        </tag>
      <?php endforeach ?>
    </tags>
    <symplist_index><?php //echo $plugin['symplist_index'] ?></symplist_index>
    <rating><?php echo $plugin['rating'] ?></rating>
    <releases>
      <?php foreach ($plugin['Releases'] as $release): ?>
        <release id="<?php echo $release['id'] ?>">
          <name><?php echo $release ?></name>
        </release>
      <?php endforeach ?>
    </releases>
    <api_versions>
      <?php foreach ($plugin->getApiVersions() as $key => $value): ?>
        
      <?php endforeach ?>
    </api_versions>
  </plugin>
<?php endforeach ?>
</plugins>