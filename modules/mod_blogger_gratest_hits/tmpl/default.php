<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_blogger_gratest_hits
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<ul class="mod-bloggerlatest latestnews mod-list list-group list-group-flush no-border">
<?php if(count($list) > 0) : ?>
<?php foreach ($list as $item) : ?>
	<li class="list-group-item px-0 mx-0" itemscope itemtype="https://schema.org/Article">
		<a href="index.php?option=com_blogger&view=item&id=<?php echo $item->id; ?>&Itemid=<?= $params->get('itemid'); ?>" itemprop="url">
			<span itemprop="name">
				<?php echo $item->title; ?>
			</span>
		</a>
	</li>
<?php endforeach; ?>
<?php else : ?>
No hi han articles en aquesta categoria.
<?php endif; ?>
</ul>
<?php if(count($list) > 0) : ?>
<div class="text-center mt-4">
	<a href="index.php?option=com_blogger&view=items&catid=<?= $params->get('catid'); ?>&Itemid=<?= $params->get('itemid'); ?>" class="w-100 blogger-all">Veure totes</a>
</div>
<?php endif; ?>
