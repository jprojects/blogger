<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Blogger
 * @author     aficat <kim@aficat.com>
 * @copyright  2021 aficat
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Uri\Uri;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Language\Text;


HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');

?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	js('input:hidden.catid').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('catidhidden')){
			js('#jform_catid option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_catid").trigger("liszt:updated");
	});

	Joomla.submitbutton = function (task) {
		if (task == 'item.cancel') {
			Joomla.submitform(task, document.getElementById('item-form'));
		}
		else {
			
			if (task != 'item.cancel' && document.formvalidator.isValid(document.id('item-form'))) {
				
				Joomla.submitform(task, document.getElementById('item-form'));
			}
			else {
				alert('<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_blogger&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="item-form" class="form-validate form-horizontal">

	
	<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'item')); ?>
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'item', JText::_('COM_BLOGGER_TAB_ITEM', true)); ?>
	<div class="row-fluid">
		<div class="span10 form-horizontal">
			<fieldset class="adminform">
				<legend><?php echo JText::_('COM_BLOGGER_FIELDSET_ITEM'); ?></legend>
				<?php echo $this->form->renderField('state'); ?>
				<?php echo $this->form->renderField('catid'); ?>
			<?php
				foreach((array)$this->item->catid as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="catid" name="jform[catidhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>
				<?php echo $this->form->renderField('title'); ?>
				<?php echo $this->form->renderField('publish_up'); ?>
				<?php echo $this->form->renderField('description'); ?>
				<?php echo $this->form->renderField('intro_img'); ?>
				<?php echo $this->form->renderField('full_img'); ?>
				<?php echo $this->form->renderField('author'); ?>
				<?php echo $this->form->renderField('tags'); ?>
				<?php echo $this->form->renderField('language'); ?>
				<?php echo $this->form->renderField('isEvent'); ?>
				<?php echo $this->form->renderField('event_start'); ?>
				<?php echo $this->form->renderField('event_end'); ?>
				<?php echo $this->form->renderField('event_loc'); ?>
				<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
				<?php endif; ?>
			</fieldset>
		</div>
	</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />
	<?php echo $this->form->renderField('created_by'); ?>
	<?php echo $this->form->renderField('modified_by'); ?>

	

	<?php $this->ignore_fieldsets = array('general', 'info', 'detail', 'jmetadata', 'item_associations', 'accesscontrol'); ?>
	<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>
	
	<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	<input type="hidden" name="task" value=""/>
	<?php echo JHtml::_('form.token'); ?>

</form>
