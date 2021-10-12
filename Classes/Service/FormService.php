<?php

declare(strict_types = 1);

namespace HDNET\Faq\Service;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Error\Result;
use TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Form\Domain\Factory\FormFactoryInterface;
use TYPO3\CMS\Form\Domain\Finishers\FinisherContext;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;

class FormService
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * @var FormRuntime
     */
    protected $formRuntime;

    /**
     * @var ExtensionConfiguration
     */
    protected $extensionConfiguration;

    /**
     * FormService constructor.
     */
    public function __construct(ExtensionConfiguration $extensionConfiguration)
    {
        $this->errors = [];
        $this->extensionConfiguration = $extensionConfiguration;
    }

    public function validate(RequestInterface $request, string $factoryClassName): bool
    {
        /** @var FormFactoryInterface $factory */
        $factory = GeneralUtility::makeInstance($factoryClassName, $request, $this->extensionConfiguration);
        $form = $factory->build([]);

        $this->formRuntime = $form->bind($request);
        $formElements = $form->getElements();

        $errors = [];
        foreach ($formElements as $identifier => $element) {
            $validators = $element->getValidators();
            foreach ($validators as $validator) {
                /** @var Result $result */
                $result = $validator->validate($this->getFormRuntime()->getElementValue($identifier));
                if ($result->hasErrors()) {
                    $errors[$identifier] = $result->getErrors();
                    // We continue here because it is not necessary to check other validators, because value is invalid.
                    continue;
                }
            }
        }
        $this->errors = $errors;

        return empty($errors);
    }

    public function executeFinisher(RequestInterface $request, string $factoryClassName, array $pluginSettings): void
    {
        /** @var FormFactoryInterface $factory */
        $factory = GeneralUtility::makeInstance($factoryClassName, $request, $this->extensionConfiguration);
        $form = $factory->build([]);
        $formRuntime = $form->bind($request);

        $extConfig = $this->extensionConfiguration->get('faq');

        foreach ($form->getFinishers() as $finisher) {
            $finisherIdentifier = $finisher->getFinisherIdentifier();

            if ('EmailToSender' === $finisherIdentifier) {
                // Email to SVO
                // Each option is set individually, since the option array is replaced by setOptions
                // and existing options are overwritten
                $finisher->setOption('subject', 'Question');
                $finisher->setOption('recipients', [
                    $extConfig['fallbackFormReceivingEmail'] => $pluginSettings['targetEmail'] ? $pluginSettings['targetEmail'] : $extConfig['fallbackFormReceivingName'],
                ]);
                $finisher->setOption('senderAddress', $extConfig['defaultFormSenderEmail']);
                $finisher->setOption('senderName', $extConfig['defaultFormSenderName']);
            } elseif ('EmailToReceiver' === $finisherIdentifier) {
                // Email to User
                // Each option is set individually, since the option array is replaced by setOptions
                // and existing options are overwritten
                $finisher->setOption('subject', 'Question');
                $finisher->setOption('recipients', [
                    $formRuntime->getElementValue('email') => $formRuntime->getElementValue('email'),
                ]);
                $finisher->setOption('senderAddress', $extConfig['defaultFormSenderEmail']);
                $finisher->setOption('senderName', $extConfig['defaultFormSenderName']);
            }
            $finisher->execute(new FinisherContext($formRuntime, new ControllerContext(), $request));
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFormRuntime(): FormRuntime
    {
        return $this->formRuntime;
    }
}
