<?php
/**
 * Output a List of Attachments
 *
 * @param string $attachments 
 * @return $result
 * @author Joshua Pruitt
 */
function attachments_list($attachments)
{
  $icons = array('document'           => 'book.png',
                 'other'              => 'folder.png',
                 'default'            => 'folder.png',
                 'image'              => 'image.png',
                 'jpg'                => 'image.png',
                 'png'                => 'image.png',
                 'gif'                => 'image.png',
                 'doc'                => 'word.png',
                 'docx'               => 'word.png',
                 'pdf'                => 'pdf.png');
  
  if ($attachments->count() > 0)
  {
    $result = '<ul>';

    foreach ($attachments as $attachment)
    {
      $filesize = ($attachment['size'] > 1024 ? round($attachment['size'] / 1024) . ' MB' : $attachment['size'] . ' KB');
      $image = isset($icons[$attachment['content_type']]) ? $icons[$attachment['content_type']] : $icons['default'];
      $result .= '<li>'
              .  image_tag('/csDoctrineActAsAttachablePlugin/images/attachable/icons/' . $image,
                           array('align' => 'absmiddle',
                                 'style' => 'margin-right: 5px;'))
              .  '<strong>' . link_to($attachment['title'], '/'.$attachment['upload_path']) . '</strong>'
              .  '<br />'
              .  '<span class="file-size" style="font-style: italic;">' . $attachment['content_type'] . ' - ' . $filesize . '</span>'
              .  '</li>';
    }

    $result .= '</ul>';

    return $result;
  }

  return false;
}

function jq_attachments_admin($form)
{
  include_component('csAttachable', 'attachments', array('form' => $form, 'javascriptHelper' => 'jQuery'));
}

function attachments_admin($form)
{
  include_component('csAttachable', 'attachments', array('form' => $form, 'javascriptHelper' => 'Javascript'));  
}