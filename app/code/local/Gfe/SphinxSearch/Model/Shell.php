<?php

class Gfe_SphinxSearch_Model_Shell
{
    const DEFAULT_PORT = 3879;

    protected $session = NULL;

    public function connect($params = array())
    {
        if (!is_null($this->session)) {
            return $this->session;
        }

        !isset($params['port']) && $params['port'] = self::DEFAULT_PORT;

        $session = ssh2_connect($params['host'], $params['port']);
        if ($session === false) {
            return false;
        }

        $auth = ssh2_auth_password($session, $params['user'], $params['password']);
        if ($auth === false) {
            return false;
        }
        $this->session = $session;

        return $this->session;
    }

    public function execute($command)
    {
        $session = $this->connect();
        return $session === false ? false : ssh2_exec($session, $command);
    }
}