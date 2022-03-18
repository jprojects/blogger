<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_calendar
 *
 * @copyright   (C) 2005 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once (dirname(__FILE__).'/src/Helper/BloggerArchiveHelper.php');

use Joomla\CMS\Helper\ModuleHelper;
// use Joomla\Module\BloggerArchive\Site\Helper\BloggerArchiveHelper;

require ModuleHelper::getLayoutPath('mod_blogger_archive', $params->get('layout', 'default'));
