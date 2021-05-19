<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Blogger
 * @author     aficat <kim@aficat.com>
 * @copyright  2021 aficat
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Items list controller class.
 *
 * @since  1.6
 */
class BloggerControllerItems extends BloggerController
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional
	 * @param   array   $config  Configuration array for model. Optional
	 *
	 * @return object	The model
	 *
	 * @since	1.6
	 */
	public function &getModel($name = 'Items', $prefix = 'BloggerModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
}
