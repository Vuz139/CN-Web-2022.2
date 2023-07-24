<?php 
    class Controller extends SQLQuery{
        protected $_model;
        protected $_controller;
        protected $_action;
        protected $_template;
        
        protected $Item;

        function __construct($model, $controller, $action) {
            $this->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $this->_controller = $controller;
            $this->_model = $model;
            $this->_action = $action;

            $this->$model =  new $model;
            $this->_template =  new Template($controller, $action);

        }

        function set($name, $value) {
            $this->_template->set($name, $value);
        }

        function __destruct() {
            $this->_template->render();
        }
    }
