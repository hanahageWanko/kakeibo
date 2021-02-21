<?php
class Application
{
    protected $debug = false;
    protected $request;
    protected $response;
    protected $session;
    protected $db_manager;
    protected $login_action = [];

    public function __construct($debug = false)
    {
        $this->setDebugMode($debug);
        $this->initialize();
        $this->configure();
    }

    protected function setDebugMode($debug)
    {
        if ($debug) {
            $this->debug = true;
            ini_set('display_errors', 1);
            error_reporting(-1);
        } else {
            $this->debug = false;
            ini_set('display_errors', 0);
        }
    }

    protected function initialize()
    {
        $this->session = new Session();
        $this->db_manager = new DbManager();
    }

    protected function configure()
    {
    }

    public function isDebugMode()
    {
        return $this->debug;
    }

    public function getRequest()
    {
        return $this->request;
    }


    public function getResponse()
    {
        return $this->response;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function getDbManager()
    {
        return $this->db_manager;
    }

    public function getControllerDir()
    {
        return $this->getRootDir() . '/controllers';
    }

    public function getViewDir()
    {
        return $this->getRootDir() . '/views';
    }

    public function getModelDir()
    {
        return $this->getRootDir() . '/models';
    }
}
