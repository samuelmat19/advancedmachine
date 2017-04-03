<?php
/**
 * @package      Gamification Platform
 * @subpackage   Components
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

use Prism\Controller\Form\Backend;
use Joomla\Utilities\ArrayHelper;

// No direct access
defined('_JEXEC') or die;

/**
 * Gamification notification controller class.
 *
 * @package       Gamification Platform
 * @subpackage    Components
 * @since         1.6
 */
class GamificationControllerNotification extends Backend
{
    public function save($key = null, $urlVar = null)
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $data   = $this->input->post->get('jform', array(), 'array');
        $itemId = ArrayHelper::getValue($data, 'id');

        $redirectData = array(
            'task' => $this->getTask(),
            'id'   => $itemId
        );

        $model = $this->getModel();
        /** @var $model GamificationModelNotification */

        $form = $model->getForm($data, false);
        /** @var $form JForm */

        if (!$form) {
            throw new Exception(JText::_('COM_GAMIFICATION_ERROR_FORM_CANNOT_BE_LOADED'));
        }

        // Validate the form
        $validData = $model->validate($form, $data);

        // Check for errors.
        if ($validData === false) {
            $this->displayNotice($form->getErrors(), $redirectData);

            return;
        }

        try {
            $itemId             = $model->save($validData);
            $redirectData['id'] = $itemId;

        } catch (Exception $e) {
            JLog::add($e->getMessage(), JLog::ERROR, 'com_gamification');
            throw new Exception(JText::_('COM_GAMIFICATION_ERROR_SYSTEM'));
        }

        $this->displayMessage(JText::_('COM_GAMIFICATION_NOTIFICATION_SAVED'), $redirectData);
    }
}
