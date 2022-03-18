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
use \Joomla\CMS\Layout\LayoutHelper;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');

$user       = Factory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_blogger') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'itemform.xml');
$canEdit    = $user->authorise('core.edit', 'com_blogger') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'itemform.xml');
$canCheckin = $user->authorise('core.manage', 'com_blogger');
$canChange  = $user->authorise('core.edit.state', 'com_blogger');
$canDelete  = $user->authorise('core.delete', 'com_blogger');

$model      = $this->getModel();

// Import CSS
$document = Factory::getDocument();
$document->addStyleSheet(Uri::root() . 'media/com_blogger/css/list.css');
?>

<div class="blogger-list row jpfblock">
<?php if(count($this->items) > 0) : ?>
<?php foreach ($this->items as $item) : ?>

	<div class="col-12 col-md-4 mb-3">
		<div class="card h-100">
			<div style="background-image:url('<?= JURI::root().$item->intro_img; ?>');max-height:150px;height:150px;width:100%;background-repeat: no-repeat;background-position: center center;background-size: cover;" class="card-img-top">
			</div>
			<div class="card-body">
				<h5 class="card-title"><?= $item->title; ?></h5>
				<?php if($this->params->get('read_time') == 1) : ?>
				<div><small><?= JText::sprintf('COM_BLOGGER_READ_TIME', $model->calcTimeRead($item->description)); ?></small></div>
				<?php endif; ?>
				<?php if($item->publish_up != '0000-00-00 00:00:00') : ?>
				<div><small><?= JText::sprintf('COM_BLOGGER_PUBLISH_UP', date('d-m-Y', strtotime($item->publish_up)), $item->author); ?></small></div>
				<?php endif; ?>
				<?php if($item->isEvent == 1 && $item->event_loc != '') : ?>
				<div><small><?= JText::sprintf('COM_BLOGGER_EVENT_LOCATION', $item->event_loc); ?></small></div>
				<?php endif; ?>
				<p class="card-text"><?= $model->getIntro($item->description); ?></p>
				<a href="index.php?option=com_blogger&view=item&id=<?= $item->id; ?>" class="btn btn-primary"><?= JText::_('COM_BLOGGER_READ_MORE'); ?></a>
			</div>
		</div>
	</div>
<?php endforeach; ?>
<div class="paginacion">
	<?= $this->pagination->getPagesLinks(); ?>
</div>
<?php else : ?>
	<div class="col-12"><?= JText::_('COM_BLOGGER_NO_ITEMS'); ?></div>
<?php endif; ?>
</div>		