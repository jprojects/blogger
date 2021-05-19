<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Blogger
 * @author     aficat <kim@aficat.com>
 * @copyright  2021 aficat
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Helper\TagsHelper;
use \Joomla\CMS\Layout\FileLayout;
use \Joomla\Utilities\ArrayHelper;

/**
 * Methods supporting a list of Blogger records.
 *
 * @since  1.6
 */
class BloggerModelItems extends \Joomla\CMS\MVC\Model\ListModel
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see        JController
	 * @since      1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'ordering', 'a.ordering',
				'created_by', 'a.created_by',
				'modified_by', 'a.modified_by',
				'state', 'a.state',
				'catid', 'a.catid',
				'title', 'a.title',
				'description', 'a.description',
				'intro_img', 'a.intro_img',
				'full_img', 'a.full_img',
				'author', 'a.author',
				'tags', 'a.tags',
				'language', 'a.language',
			);
		}

		parent::__construct($config);
	}

        
        
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   Elements order
	 * @param   string  $direction  Order direction
	 *
	 * @return void
	 *
	 * @throws Exception
	 *
	 * @since    1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app  = Factory::getApplication();
            
		$list = $app->getUserState($this->context . '.list');

		$ordering  = isset($list['filter_order'])     ? $list['filter_order']     : null;
		$direction = isset($list['filter_order_Dir']) ? $list['filter_order_Dir'] : null;
		if(empty($ordering)){
		$ordering = $app->getUserStateFromRequest($this->context . '.filter_order', 'filter_order', $app->get('filter_order'));
		if (!in_array($ordering, $this->filter_fields))
		{
		$ordering = "a.id";
		}
		$this->setState('list.ordering', $ordering);
		}
		if(empty($direction))
		{
		$direction = $app->getUserStateFromRequest($this->context . '.filter_order_Dir', 'filter_order_Dir', $app->get('filter_order_Dir'));
		if (!in_array(strtoupper($direction), array('ASC', 'DESC', '')))
		{
		$direction = "ASC";
		}
		$this->setState('list.direction', $direction);
		}

		$list['limit']     = $app->getUserStateFromRequest($this->context . '.list.limit', 'limit', $app->get('list_limit'), 'uint');
		$list['start']     = $app->input->getInt('start', 0);
		$list['ordering']  = $ordering;
		$list['direction'] = $direction;

		$app->setUserState($this->context . '.list', $list);
		$app->input->set('list', null);
           
            
        // List state information.

        parent::populateState($ordering, $direction);

        $context = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $context);

        $this->setState($this->context . 'id', $app->input->getInt('id', 0));

        // Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

        if ($parts)
        {
            $this->setState('filter.component', $parts[0]);
            $this->setState('filter.section', $parts[1]);
        }
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$app   = Factory::getApplication();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
					'list.select', 'DISTINCT a.*'
			)
		);

		$query->from('`#__blogger_items` AS a');
		
		$query->where('a.state = 1');    

		// Filtering date
		$date = $app->input->get("date");

		if ($date != '')
		{
			$query->where("a.`event_start` LIKE '%".$db->escape(date('Y-m-d', $date))."%'");
		} else {
			// Filtering catid
			$catid = $app->input->get("catid");

			if ($catid)
			{
				$query->where("a.`catid` = '".$db->escape($catid)."'");
			}
		}

		// Filtering language
		$language = Factory::getLanguage()->getTag();

		if ($filter_language != '*')
		{
			$query->where("a.`language` = '" . $db->escape($language) . "'");
		}
            
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', "a.id");
		$orderDirn = $this->state->get('list.direction', "ASC");

		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}
		//echo $query;
		return $query;
	}

	/**
	 * Method to get an array of data items
	 *
	 * @return  mixed An array of data on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();
		
		foreach ($items as $item)
		{

		if (isset($item->catid) && $item->catid != '')
		{

			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);

			$query
				->select($db->quoteName('title'))
				->from($db->quoteName('#__categories'))
				->where('FIND_IN_SET(' . $db->quoteName('id') . ', ' . $db->quote($item->catid) . ')');

			$db->setQuery($query);

			$result = $db->loadColumn();

			$item->catid_name = !empty($result) ? implode(', ', $result) : '';
		}
		}

		return $items;
	}

	/**
	 * Overrides the default function to check Date fields format, identified by
	 * "_dateformat" suffix, and erases the field if it's not correct.
	 *
	 * @return void
	 */
	protected function loadFormData()
	{
		$app              = Factory::getApplication();
		$filters          = $app->getUserState($this->context . '.filter', array());
		$error_dateformat = false;

		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value) && $this->isValidDate($value) == null)
			{
				$filters[$key]    = '';
				$error_dateformat = true;
			}
		}

		if ($error_dateformat)
		{
			$app->enqueueMessage(Text::_("COM_BLOGGER_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}

		return parent::loadFormData();
	}

	/**
	 * Checks if a given date is valid and in a specified format (YYYY-MM-DD)
	 *
	 * @param   string  $date  Date to be checked
	 *
	 * @return bool
	 */
	private function isValidDate($date)
	{
		$date = str_replace('/', '-', $date);
		return (date_create($date)) ? Factory::getDate($date)->format("Y-m-d") : null;
	}

	/**
	 * Get intro from full text
	 *
	 * @param   string  $text  Article text
	 *
	 * @return string
	 */
	public function getIntro($text) 
	{
		if(strpos($text, '<hr id="system-readmore" />') !== false) {
			$txt = explode('<hr id="system-readmore" />', $text);
			return $txt[0];
		} else {
			return $text;
		}
	}

	/**
	 * Calculate the reading time
	 *
	 * @param   string  $text  Article text
	 *
	 * @return int
	 */
	public function calcTimeRead($text) 
	{
		$count = round(str_word_count($text) / 250);

		if($count == 0) { $count = 1; }

		return $count;
	}
}
