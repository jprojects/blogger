<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_calendar
 *
 * @copyright   (C) 2005 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Module\BloggerCalendar\Site\Helper\BloggerCalendarHelper;

$lists = BloggerCalendarHelper::getList();

JFactory::getDocument()->addScript('https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js');
JFactory::getDocument()->addScript('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js');
JFactory::getDocument()->addStylesheet('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css');

require ModuleHelper::getLayoutPath('mod_blogger_calendar', $params->get('layout', 'default'));
