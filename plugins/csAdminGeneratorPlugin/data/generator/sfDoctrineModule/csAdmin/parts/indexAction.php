  public function executeIndex(sfWebRequest $request)
  {
    // sorting
    if ($request->getParameter('sort'))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }
    elseif (array_key_exists("Doctrine_Template_Sortable", Doctrine::getTable('<?php echo $this->getModelClass() ?>')->getTemplates())){
      $this->setSort(array('position', 'ASC'));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();
  }
