<?php

namespace SMSApi\Api\Action\User;

/**
 * Class Edit
 * @package SMSApi\Api\Action\User
 */
class Edit extends Add {

    /**
     * @deprecated since v1.0.0 use User::filterByUsername
     * @param $username
     * @return $this
     */
    public function setUsername( $username ) {
        $this->params[ "set_user" ] = $username;
        return $this;
    }

    /**
     * Set when subuser has no main account username prefix
     *
     * @param $username string
     * @return $this
     */
    public function setUsernamewithoutPrefix( $username )
    {
        $this->params[ "set_user" ] = $username;
        $this->params['without_prefix'] = 1;
        return $this;
    }

    /**
     * Set username to edit account.
     *
     * @param string $username user name to edit
     * @return $this
     */
    public function filterByUsername( $username ) {
        $this->params[ "set_user" ] = $username;
        return $this;
    }

}

