<?php
$cookieAgree = $modx->getService('cookieagree', 'cookieAgree', $modx->getOption('cookieagree.core_path', null, $modx->getOption('core_path') . 'components/cookieagree/') . 'model/cookieagree/', $scriptProperties);
    $config = $modx->getConfig();
    $settings = explode(',',$modx->getOption('cookieagree_services'));

    switch ($modx->event->name) {
        case 'OnWebPagePrerender':
        $str = $modx->resource->_output; 

        $StartupHTMLBlock ='
        <script type="text/javascript" src="'.$cookieAgree->config['assetsUrl'].'tarteaucitron.js"></script>
        <script type="text/javascript">
        tarteaucitron.init({
        "hashtag": "#tarteaucitron", /* Automatically open the panel with the hashtag */
        "highPrivacy": false, /* disabling the auto consent feature on navigation? */
        "orientation": "top", /* the big banner should be on top or bottom? */
        "adblocker": false, /* Display a message if an adblocker is detected */
        "showAlertSmall": true, /* show the small banner on bottom right? */
        "cookieslist": true, /* Display the list of cookies installed ? */
        "removeCredit": false /* remove the credit link? */
        });        ';
        $services= ''; 
        foreach($settings as $service){
            $cookieAgree->loadCustomClasses($service);
            $class = $service.'CookieAgree';
            $serv  = new $class($modx, $cookieAgree->config);
            $services.=$serv->getJS($str);
            $str=$serv->process($str);
        }
        $str2 = str_replace('</head>', $StartupHTMLBlock.$services."\n</script></head>", $str); 
        $modx->resource->_output =  preg_replace('/<script>\s*<\/script>/isU', '', $str2);
        break;
    }