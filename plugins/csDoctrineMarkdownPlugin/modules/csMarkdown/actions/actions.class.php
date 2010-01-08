<?php

/**
* csMarkdown Actions
*/
class csMarkdownActions extends sfActions
{
  public function executePreview(sfWebRequest $request)
  {
    if (false === $markdown = $request->getParameter('markdown_value', false)) 
    {
      $field = $request->getParameter('markdown_field');
    
      $markdown = sfToolkit::getArrayValueForPath($request->getParameterHolder()->getAll(), $field, false);
      if ($markdown === false) 
      {
        throw new sfException("Cannot generate preview: markdown value or markdown form field not found in request");
      }
    }
    
    $parser = new MarkdownExtra_Parser();
    // $this->markdown = $parser->transform($markdown);
    $markdown = $markdown ? $markdown : '_No Markdown To Preview!_';
    return $this->renderText($parser->transform($markdown));
  }
}
