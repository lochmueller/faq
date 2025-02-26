<?php

declare(strict_types = 1);

namespace HDNET\Faq\Domain\Factory;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Configuration\ConfigurationService;
use TYPO3\CMS\Form\Domain\Factory\AbstractFormFactory;
use TYPO3\CMS\Form\Domain\Model\FormDefinition;

class QuestionFormFactory extends AbstractFormFactory
{
    protected array $extensionConfiguration;

    /**
     * QuestionFormFactory constructor.
     *
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException
     */
    public function __construct(ExtensionConfiguration $extensionConfiguration)
    {
        $this->extensionConfiguration = (array)$extensionConfiguration->get('faq');
    }

    public function build(array $configuration, ?string $prototypeName = null): FormDefinition
    {
        $prototypeName = 'standard';
        /** @var ConfigurationService $configurationService */
        $configurationService = GeneralUtility::makeInstance(ConfigurationService::class);
        $prototypeConfiguration = $configurationService->getPrototypeConfiguration($prototypeName);

        /** @var FormDefinition $form */
        $form = GeneralUtility::makeInstance(FormDefinition::class, 'QuestionForm', $prototypeConfiguration);
        $form->setRenderingOption('controllerAction', 'submit');
        $form->setRenderingOption('fluidAdditionalAttributes', [
            'novalidate' => $this->extensionConfiguration['disableFormFrontendValidation'] ? '' : 'novalidate',
        ]);

        $page = $form->createPage('page');
        $question = $page->createElement('question', 'Textarea');
        $question->setLabel('Question');
        $question->addValidator(GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator::class));
        $question->setProperty('elementDescription', $this->extensionConfiguration['questionDescription']);
        $question->setProperty('fluidAdditionalAttributes', ['required' => 'required', 'placeholder' => $this->extensionConfiguration['questionPlaceholder']]);

        $email = $page->createElement('email', 'Email');
        $email->setLabel('Email');
        $email->addValidator(GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator::class));
        $email->setProperty('elementDescription', $this->extensionConfiguration['emailDescription']);
        $email->setProperty('fluidAdditionalAttributes', ['required' => 'required', 'placeholder' => $this->extensionConfiguration['emailPlaceholder']]);

        $form->createFinisher('EmailToSender', [
            'subject' => 'Question',
            'recipients' => [
                $this->extensionConfiguration['fallbackFormReceivingEmail'] => $this->extensionConfiguration['fallbackFormReceivingName'],
            ],
            'senderAddress' => $this->extensionConfiguration['defaultFormSenderEmail'],
            'senderName' => $this->extensionConfiguration['defaultFormSenderName'],
        ]);

        $form->createFinisher('EmailToReceiver', [
            'subject' => 'Question',
            'recipients' => [
                '{email}' => '{email}',
            ],
            'senderAddress' => $this->extensionConfiguration['defaultFormSenderEmail'],
            'senderName' => $this->extensionConfiguration['defaultFormSenderName'],
        ]);

        $form->createFinisher('Confirmation', [
            'templateRootPaths' => [
                20 => 'EXT:faq/Resources/Private/Templates/Question/',
            ],
        ]);

        $this->triggerFormBuildingFinished($form);

        return $form;
    }
}
