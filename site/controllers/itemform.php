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
use \Joomla\CMS\Session\Session;
use \Joomla\CMS\Language\Text;

/**
 * Item controller class.
 *
 * @since  1.6
 */
class BloggerControllerItemForm extends \Joomla\CMS\MVC\Controller\FormController
{
	/**
	 * Method to save a user's profile data.
	 *
	 * @return void
	 *
	 * @throws Exception
	 * @since  1.6
	 */
	public function save($key = NULL, $urlVar = NULL)
	{
		// Check for request forgeries.
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app   = Factory::getApplication();
		$db    = Factory::getDbo();

		// Get the user data.
		$data = $app->input->get('jform', array(), 'array');

		$item = new stdClass();

		$item->id			= 0;
		$item->catid    	= 13;
		$item->state    	= 0;
		$item->title    	= $data['title'];
		$item->description 	= $this->addReadmore($data['description'], 400);
		$item->intro_img    = $this->upload('intro_img');
		$item->full_img     = $this->upload('full_img');
		$item->language     = 'ca-ES';
		$item->isEvent      = 0;
		$item->event_start  = '0000-00-00 00:00:00';
		$item->event_end    = '0000-00-00 00:00:00';
		$item->event_loc    = '';

		$result = $db->insertObject('#__blogger_items', $item);

		if($result) {
			$msg  = "L'artícle ha estat enviat, un administrador el revisarà abans de la seva publicació.";
			$type = 'success';
		} else {
			$msg  = "L'artícle no s'ha pogut enviar, si us plau torna a intentar-ho si el problema persisteix contacta amb un administrador.";
			$type = 'error';
		}

		$this->setRedirect(base64_decode($app->input->get('return')), $msg, $type);
	}

	/**
	 * add readmore to long text
	 * @param string $input text to trim
	 * @param int $length in characters to trim to
	 * @param bool $ellipses if ellipses (...) are to be added
	 * @param bool $strip_html if html tags are to be stripped
	 * @return string 
	 */
	public function addReadmore($input, $length) 
	{	 
	   	//no need to trim, already shorter than trim length
	   	if (strlen($input) <= $length) {
		   return $input;
	   	}
	 
	   	//find last space within length
	   	$text .= substr($input, 0, $length);
	 
	   	//add readmore
		$text .= '<hr id="system-readmore" />';

		$text .= substr($input, $length);
	 
	   	return $text;
    }

	public function upload($fieldname)
	{
		$jinput  = JFactory::getApplication()->input;
        $file    = $jinput->files->get('jform');
       	$allowed = array('jpg', 'png', 'jpeg');

    	jimport('joomla.filesystem.file');

    	$filename = JFile::makeSafe($file[$fieldname]['name']);

    	$src  = $file[$fieldname]['tmp_name'];
    	$dest = JPATH_ROOT."/images/sampledata/".$filename;
    	$extension = strtolower(JFile::getExt($filename));

    	if ( in_array($extension, $allowed) ) {
       		JFile::upload($src, $dest);
       		return "/images/sampledata/".$filename;
    	} else {
    		return false;
    	}
	}
}
