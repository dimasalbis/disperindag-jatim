<?php

namespace PHPMaker2023\pembuatan_mesin;

use LightSaml\State\Sso\SsoState;
use LightSaml\Store\Sso\SsoStateStoreInterface;
use LightSaml\State\Sso\SsoSessionState;

class SsoStateSessionStore implements SsoStateStoreInterface
{
    /** @var HttpSession */
    protected $session;

    /** @var string */
    protected $key;

    /**
     * Constructor
     *
     * @param HttpSession $session
     * @param string $key
     */
    public function __construct(HttpSession $session, $key)
    {
        $this->session = $session;
        $this->key = $key;
    }

    /**
     * Get SSO state
     *
     * @return SsoState
     */
    public function get()
    {
        $result = $this->session->get($this->key);
        if (null == $result) {
            $result = new SsoState();
            $this->set($result);
        }
        return $result;
    }

    /**
     * Set SSO state
     *
     * @param SsoState $ssoState
     * @return void
     */
    public function set(SsoState $ssoState)
    {
        $ssoState->setLocalSessionId($this->session->id());
        $this->session->set($this->key, $ssoState);
    }

    /**
     * Terminate session by IdP entity ID
     *
     * @param string $entityId IdP entity ID
     * @return int Number of terminated sessions
     */
    public function terminateSession($entityId)
    {
        $ssoState = $this->get();
        $count = 0;
        $ssoState->modify(function (SsoSessionState $session) use ($entityId, &$count) {
            if ($session->getIdpEntityId() == $entityId) {
                ++$count;
                return false;
            }
            return true;
        });
        $this->set($ssoState);
        return $count;
    }

    /**
     * Get SP session by IdP entity ID
     *
     * @param string $entityId IdP entity ID
     * @return SsoSessionState|null
     */
    public function getSpSession($entityId)
    {
        $ssoState = $this->get();
        $spSessions = $ssoState->filter($entityId, null, null, null, null);
        return array_shift($spSessions);
    }
}
