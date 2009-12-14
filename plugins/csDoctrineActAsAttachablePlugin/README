# csActAsAttachablePlugin


##Introduction
This behavior permits to attach files to Doctrine objects.

##Features

 * add/remove attached files on an object / multiple object classes
 * validate uploaded files
 * validate according to file type
 * supports the module csAttachable that allows for ajax includes to upload and add files to a given class

Supported filetypes are the following:

 * image
 * audio
 * video
 * document
 * application
 * custom
 * other

The type "other" represents the base filetype, and is not validated by mimetype.  
Others can be set accordingly.

##Implementation

add the following code to your module's schema file:

	[yml]
	MyModel:
		actAs: [Attachable]

##csAttachable module

To use csAttachable module, add csAttachable to your settings.yml under "enabled_modules" and
add the following code to your template:
	
	[php]
	<?php include_component('csAttachable', 'attachments', array('form' => $form)) ?>

where $this->form represents the Doctrine Form for whatever class is acting as attachable.  It is important to note
the plugin does not work if the passed $this->form does not carry an object already saved to the database.
For this reason, the component should not be included unless the form object exists, for example:

	[php]
	<?php if ($form->getObject()->getId()): ?>
		<?php include_component('csAttachable', 'attachments', array('form' => $form)) ?>
	<?php endif; ?>

Also supported is the csAttachable attachments_list component, which receives an object variable and outputs 
a UL of attachments and their links.  This is handy for frontend development / archive reasons, and also
serves as an example for how attachments should be accessed / displayed.  Use the following code to access
this component:

	[php]
	<?php include_component('csAttachable', 'attachments_list', array('object' => $object)) ?>

Where $object is an item acting as Attachable

###Integrating with the backend

After completing the steps above, you will want to override the ___form.php__ partial in your backend module.  
Copy all of the code from the same generated module in your project cache.  Then, add the form code above after the </form> tag.
At the end, your ___form.php__ partial should look something like this:

	[php]
	<?php include_stylesheets_for_form($form) ?>
	<?php include_javascripts_for_form($form) ?>

	<div class="sf_admin_form">
	  <?php echo form_tag_for($form, '@mymodel') ?>
	    <?php echo $form->renderHiddenFields() ?>

	    <?php if ($form->hasGlobalErrors()): ?>
	      <?php echo $form->renderGlobalErrors() ?>
	    <?php endif; ?>

	    <?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
	      <?php include_partial('mymodel/form_fieldset', array('mymodel' => $mymodel, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
	    <?php endforeach; ?>

	    <?php include_partial('mymodel/form_actions', array('mymodel' => $mymodel, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
	  </form>
		<?php if ($form->getObject()->getId()): ?>
			<?php include_component('csAttachable', 'attachments', array('form' => $form)) ?>
		<?php endif; ?>
	</div>

Make sure your upload directory has proper permissions set.  If you need to debug, unhide the iframe to see the errors being thrown.
Also, be sure to publish your assets {{{ ./symfony plugin:publish-assets }}} to pull in the default attachable styles

##Other available methods include

* $model->getAttachments();  _Returns a doctrine collection object of related attachemnts_
*	$model->addAttachment($attachment) _where $attachment is an Attachment object_
*	$model->addAttachments($attachments) _where $attachments is an array or collection of Attachment objects._
*	$attachment->getObject();  _where $attachment is the attachment object returning its related model_

##Other Notes
Using the included partial, Attachment objects are hashed and placed in uploads/(model)/(file) where (model) is
the model acting as Attachable.  The Attachment object is then assigned the previous filename to it's [name] property.

**Array accessors are not yet available for ActAsAttachable.  For example, $model['Attachments'] will return an error.**

##To Do
* Add automated mimetype validation for specified types
* Allow relationships specified in schema.yml to validate for specific types
* Allow multiple attachable types in schema.yml (for example, UserProfile has Video and Image attachments for Video and Photo galleries)
* Have automatic mimetype/extension parsing to determine attachment's type