<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   (C) 2005 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Module\BloggerLatest\Site\Helper\BloggerLatestHelper;

$list = BloggerLatestHelper::getList($params->get('catid'), $params->get('count', 5));

require ModuleHelper::getLayoutPath('mod_blogger_latest', $params->get('layout', 'default'));
