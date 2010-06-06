<h2>Create a Release for <?php echo $plugin['title'] ?></h2>

<?php echo $form->renderFormTag(url_for('@plugin_release_new?title='.$plugin['title'])) ?>
  <?php echo $form->renderHiddenFields() ?>
  <h3>Release</h3>
  <table>
    <?php echo $form['version']->renderRow() ?>
    <?php echo $form['summary']->renderRow() ?>
    <?php echo $form['stability']->renderRow() ?>
    <?php echo $form['api_versions_list']->renderRow() ?>
  </table>
  
  <h3>Dependencies</h3>
  <div>
    <a href="#" class="add" id="add-dependency-link">Add Dependency</a>
  </div>
  
  <table>
    <tr>
      <td>
        <?php echo $form['dependencies']->renderError() ?>
        <?php echo $form['dependencies'] ?>
      </td>
    </tr>
  </table>
    
  <div id="dependencies"></div>
  
  <h3>Package</h3>
  
  <table>
    <?php echo $packageForm ?>
  </table>
  
  <input type="submit" value="Submit"></input>
</form>

<script type="text/javascript">
// Default jQuery wrapper
$(document).ready(function() {

  // When the choice widget is changed
  $("#add-dependency-link").click(function() {
    
    $("#dependencies").addClass('indicator').html(' ');
    
    // url of the JSON
    var url = "/release/dependency";

    // Get the JSON for the selected item
    $("#dependencies").load(url, function() {
      $(this).removeClass('indicator');
    });
    
    return false;
  });
}); 
</script>