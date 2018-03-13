<?php
    class youtubeCookieAgree implements cookieAgreeInterface
    {
        /** @var modX $modx */
        public $modx;
        /** @var array $config */
        public $config;
       
        function __construct(modX &$modx, array $config = array())        {
            $this->modx =& $modx;
        }
        function process($str){
            $str = $this->modx->resource->_output;
            preg_match_all(' /<script src="https:\/\/apis\.google\.com\/js\/platform\.js".*<\/script>/isU', $str, $filenames);
            foreach($filenames[0] as $i => $iframe) {
                $src = $filenames[$i+1][0];
                $div = $this->prepare($iframe);
                $str = str_replace($iframe, $div, $str);  
            }
            return $str;

        }
        public function getJS($str)        {
            return " (tarteaucitron.job = tarteaucitron.job || []).push('gplus');";
        }
        public function prepare($s)        {
            return '';           
        }
}                