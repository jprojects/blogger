<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Blogger
 * @author     aficat <kim@aficat.com>
 * @copyright  2021 aficat
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Categories\Categories;
/**
 * Content Component Category Tree
 *
 * @since  1.6
 */

class BloggerItemsCategories extends Categories
{
	/**
	 * Class constructor
	 *
	 * @param   array  $options  Array of options
	 *
	 * @since   11.1
	 */
	public function __construct($options = array())
	{
		$options['table'] = '#__blogger_items';
		$options['extension'] = 'com_blogger.items';
		parent::__construct($options);
	}
}
