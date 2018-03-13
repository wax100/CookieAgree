<?php
    class googleanalyticsCookieAgree implements cookieAgreeInterface
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
            preg_match_all("/\(function\(i,s,o,g,r,a,m\).*'UA[^\'].*'pageview'\);/isU", $str, $filenames);
         
            //\bua-\d{4,9}-\d{1,4}\b
            foreach($filenames[0] as $i => $iframe) {
                 $div = $this->prepare($iframe);
              $str = str_replace($iframe, $div, $str);  
            }
            return $str;
        }
        public function getJS($str) {
 
       $start = strpos($str,'UA-');
         $s = substr($str, $start, 13);
        
        return "tarteaucitron.user.analyticsUa = '".$s."';
            tarteaucitron.user.analyticsMore = function () { /* add here your optionnal ga.push() */ };
            (tarteaucitron.job = tarteaucitron.job || []).push('analytics');
            </script>";
        }
        public function prepare($str)        {
        return '';
           
        }
        
    }            