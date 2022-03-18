<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Module\BloggerLatest\Site\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Access\Access;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;

/**
 * Helper for mod_articles_latest
 *
 * @since  1.6
 */
abstract class BloggerLatestHelper
{
	/**
	 * Retrieve a list of article
	 *
	 * @param   Registry       $params  The module parameters.
	 * @param   ArticlesModel  $model   The model.
	 *
	 * @return  mixed
	 *
	 * @since   1.6
	 */
	public static function getList($catid, $count)
	{
		// Get the Dbo and User object
		$db   = Factory::getDbo();

		$db->setQuery('SELECT id,title,catid FROM `#__blogger_items` WHERE state = 1 AND catid = '.$catid.' ORDER BY id DESC LIMIT '.$count);

		return $db->loadObjectList();
	}
}
