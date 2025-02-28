<?php

declare(strict_types=1);

namespace LaminasTest\Form\TestAsset;

use Laminas\Form\FieldsetInterface;
use Laminas\Form\View\Helper\AbstractHelper;
use Laminas\Form\View\Helper\FormCollection as FormCollectionHelper;

use function method_exists;
use function preg_replace;

class CustomFieldsetHelper extends AbstractHelper
{
    /** @var FormCollectionHelper */
    protected $fieldsetHelper;

    public function __invoke(FieldsetInterface $fieldset): string
    {
        $fieldsetHelper = $this->getFieldsetHelper();

        $name = preg_replace('/[^a-z0-9_-]+/', '', $fieldset->getName());
        return '<div id="customFieldset' . $name . '">' . $fieldsetHelper($fieldset) . '</div>';
    }

    /**
     * Retrieve the FormCollection helper
     *
     * @return FormCollectionHelper
     */
    protected function getFieldsetHelper()
    {
        if ($this->fieldsetHelper) {
            return $this->fieldsetHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->fieldsetHelper = $this->view->plugin('form_collection');
        }

        if (! $this->fieldsetHelper instanceof FormCollectionHelper) {
            $this->fieldsetHelper = new FormCollectionHelper();
        }

        return $this->fieldsetHelper;
    }
}
