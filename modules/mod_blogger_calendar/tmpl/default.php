<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<style>
.datepicker-inline, .table-condensed { width: 100%; }
td.active { background-color: #b8001c !important; background-image: unset !important; }
</style>

<div class="mod-articlescalendar archive-module mod-list">
    <div id="moddatepicker"></div>
</div>

<script>
$.fn.datepicker.dates['ca'] = {
    days: ["Diumenge", "Dilluns", "Dimarts", "Dimecres", "Dijous", "Divendres", "Dissabte"],
    daysShort: ["Dg", "Dl", "Dm", "Dc", "Dj", "Dv", "Ds"],
    daysMin: ["Dg", "Dl", "Dm", "Dc", "Dj", "Dv", "Ds"],
    months: ["Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Septembre", "Octubre", "Novembre", "Desembre"],
    monthsShort: ["Gen", "Feb", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Sept", "Oct", "Nov", "Des"],
    today: "Avui",
    clear: "Nateja",
    format: "yyyy/mm/dd",
    titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
    weekStart: 1
};
$('#moddatepicker').datepicker({'weekStart':1, 'language': 'ca'});
$('#moddatepicker').datepicker('setDates', [
    <?php foreach($lists as $list) : ?>
    <?php $parts = explode('-', $list); ?>
    new Date(<?= $parts[2]; ?>, <?= $parts[1]; ?>, <?= $parts[0]; ?>), 
    <?php endforeach; ?>
]);
$('.day').click(function(e) {
    e.preventDefault();
    var timestamp = $(this).attr('data-date');
    var fecha = timestamp / 1000;
    document.location.href = '<?= JURI::root(); ?>index.php?option=com_blogger&view=items&catid=<?= $params->get('catid'); ?>&Itemid=<?= $params->get('itemid'); ?>&date='+fecha;
});
</script>