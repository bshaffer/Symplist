<?php

/**
* csMarkdown Actions
*/
class csMarkdownActions extends sfActions
{
  public function executePreview(sfWebRequest $request)
  {
    $field = $request->getParameter('markdown_field');
    $markdown = sfToolkit::getArrayValueForPath($request->getParameterHolder()->getAll(), $field, false);
    if ($markdown === false) 
    {
      throw new sfException("Cannot generate preview: markdown form field not found in request");
      
    }
    $parser = new MarkdownExtra_Parser();
    $this->markdown = $parser->transform($markdown);
    // return $this->renderText();
  }
}
