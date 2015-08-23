<?php


include ("process.php");
include ("find.php");
require "vendor/autoload.php";

header("Content-Type: application/json");

$app = new \Slim\Slim();
$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());

$app->get('/process',  function () use ($app)  { process($app);});


$app->get('/find/:pid', function($pid) use ($app) { find($pid,$app); } );

$app->get('/kill/:pid', function($pid) use ($app) {
		$str="kill -9 ".$pid." &> prueba";
		
		$salida=posix_kill($pid,9);		

		if($salida==1){

		$app->render (200,array('msg'=>'Proceso eliminado','error'=>'false'));

		}

		else
		$app->render (202,array('msg'=>'error el proceso no se pudo eliminar, verifique si existe','error'=>'true') );	
			
});

$app->get('/pri/:pri/:pid',  function ($pri,$pid) use ($app) { 

			
		$par="sudo ./script/prueba.sh ".$pri." ".$pid;
		//echo $par;
		$salida=shell_exec($par);
		 $app->render (200,array('msg'=>$salida,'error'=>'false') );
		echo $salida;	
	
})
;

$app->get('/', function() use ($app) {
        $app->render(200,array(
                'msg' => 'welcome to my API!',
            ));
    });


$app->run();


?>


