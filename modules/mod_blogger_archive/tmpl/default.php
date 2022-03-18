<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$catid = $params->get('catid');

?>

<style>
.accordion-button:not(.collapsed) {
    color: #b8001c;
    background-color: #fff;
}
</style>

<div class="accordion accordion-flush" id="bloggerArchive">
    <?php 
    $i = 0;
    foreach(BloggerArchiveHelper::getYears($catid) as $year) : ?>
    <?php if($year->any == 0) break; ?>
    <h3><?= $year->any; ?></h3>
    <?php foreach(BloggerArchiveHelper::getMonths($year->any, $catid) as $month) : ?>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i; ?>" aria-expanded="false" aria-controls="collapse<?= $i; ?>">
            <b><?= BloggerArchiveHelper::getMonthName($month->mes); ?></b>
        </button>
        </h2>
        <div id="collapse<?= $i; ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#bloggerArchive">
        <div class="accordion-body">
            <?php foreach(BloggerArchiveHelper::getList($year->any, $month->mes, $catid) as $item) : ?>
            <div class="py-2"><a href="<?= JURI::root(); ?>index.php?option=com_blogger&view=item&id=<?= $item->id; ?>&Itemid=<?= $params->get('itemid'); ?>"><?= $item->title; ?></a></div>
            <?php endforeach; ?>
        </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php 
    $i++;
    endforeach; ?>
</div>