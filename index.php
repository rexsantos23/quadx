<?php

require './vendor/autoload.php';

//URI Object
$uri = Zend\Diactoros\ServerRequestFactory::fromGlobals()->getUri();

$debug = new DebugBar\StandardDebugBar();
$debug->getJavascriptRenderer()->setBaseUrl($uri->withPort('8000')->withPath('/'));

//middleware
$handler = GuzzleHttp\HandlerStack::create();

/*$middleware = new GuzzleHttp\Profiling\Middleware(
    new GuzzleHttp\Profiling\Debugbar\Profiler(
        $debug->getCollector('time')
    )
);

$handler->unshift($middleware);*/

$controller = new Controller\OrderController(
	$debug->getJavascriptRenderer()
);

$response = $controller->index();

(new Zend\Diactoros\Response\SapiEmitter())->emit($response);

?>