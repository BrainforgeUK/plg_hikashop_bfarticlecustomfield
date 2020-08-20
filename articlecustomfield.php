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

require_once(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_hikashop' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'field.php');

class hikashopBfarticlecustomfield extends hikashopFieldText
{
	var $type = 'Bfarticlecustomfield';
	var $isAdmin = false;

	function display($field, $value, $map, $inside, $options = '', $test = false, $allFields = null, $allValues = null)
	{
		$database = Factory::getDBO();
		$html = '';

		if ($map == 'data[field][field_default]')
		{
			$html = 'None</dd><dt data-hk-display="default"><label>Article category</label></dt><dd data-hk-display="default">';
			$html .= '<select id="'.$this->prefix.$field->field_namekey.$this->suffix.'" name="' . $map . '" size=1'.$options.'>';
			$html .= '<option value="">'.Text::_('PLG_HIKASHOP_BFARTICLECUSTOMFIELD_PLEASESELECT_CATEGORY').'</option>';

			$database->setQuery("SELECT id, title " .
				"FROM #__categories " .
				"WHERE extension = 'com_content' " .
				"AND published = 1 " .
				"ORDER BY title ASC;");
			$categories = $database->loadObjectList();
			if (!empty($categories))
			{
				foreach($categories as $category)
				{
					$html .= '<option value="' . $category->id . '"' .
						(($category->id == $field->field_default) ? ' selected' : '') .
						'>'.$category->title.'</option>';
				}
			}

			$html .= '</select>';
		}
		else
		{
			$html .= '<select id="'.$this->prefix.$field->field_namekey.$this->suffix.'" name="'.$map.'" size=1'.$options.'>';
			$html .= '<option value="">'.Text::_('PLG_HIKASHOP_BFARTICLECUSTOMFIELD_PLEASESELECT_ARTICLE').'</option>';

			if ($catid = intval($field->field_default))
			{
				$database->setQuery("SELECT id, title " .
					"FROM #__content " .
					"WHERE state = 1 " .
					"AND catid = " . $catid . ' ' .
					"ORDER BY title ASC;");
				$articles = $database->loadObjectList();
				if (!empty($articles))
				{
					foreach($articles as $article)
					{
						$html .= '<option value="' . $article->id . '"' .
							(($article->id == $value) ? ' selected' : '') .
							'>'.$article->title.'</option>';
					}
				}
			}

			$html .= '</select>';
		}

		return $html;
	}

	function show(&$field, $value, $className='')
	{
		if (!empty($value))
		{
			$database = Factory::getDBO();
			$database->setQuery("SELECT title " .
				"FROM #__content " .
				"WHERE id = " . intval($value) . ' ' .
				"ORDER BY title ASC;");
			$value = $database->loadResult();
		}

		return parent::show($field, $value, $className);
	}
}