<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_blogger_gratest_hits
 *
 * @copyright   (C) 2005 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Module\BloggerGratesthits\Site\Helper\BloggerGratesthitsHelper;

$list = BloggerGratesthitsHelper::getList($params->get('catid'), $params->get('count', 5));

require ModuleHelper::getLayoutPath('mod_blogger_gratest_hits', $params->get('layout', 'default'));
