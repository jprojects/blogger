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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_blogger');

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_blogger'))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
$txt = str_replace('<hr id="system-readmore" />', '', $this->item->description);
$txt = JHtml::_('content.prepare', $txt);
?>

<div class="blogger-item row jpfblock">

	<h2><?php echo $this->item->title; ?></h2>
	<?php if($this->item->publish_up != '0000-00-00 00:00:00') : ?>
	<div><small><?= JText::sprintf('COM_BLOGGER_PUBLISH_UP', date('d-m-Y', strtotime($this->item->publish_up)), $this->item->author); ?></small></div>
	<?php endif; ?>
	
	<div class="col-12 col-md-5 mt-3">
		<img src="<?= JURI::root().$this->item->full_img; ?>" alt="..." class="img-fluid mb-3">
	</div>
	<div class="col-12 col-md-7 mt-3">
		<?= $txt; ?>
		<div class="blogger-social py-5">
			<a class="btn btn-primary rounded-circle" style="width:40px;height:40px;" href="http://www.facebook.com/sharer.php?u=<?= JUri::current(); ?>&t=<?= $this->item->title; ?>" target="_blank"><i title="Facebook" class="fab fa-facebook-f"></i></a>
			<a class="btn btn-primary rounded-circle" style="width:40px;height:40px;" href="http://twitter.com/share?text=<?= $this->item->title; ?>&url=<?= JUri::current(); ?>" target="_blank"><i title="Twitter" class="fab fa-twitter"></i></a>
			<a class="btn btn-primary rounded-circle" style="width:40px;height:40px;" href="https://www.linkedin.com/shareArticle?mini=true&url=<?= JUri::current(); ?>&title=<?= $this->item->title; ?>&summary=%20&source=LinkedIn" target="_blank"><i title="Twitter" class="fab fa-linkedin-in"></i></a>
		</div>
	</div>

</div>