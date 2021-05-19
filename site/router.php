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

use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Factory;
use Joomla\CMS\Categories\Categories;

/**
 * Class BloggerRouter
 *
 */
class BloggerRouter extends RouterView
{
	private $noIDs;
	public function __construct($app = null, $menu = null)
	{
		$params = JComponentHelper::getComponent('com_blogger')->params;
		$this->noIDs = (bool) $params->get('sef_ids');
		
		$items = new RouterViewConfiguration('items');
		$items->setKey('id')->setNestable();
		$this->registerView($items);
			$item = new RouterViewConfiguration('item');
			$item->setKey('id')->setParent($items, 'catid');
			$this->registerView($item);
			$itemform = new RouterViewConfiguration('itemform');
			$itemform->setKey('id');
			$this->registerView($itemform);

		parent::__construct($app, $menu);

		$this->attachRule(new MenuRules($this));

		if ($params->get('sef_advanced', 0))
		{
			$this->attachRule(new StandardRules($this));
			$this->attachRule(new NomenuRules($this));
		}
		else
		{
			JLoader::register('BloggerRulesLegacy', __DIR__ . '/helpers/legacyrouter.php');
			JLoader::register('BloggerHelpersBlogger', __DIR__ . '/helpers/blogger.php');
			$this->attachRule(new BloggerRulesLegacy($this));
		}
	}


	
			/**
			 * Method to get the segment(s) for a category
			 *
			 * @param   string  $id     ID of the category to retrieve the segments for
			 * @param   array   $query  The request that is built right now
			 *
			 * @return  array|string  The segments of this item
			 */
			public function getItemsSegment($id, $query)
			{
				$category = Categories::getInstance('blogger.items')->get($id);

				if ($category)
				{
					$path = array_reverse($category->getPath(), true);
					$path[0] = '1:root';

					if ($this->noIDs)
					{
						foreach ($path as &$segment)
						{
							list($id, $segment) = explode(':', $segment, 2);
						}
					}

					return $path;
				}

				return array();
			}
		/**
		 * Method to get the segment(s) for an item
		 *
		 * @param   string  $id     ID of the item to retrieve the segments for
		 * @param   array   $query  The request that is built right now
		 *
		 * @return  array|string  The segments of this item
		 */
		public function getItemSegment($id, $query)
		{
			return array((int) $id => $id);
		}
			/**
			 * Method to get the segment(s) for an itemform
			 *
			 * @param   string  $id     ID of the itemform to retrieve the segments for
			 * @param   array   $query  The request that is built right now
			 *
			 * @return  array|string  The segments of this item
			 */
			public function getItemformSegment($id, $query)
			{
				return $this->getItemSegment($id, $query);
			}

	
			/**
			 * Method to get the id for a category
			 *
			 * @param   string  $segment  Segment to retrieve the ID for
			 * @param   array   $query    The request that is parsed right now
			 *
			 * @return  mixed   The id of this item or false
			 */
			public function getItemsId($segment, $query)
			{
				if (isset($query['id']))
				{
					$category = Categories::getInstance('blogger.items', array('access' => false))->get($query['id']);

					if ($category)
					{
						foreach ($category->getChildren() as $child)
						{
							if ($this->noIDs)
							{
								if ($child->alias == $segment)
								{
									return $child->id;
								}
							}
							else
							{
								if ($child->id == (int) $segment)
								{
									return $child->id;
								}
							}
						}
					}
				}

				return false;
			}
		/**
		 * Method to get the segment(s) for an item
		 *
		 * @param   string  $segment  Segment of the item to retrieve the ID for
		 * @param   array   $query    The request that is parsed right now
		 *
		 * @return  mixed   The id of this item or false
		 */
		public function getItemId($segment, $query)
		{
			return (int) $segment;
		}
			/**
			 * Method to get the segment(s) for an itemform
			 *
			 * @param   string  $segment  Segment of the itemform to retrieve the ID for
			 * @param   array   $query    The request that is parsed right now
			 *
			 * @return  mixed   The id of this item or false
			 */
			public function getItemformId($segment, $query)
			{
				return $this->getItemId($segment, $query);
			}
}
