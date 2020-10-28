<?php

declare(strict_types = 1);
/**
 * E-Mail View.
 *
 * Usage:
 * $this->view->assign('from', [$email => $name]); (optional)
 * $this->view->assign('to', [$email => $name]);
 * $this->view->assign('subject', $subject);
 * $this->view->assign('files', ['path1', 'path2']); (optional)
 * $this->view->assign('filesStream', ['path1', 'path2']); (optional)
 * $this->view->render();
 * $this->forward(...);
 */

namespace HDNET\Faq\View;

use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\TemplateView;

/**
 * E-Mail View.
 */
class MailView extends TemplateView
{
    /**
     * Mail processing object.
     *
     * @var MailMessage
     */
    protected $mail;

    /**
     * Start the download.
     *
     * @param null $actionName
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function render($actionName = null)
    {
        return (bool)$this->startMail()
            ->assignDefaults()
            ->assignGeneralVariables()
            ->assignFiles()
            ->assignFilesStream()
            ->assignContent()
            ->sendMail();
    }

    /**
     * Get the Swift mail object.
     *
     * @return MailMessage
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * (re)create mail property.
     *
     * @return MailView
     */
    protected function startMail()
    {
        $this->mail = GeneralUtility::makeInstance(MailMessage::class);

        return $this;
    }

    /**
     * assign mail defaults.
     *
     * @return MailView
     */
    protected function assignDefaults()
    {
        $host = GeneralUtility::getIndpEnv('TYPO3_HOST');

        $this->mail->setFrom(['noreply@' . $host => 'Webseite ' . $host]);

        return $this;
    }

    /**
     * assign general variables.
     *
     * @return MailView
     */
    protected function assignGeneralVariables()
    {
        $variableContainer = $this->getTemplateVariableContainer();
        foreach ($variableContainer->getAllIdentifiers() as $identifier) {
            $methodName = 'set' . \ucfirst($identifier);
            if (\method_exists($this->mail, $methodName)) {
                \call_user_func([
                    $this->mail,
                    $methodName,
                ], $variableContainer->get($identifier));
            }
        }

        return $this;
    }

    /**
     * assign files.
     *
     * @return MailView
     */
    protected function assignFiles()
    {
        $variableContainer = $this->getTemplateVariableContainer();
        if ($variableContainer->exists('files')) {
            $files = $variableContainer->get('files');
            foreach ($files as $file) {
                $file = GeneralUtility::getFileAbsFileName($file);
                if (\is_file($file)) {
                    $this->mail->attachFromPath($file);
                }
            }
        }

        return $this;
    }

    /**
     * assign files from stream.
     *
     * @return MailView
     */
    protected function assignFilesStream()
    {
        $variableContainer = $this->getTemplateVariableContainer();
        if ($variableContainer->exists('filesStream')) {
            $filesStream = $variableContainer->get('filesStream');
            foreach ($filesStream as $filename => $data) {
                $this->mail->attachFromPath($data, $filename);
            }
        }

        return $this;
    }

    /**
     * assign content.
     *
     * @return MailView
     */
    protected function assignContent()
    {
        $html = parent::render();
        $request = $this->controllerContext->getRequest();
        $resetFormat = $request->getFormat();
        $request->setFormat('txt');
        if ($this->canRender($this->controllerContext)) {
            $txt = parent::render();
        }
        $request->setFormat($resetFormat);

        $this->mail->setBody($html, 'text/html');
        if (isset($txt) && \mb_strlen($txt)) {
            $this->mail->addPart($txt, 'text/plain');
        }

        return $this;
    }

    /**
     * Send mail or throw an exception.
     *
     * @throws \Exception
     *
     * @return int
     */
    protected function sendMail()
    {
        try {
            return $this->mail->send();
        } catch (\Exception $ex) {
            throw new \Exception('MailView: ' . $ex->getMessage());
        }
    }

    /**
     * Get template variable container.
     */
    private function getTemplateVariableContainer()
    {
        return $this->baseRenderingContext->getVariableProvider();
        //return $this->baseRenderingContext->getViewHelperVariableContainer();
        //return $this->baseRenderingContext->getTemplateVariableContainer();
    }
}
