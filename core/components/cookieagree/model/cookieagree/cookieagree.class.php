<?php
    interface cookieAgreeInterface
    {
        // public function initialize($ctx = 'web');
        public function process($str);
        public function getJS($str);
    }
    class cookieAgree 
    {
        /** @var modX $modx */
        public $modx;
        
        /**
            * @param modX $modx
            * @param array $config
        */
        function __construct(modX &$modx, array $config = array())        {
            $this->modx =& $modx;
            
            $corePath = $this->modx->getOption('cookieagree_core_path', $config,
            $this->modx->getOption('core_path') . 'components/cookieagree/'
            );
            $assetsUrl = $this->modx->getOption('cookieagree_assets_url', $config,
            $this->modx->getOption('assets_url') . 'components/cookieagree/'
            );
            $connectorUrl = $assetsUrl . 'connector.php';
            
            $this->config = array_merge(array(
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $connectorUrl,
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',
            ), $config);
            
            $this->modx->addPackage('cookieagree', $this->config['modelPath']);
            $this->modx->lexicon->load('cookieagree:default');
        }
        
        public function loadCustomClasses($type)        {
            if(file_exists($this->config['corePath'] .'custom/'.$type.'.class.php')){
                include_once($this->config['corePath'] .'custom/'.$type.'.class.php');
                } else {
                $this->modx->log(modX::LOG_LEVEL_ERROR, "[CookieAgree] Could not load custom class at ".$type.'.class.php');
            }
        }                       
    }              
