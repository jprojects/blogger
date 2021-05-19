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

JLoader::register('ContentHelper', JPATH_ADMINISTRATOR . '/components/com_content/helpers/content.php');
JLoader::register('CategoryHelperAssociation', JPATH_ADMINISTRATOR . '/components/com_categories/helpers/association.php');

use \Joomla\CMS\Factory;

/**
 * Content Component Association Helper.
 *
 * @since  3.0
 */
class BloggerHelperAssociation extends CategoryHelperAssociation
{
    /**
     * Method to get the associations for a given item
     *
     * @param   integer  $id    Id of the item
     * @param   string   $view  Name of the view
     *
     * @return  array   Array of associations for the item
     *
     * @since  3.0
     *
     * @throws Exception
     */
    public static function getAssociations($id = 0, $view = null)
    {
        jimport('helper.route', JPATH_COMPONENT_SITE);

        $app = Factory::getApplication();
        $jinput = $app->input;
        $view = is_null($view) ? $jinput->get('view') : $view;
        $id = empty($id) ? $jinput->getInt('id') : $id;

        if ($view == 'category' || $view == 'categories')
        {
            return self::getCategoryAssociations($id, 'com_blogger');
        }

        return array();
    }
}
