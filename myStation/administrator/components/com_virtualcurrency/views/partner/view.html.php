<?php
/**
 * @package      Virtualcurrency
 * @subpackage   Components
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class VirtualcurrencyViewPartner extends JViewLegacy
{
    /**
     * @var JDocumentHtml
     */
    public $document;

    /**
     * @var Joomla\Restiry\Registry
     */
    protected $state;

    protected $item;
    protected $form;

    protected $option;
    protected $documentTitle;

    protected $imagesFolder;

    /**
     * Display the view
     */
    public function display($tpl = null)
    {
        $this->option = JFactory::getApplication()->input->get('option');
        
        $this->state = $this->get('State');
        $this->item  = $this->get('Item');
        $this->form  = $this->get('Form');

        // Prepare actions, behaviors, scripts and document
        $this->addToolbar();
        $this->setDocument();

        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since   1.6
     */
    protected function addToolbar()
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);
        $isNew = ($this->item->id === 0);

        $this->documentTitle = $isNew ? JText::_('COM_VIRTUALCURRENCY_NEW_PARTNER') : JText::_('COM_VIRTUALCURRENCY_EDIT_PARTNER');

        JToolBarHelper::apply('partner.apply');
        JToolBarHelper::save2new('partner.save2new');
        JToolBarHelper::save('partner.save');

        if (!$isNew) {
            JToolBarHelper::cancel('partner.cancel', 'JTOOLBAR_CANCEL');
            JToolBarHelper::title($this->documentTitle, 'itp-edit-partner');
        } else {
            JToolBarHelper::cancel('partner.cancel', 'JTOOLBAR_CLOSE');
            JToolBarHelper::title($this->documentTitle, 'itp-new-partner');
        }
    }

    /**
     * Method to set up the document properties
     *
     * @return void
     */
    protected function setDocument()
    {
        $this->document->setTitle($this->documentTitle);

        // Add behaviors
        JHtml::_('behavior.tooltip');
        JHtml::_('behavior.formvalidation');

        // Add scripts
        $this->document->addScript('../media/' . $this->option . '/js/admin/' . JString::strtolower($this->getName()) . '.js');
    }
}
