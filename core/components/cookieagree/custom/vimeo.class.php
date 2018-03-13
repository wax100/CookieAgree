<?php
    class vimeoCookieAgree implements cookieAgreeInterface
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
            preg_match_all(' /<iframe.*src=\"[^\"]*vimeo.*><\/iframe>/isU', $str, $filenames);
            foreach($filenames[0] as $i => $iframe) {
                $src = $filenames[$i+1][0];
                $div = $this->prepare($iframe);
                $str = str_replace($iframe, $div, $str);  
            }
            return $str;
        }
        public function getJS($str)        {
            return "(tarteaucitron.job = tarteaucitron.job || []).push('vimeo');";
        }
        public function prepare($s)        {
            return preg_replace(
            '@^<iframe \s*width="(.*)"\s*height="(.*)"\s*src="(.*?)"\s*(.*?)</iframe>$@s',
            '<div class="vimeo_player" videoID="\3" width="\1" height="\2"></div>',
            $s
            );           
        }
}                