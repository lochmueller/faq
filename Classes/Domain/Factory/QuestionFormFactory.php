<?php


namespace HDNET\Faq\Domain\Factory;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Validation\Validator\EmailAddressValidator;
use TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator;
use TYPO3\CMS\Form\Domain\Configuration\ConfigurationService;
use TYPO3\CMS\Form\Domain\Factory\AbstractFormFactory;
use TYPO3\CMS\Form\Domain\Model\FormDefinition;

class QuestionFormFactory extends AbstractFormFactory
{

    public function build(array $configuration, string $prototypeName = null): FormDefinition
    {
        $prototypeName = 'standard';
        $configurationService = GeneralUtility::makeInstance(ConfigurationService::class);
        $prototypeConfiguration = $configurationService->getPrototypeConfiguration($prototypeName);

        /** @var FormDefinition $form */
        $form = GeneralUtility::makeInstance(FormDefinition::class, 'QuestionForm', $prototypeConfiguration);
        $form->setRenderingOption('controllerAction', 'submit');
        $form->setRenderingOption('fluidAdditionalAttributes', [
            'novalidate' => ''
        ]);

        $page = $form->createPage('page');
        $question = $page->createElement('question', 'Textarea');
        $question->setLabel('Question');
        $question->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));
        $question->setProperty('elementDescription', 'Hiermit kaufst du eine Waschmaschine.');
        $question->setProperty('fluidAdditionalAttributes', ['required' => 'required', 'placeholder' => 'BOOOOOOOM']);


        $email = $page->createElement('email', 'Email');
        $email->setLabel('Email (for the answer)');
        $email->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));
        $email->setProperty('fluidAdditionalAttributes', ['required' => 'required', 'placeholder' => 'BOOOOOOOM2']);

        $form->createFinisher('EmailToSender', []);
        $form->createFinisher('EmailToReceiver', []);

        $this->triggerFormBuildingFinished($form);
        return $form;
    }
}
