<?php

namespace OxygenModule\Security\Entity;

use DateTime;
use Doctrine\ORM\Mapping AS ORM;
use Oxygen\Data\Behaviour\Accessors;
use Oxygen\Data\Behaviour\PrimaryKey;

/**
 * @ORM\Entity
 * @ORM\Table(name="login_log")
 */
class LoginLog {

    use PrimaryKey, Accessors;

    /**
     * The login has succeded.
     *
     * @var string
     */

    const LOGIN_SUCCESS = 'loginSuccess';

    /**
     * The login has failed.
     *
     * @var string
     */

    const LOGIN_FAILED = 'loginFailed';

    /**
     * The logout has succeded.
     *
     * @var string
     */

    const LOGOUT = 'logout';

    /**
     * @ORM\Column(type="string")
     */

    protected $username;

    /**
     * @ORM\Column(type="datetime")
     */

    protected $timestamp;

    /**
     * @ORM\Column(type="string")
     */

    protected $ipAddress;

    /**
     * @ORM\Column(type="string")
     */

    protected $type;

    /**
     * Constructs a log entry.
     */

    public function __construct() {
        $this->timestamp = new DateTime();
    }

}