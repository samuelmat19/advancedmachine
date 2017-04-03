<?php
/**
 * @package      Virtual Currency
 * @subpackage   Components
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Virtualcurrency Account controller class.
 *
 * @package        Virtualcurrency
 * @subpackage     Components
 * @since          1.6
 */
class VirtualcurrencyControllerAccount extends Prism\Controller\Form\Backend
{
    public function save($key = null, $urlVar = null)
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $data   = $this->input->post->get('jform', array(), 'array');
        $itemId = Joomla\Utilities\ArrayHelper::getValue($data, 'id');

        // Prepare return data
        $redirectOptions = array(
            'task' => $this->getTask(),
            'id'   => $itemId
        );

        $model = $this->getModel();
        /** @var $model VirtualcurrencyModelAccount */

        $form = $model->getForm($data, false);
        /** @var $form JForm */

        if (!$form) {
            throw new Exception(JText::_('COM_VIRTUALCURRENCY_ERROR_FORM_CANNOT_BE_LOADED'));
        }

        // Validate the form
        $validData = $model->validate($form, $data);

        // Check for errors.
        if ($validData === false) {
            $this->displayNotice($form->getErrors(), $redirectOptions);

            return;
        }

        // Check user ID
        $userId = Joomla\Utilities\ArrayHelper::getValue($validData, 'user_id');
        if (!$userId) {
            $this->displayNotice(JText::_('COM_VIRTUALCURRENCY_ERROR_INVALID_USER'), $redirectOptions);

            return;
        }

        // Check for existing account for that currency
        $currencyId = Joomla\Utilities\ArrayHelper::getValue($data, 'currency_id');

        $account    = new Virtualcurrency\Account\Account(JFactory::getDbo());
        $account->load(array('user_id' => $userId, 'currency_id' => $currencyId));
        if (!$itemId and $account->getId()) {
            $this->displayNotice(JText::_('COM_VIRTUALCURRENCY_ERROR_ACCOUNT_EXISTS'), $redirectOptions);
            return;
        }

        try {
            $itemId = $model->save($validData);

            $redirectOptions['id'] = $itemId;
        } catch (Exception $e) {
            JLog::add($e->getMessage(), JLog::ERROR, 'com_virtualcurrency');
            throw new Exception(JText::_('COM_VIRTUALCURRENCY_ERROR_SYSTEM'));
        }

        $this->displayMessage(JText::_('COM_VIRTUALCURRENCY_ACCOUNT_SAVED'), $redirectOptions);
    }
}
