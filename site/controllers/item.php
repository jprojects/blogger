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

use \Joomla\CMS\Factory;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Language\Text;

/**
 * Item controller class.
 *
 * @since  1.6
 */
class BloggerControllerItem extends \Joomla\CMS\MVC\Controller\BaseController
{
	/**
	 * Method to check out an item for editing and redirect to the edit form.
	 *
	 * @return void
	 *
	 * @since    1.6
     *
     * @throws Exception
	 */
	public function edit()
	{
		$app = Factory::getApplication();

		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_blogger.edit.item.id');
		$editId     = $app->input->getInt('id', 0);

		// Set the user id for the user to edit in the session.
		$app->setUserState('com_blogger.edit.item.id', $editId);

		// Get the model.
		$model = $this->getModel('Item', 'BloggerModel');

		// Check out the item
		if ($editId)
		{
			$model->checkout($editId);
		}

		// Check in the previous user.
		if ($previousId && $previousId !== $editId)
		{
			$model->checkin($previousId);
		}

		// Redirect to the edit screen.
		$this->setRedirect(Route::_('index.php?option=com_blogger&view=itemform&layout=edit', false));
	}

	/**
	 * Method to save a user's profile data.
	 *
	 * @return    void
	 *
	 * @throws Exception
	 * @since    1.6
	 */
	public function publish()
	{
		// Initialise variables.
		$app = Factory::getApplication();

		// Checking if the user can remove object
		$user = Factory::getUser();

		if ($user->authorise('core.edit', 'com_blogger') || $user->authorise('core.edit.state', 'com_blogger'))
		{
			$model = $this->getModel('Item', 'BloggerModel');

			// Get the user data.
			$id    = $app->input->getInt('id');
			$state = $app->input->getInt('state');

			// Attempt to save the data.
			$return = $model->publish($id, $state);

			// Check for errors.
			if ($return === false)
			{
				$this->setMessage(Text::sprintf('Save failed: %s', $model->getError()), 'warning');
			}

			// Clear the profile id from the session.
			$app->setUserState('com_blogger.edit.item.id', null);

			// Flush the data from the session.
			$app->setUserState('com_blogger.edit.item.data', null);

			// Redirect to the list screen.
			$this->setMessage(Text::_('COM_BLOGGER_ITEM_SAVED_SUCCESSFULLY'));
			$menu = Factory::getApplication()->getMenu();
			$item = $menu->getActive();

			if (!$item)
			{
				// If there isn't any menu item active, redirect to list view
				$this->setRedirect(Route::_('index.php?option=com_blogger&view=items', false));
			}
			else
			{
                $this->setRedirect(Route::_('index.php?Itemid='. $item->id, false));
			}
		}
		else
		{
			if($user->guest) {
                throw new \Exception(Text::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 401);
            } else{
                throw new \Exception(Text::_('JERROR_ALERTNOAUTHOR'), 403);		
            }
		}
	}

	/**
	 * Remove data
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function remove()
	{
		// Initialise variables.
		$app = Factory::getApplication();

		// Checking if the user can remove object
		$user = Factory::getUser();

		if ($user->authorise('core.delete', 'com_blogger'))
		{
			$model = $this->getModel('Item', 'BloggerModel');

			// Get the user data.
			$id = $app->input->getInt('id', 0);

			// Attempt to save the data.
			$return = $model->delete($id);

			// Check for errors.
			if ($return === false)
			{
				$this->setMessage(Text::sprintf('Delete failed', $model->getError()), 'warning');
			}
			else
			{
				// Check in the profile.
				if ($return)
				{
					$model->checkin($return);
				}

                $app->setUserState('com_blogger.edit.item.id', null);
                $app->setUserState('com_blogger.edit.item.data', null);

                $app->enqueueMessage(Text::_('COM_BLOGGER_ITEM_DELETED_SUCCESSFULLY'), 'success');
                $app->redirect(Route::_('index.php?option=com_blogger&view=items', false));
			}

			// Redirect to the list screen.
			$menu = Factory::getApplication()->getMenu();
			$item = $menu->getActive();
			$this->setRedirect(Route::_($item->link, false));
		}
		else
		{
			if($user->guest) {
                throw new \Exception(Text::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 401);
            } else{
                throw new \Exception(Text::_('JERROR_ALERTNOAUTHOR'), 403);		
            }
		}
	}
}
