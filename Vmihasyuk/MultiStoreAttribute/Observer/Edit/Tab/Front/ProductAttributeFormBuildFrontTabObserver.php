<?php

namespace Vmihasyuk\MultiStoreAttribute\Observer\Edit\Tab\Front;

use Magento\Config\Model\Config\Source;
use Magento\Framework\Module\Manager;
use Magento\Framework\Event\ObserverInterface;

class ProductAttributeFormBuildFrontTabObserver implements ObserverInterface
{
    /**
     * @var \Magento\Config\Model\Config\Source\Yesno
     */
    protected $optionList;

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @param Manager $moduleManager
     * @param Source\Yesno $optionList
     */
    public function __construct(Manager $moduleManager, Source\Yesno $optionList)
    {
        $this->optionList = $optionList;
        $this->moduleManager = $moduleManager;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->moduleManager->isOutputEnabled('Vmihasyuk_MultiStoreAttribute')) {
            return;
        }

        /** @var \Magento\Framework\Data\Form\AbstractForm $form */
        $form = $observer->getForm();

        $fieldset = $form->getElement('front_fieldset');

        $fieldset->addField(
            'is_store_related',
            'select',
            [
                'name' => 'is_store_related',
                'label' => __("Use store values switcher"),
                'title' => __('Use store values switcher'),
                'values' => $this->optionList->toOptionArray(),
            ]
        );
        
        $fieldset->addField(
            'manage_store_titles',
            'text',
            [
                'name' => 'manage_store_titles',
                'label' => __("Switcher titles"),
                'title' => __("Switcher titles"),
                'values' => [],
            ]
        );
    }
}
