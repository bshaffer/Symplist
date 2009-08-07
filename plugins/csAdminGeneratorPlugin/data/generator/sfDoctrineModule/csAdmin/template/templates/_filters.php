[?php include_stylesheets_for_form($form) ?]
[?php include_javascripts_for_form($form) ?]

<div class="sf_admin_filter">
  [?php if ($form->hasGlobalErrors()): ?]
    [?php echo $form->renderGlobalErrors() ?]
  [?php endif; ?]

  <form class="sf-filter" action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter')) ?]" method="post">
            [?php echo $form->renderHiddenFields() ?]
        <ul id="sf-filter-list" class="clearfix">
          [?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?]
          [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?]
          <li class="grid_3">
            [?php include_partial('<?php echo $this->getModuleName() ?>/filters_field', array(
              'name'       => $name,
              'attributes' => $field->getConfig('attributes', array()),
              'label'      => $field->getConfig('label'),
              'help'       => $field->getConfig('help'),
              'form'       => $form,
              'field'      => $field,
              'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_filter_field_'.$name,
            )) ?]
            </li>
          [?php endforeach; ?]
        </ul>
        <div class="reset-link">[?php echo link_to(__('Reset', array(), 'sf_admin'), '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post')) ?]</div>
        <input type="submit" value="[?php echo __('Filter', array(), 'sf_admin') ?]" />
        
  </form>
</div>
