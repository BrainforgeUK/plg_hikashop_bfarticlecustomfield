<?php
/**
 * @package   Provides a custom Hikashop field type for referencing articles.
 * @version   0.0.1
 * @author    https://www.brainforge.co.uk
 * @copyright Copyright (C) 2020 Jonathan Brain. All rights reserved.
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;

require_once(__DIR__ . '/articlecustomfield.php');

Factory::getLanguage()->load('plg_hikashop_bfarticlecustomfield', __DIR__);

class plgHikashopBfarticlecustomfield extends CMSPlugin
{
	public static $_params = null;

	public function __construct($subject, $config)
	{
		parent::__construct($subject, $config);

		if (empty(self::$_params) && !empty($this->params))
		{
			self::$_params = $this->params;
		}
	}

	public function onFieldsLoad(&$fields, &$options)
	{
		$field = new stdClass();
		$field->name = 'Bfarticlecustomfield';
		$field->text = Text::_('PLG_HIKASHOP_BFARTICLECUSTOMFIELD_FIELD_TITLE');
		$field->options = array('required', 'default', 'columnname');
		$fields[] = $field;
	}
}