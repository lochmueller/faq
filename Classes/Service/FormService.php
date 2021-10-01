<?php


namespace HDNET\Faq\Service;


use HDNET\Faq\Domain\Factory\QuestionFormFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Error\Result;
use TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Form\Domain\Factory\FormFactoryInterface;
use TYPO3\CMS\Form\Domain\Finishers\FinisherContext;
use TYPO3\CMS\Form\Domain\Model\FormDefinition;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;

class FormService
{

    /**
     * @var array
     */
    protected $errors;

    /**
     * FormService constructor.
     */
    public function __construct()
    {
        $this->errors = [];
    }


    public function validate(RequestInterface $request, string $factoryClassName): bool
    {
        /** @var FormFactoryInterface $factory */
        $factory = GeneralUtility::makeInstance($factoryClassName);

        /** @var FormDefinition $form */
        $form = $factory->build([]);

        $formRuntime = $form->bind($request);

        $formElements = $form->getElements();

        $errors = [];

        foreach ($formElements as $identifier => $element) {
            $validators = $element->getValidators();
            foreach ($validators as $validator) {
                /** @var Result $result */
                $result = $validator->validate($formRuntime->getElementValue($identifier));
                if($result->hasErrors()) {
                    $errors[$identifier] = $result->getErrors();
                    // We continue here because it is not necessary to check other validators, because value is invalid.
                    continue;
                }
            }
        }

        /*
         *
         *
            'subject' => 'Question',
            'recipients' => [
                '##Email##Sender##recipient##' => 'Lukas'
            ],
            'senderAddress' => 'lukas.schoenbeck@hdnet.com',
            'senderName' => 'Lukas',
         *
         *
         * 'subject' => 'Question Receiver',
            'recipients' => [
                'lukas.Receiver.recip@hdnet.de' => 'Lukas receiver'
            ],
            'senderAddress' => 'lukas.reciver@hdnet.com',
            'senderName' => 'Lukas receiver',
         *
         */



        $this->errors = $errors;
        return empty($errors);
    }

    public function executeFinisher(RequestInterface $request, string $factoryClassName): void
    {
        /** @var FormFactoryInterface $factory */
        $factory = GeneralUtility::makeInstance($factoryClassName);

        /** @var FormDefinition $form */
        $form = $factory->build([]);

        $formRuntime = $form->bind($request);

        foreach ($form->getFinishers() as $finisher) {

            // Check if finisher is emailToSender or emailToReceiver
            // Fill finisher options with data from form or from extension configurations.

            $finisher->execute(new FinisherContext($formRuntime, new ControllerContext() ,$request));
        }

    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}
