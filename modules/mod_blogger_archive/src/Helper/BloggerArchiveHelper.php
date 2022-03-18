<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

//namespace Joomla\Module\BloggerArchive\Site\Helper;

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
class BloggerArchiveHelper
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
	public static function getList($year, $month, $catid)
	{
		$db   = Factory::getDbo();
		$lang = Factory::getLanguage()->getTag();

		$month = str_pad($month, 1, "0", STR_PAD_LEFT);

        $db->setQuery('SELECT * FROM `#__blogger_items` WHERE state = 1 AND language = '.$db->quote($lang).' AND catid = '.$catid.' AND YEAR(publish_up) = '.$db->quote($year).' AND MONTH(publish_up) = '.$db->quote($month).' ORDER BY id DESC LIMIT 5');
        return $db->loadObjectList();
	}

	/**
	 * Retrieve list of articles years
	 *
	 * @param   \Joomla\Registry\Registry  &$params  module parameters
	 *
	 * @return  array
	 *
	 * @since   1.5
	 */
	public static function getYears($catid)
	{
		$db   = Factory::getDbo();
		$lang = Factory::getLanguage()->getTag();

        $db->setQuery('SELECT DISTINCT YEAR(publish_up) AS any FROM `#__blogger_items` WHERE state = 1 AND language = '.$db->quote($lang).' AND catid = '.$catid.' ORDER BY any DESC');
        return $db->loadObjectList();
	}

	/**
	 * Retrieve list of articles months
	 *
	 * @param   \Joomla\Registry\Registry  &$params  module parameters
	 *
	 * @return  array
	 *
	 * @since   1.5
	 */
	public static function getMonths($year, $catid)
	{
		$db   = Factory::getDbo();
		$lang = Factory::getLanguage()->getTag();

        $db->setQuery('SELECT DISTINCT MONTH(publish_up) AS mes FROM `#__blogger_items` WHERE state = 1 AND language = '.$db->quote($lang).' AND catid = '.$catid.' AND YEAR(publish_up) = '.$db->quote($year).' ORDER BY mes DESC');
        return $db->loadObjectList();
	}

	/**
	 * Retrieve month name
	 *
	 * @param   \Joomla\Registry\Registry  &$params  module parameters
	 *
	 * @return  array
	 *
	 * @since   1.5
	 */
	public static function getMonthName($month)
	{
		switch($month) {
			case 1:
				$month = 'Gener';
				break;
			case 2:
				$month = 'Febrer';
				break;
			case 3:
				$month = 'Març';
				break;
			case 4:
				$month = 'Abril';
				break;
			case 5:
				$month = 'Maig';
				break;
			case 6:
				$month = 'Juny';
				break;
			case 7:
				$mont = 'Juliol';
				break;
			case 8:
				$month = 'Agost';
				break;
			case 9:
				$month = 'Setembre';
				break;
			case 10:
				$month = 'Octubre';
				break;
			case 11:
				$month = 'Novembre';
				break;
			case 12:
				$month = 'Desembre';
				break;
			default:
				$month = '';
				break;
		}

		return $month;
	}
}
