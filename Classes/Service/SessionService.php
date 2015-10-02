<?php
/**
 * SessionService.php
 * @package    Hdnet
 * @author     Tim Spiekerkoetter
 */

namespace HDNET\Faq\Service;

/**
 * SessionService
 *
 * @author     Tim Spiekerkoetter
 */
class SessionService extends AbstractService
{

    /**
     * @var \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
     */
    protected $frontendUser;

    public function initializeObject()
    {
        $this->frontendUser = $GLOBALS['TSFE']->fe_user;
    }

    /**
     * @param string $sessionIdentifier
     * @param mixed $value
     * @return mixed
     */
    public function setAndGet($sessionIdentifier, $value)
    {
        if (!$this->has($sessionIdentifier)) {
            $this->set($sessionIdentifier, $value);
        }
        return $this->get($sessionIdentifier);
    }

    /**
     * @param $sessionIdentifier
     * @return bool
     */
    public function has($sessionIdentifier)
    {
        return (bool)$this->get($sessionIdentifier);
    }

    /**
     * @param string $sessionIdentifier
     * @return mixed
     */
    public function get($sessionIdentifier)
    {
        return $this->frontendUser->getSessionData($sessionIdentifier);
    }

    /**
     * @param string $sessionIdentifier
     * @param mixed $value
     */
    public function set($sessionIdentifier, $value)
    {
        $this->frontendUser->setAndSaveSessionData($sessionIdentifier, $value);

    }
}
