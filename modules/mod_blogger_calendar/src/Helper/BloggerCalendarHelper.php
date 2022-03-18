<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Module\BloggerCalendar\Site\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Database\ParameterType;

/**
 * Helper for mod_articles_archive
 *
 * @since  1.5
 */
class BloggerCalendarHelper
{
	/**
	 * Retrieve list of archived articles
	 *
	 * @param   \Joomla\Registry\Registry  &$params  module parameters
	 *
	 * @return  array
	 *
	 * @since   1.5
	 */
	public static function getList()
	{
		$app       = Factory::getApplication();
		$db        = Factory::getDbo();
		
		$lists = array();

        $db->setQuery('SELECT DAY(event_start) AS day, MONTH(event_start) AS month, YEAR(event_start) AS year FROM `#__blogger_items` WHERE state = 1 AND isEvent = 1 AND event_start != "0000-00-00 00:00:00"');
        $rows = $db->loadObjectList();

        foreach($rows as $row) {
            $lists[] = $row->day.'-'.($row->month-1).'-'.$row->year;
        }

		return $lists;
	}
}
