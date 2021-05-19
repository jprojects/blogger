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

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

// Load admin language file
$lang = Factory::getLanguage();
$lang->load('com_blogger', JPATH_SITE);
$doc = Factory::getDocument();
$doc->addScript(Uri::base() . '/media/com_blogger/js/form.js');
$doc->addStylesheet(Uri::base() . '/media/com_blogger/css/form.css');

$user    = Factory::getUser();
$canEdit = BloggerHelpersBlogger::canUserEdit($this->item, $user);

?>

<div class="item-edit front-end-edit jpfblock">

	<div class="alert alert-warning">
		Pots escriure un article d'opinió en aquesta categoría, escriu un títol, un texte i afegeix dues imatges, revisa el contingut, una vegada enviat no el podràs modificar i serà revisat per un administrador abans de la seva publicació.
	</div>

	<form id="form-item" action="<?php echo Route::_('index.php?option=com_blogger&task=itemform.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
		<?php echo $this->form->getInput('id', 0); ?>

		<?php echo $this->form->getInput('catid', 9); ?>

		<?php echo $this->form->getInput('state', 0); ?>

		<?php echo $this->form->renderField('title'); ?>

		<?php echo $this->form->renderField('description'); ?>

		<?php echo $this->form->renderField('intro_img'); ?>

		<?php echo $this->form->renderField('full_img'); ?>

		<div class="control-group mt-2">
			<div class="controls">
				<button type="submit" class="validate btn btn-primary">
					<?php echo Text::_('JSUBMIT'); ?>
				</button>
			</div>
		</div>

		<input type="hidden" name="option" value="com_blogger"/>
		<input type="hidden" name="return" value="<?= base64_encode(JURI::root().'index.php?option=com_blogger&view=items&catid=13&Itemid=102'); ?>"/>
		<input type="hidden" name="task" value="itemform.save"/>
		<?php echo HTMLHelper::_('form.token'); ?>

	</form>
</div>
