<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'authTimeout' => 3600, // auth expire 4 hours
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
            'useCookies' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
            ],
        ],
    	'crawlerdetect' => [
    		'class' => 'alikdex\crawlerdetect\CrawlerDetect',
    		'setParams' => true, // optional, bootstrap initialize requred
    	]        
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'modules' => [
       'cookieconsent' => [
            'class' => '\pzavoli71\cookieconsent\Module',            
            'TextConsent' => [
                    'Testo' => "<b>Journey</b> site and and Partners (“We”) use cookies, to operate our website, to show you personalized content and manage our objectives as a business.<br/> You can find out more about how we use cookies below.
You can allow all cookies, select them individually or decline them all.",            
            ],
            'LinkPolicy' => '/cookiepolicy.html',
        ]        
    ],    
    'params' => $params,
];
