<?php

include ("process.php");
include ("find.php");
require "vendor/autoload.php";

header("Content-Type: application/json");

$app = new \Slim\Slim();
$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());

$auth= function(){
	$app = \Slim\Slim::getInstance();

	$req=$app->request();
	$key=$req->get('key');
	if($key==''){
		$app->render (401,array('msg'=>'Key incorrecto','error'=>'true'));
	}

	$conn = mysqli_connect('127.0.0.1','root','155070847','monitorreo');
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql="select * from users where pass=".$key;

	$result = $conn->query($sql);

	if($result->num_rows <= 0 ){
		$app->render (401,array('msg'=>'Key incorrecto','error'=>'true'));
	}


};

$app->get('/process',$auth,  function () use ($app)  { process($app);});

$app->get('/process/:pid',$auth,function($pid) use ($app) { find($pid,$app)
		;});

$app->delete('/process/:pid',$auth, function($pid) use ($app) {
		$str="kill -9 ".$pid." &> prueba";

		$salida=posix_kill($pid,9);		

		if($salida==1){

		$app->render (200,array('msg'=>'Proceso pid='.$pid.' eliminado','error'=>'false'));

		}

		else
		$app->render (202,array('msg'=>'error el proceso pid='.$pid.' no se pudo eliminar, verifique si existe','error'=>'true') );	

		});

$app->get('/pri/:pri/:pid',  function ($pri,$pid) use ($app) { 


		$par="sudo ./script/prueba.sh ".$pri." ".$pid;
		//echo $par;
		$salida=shell_exec($par);
		$app->render (200,array('msg'=>$salida,'error'=>'false') );
		echo $salida;	

		})
;

$app->get('/create/:crt', function($crt) use ($app) {
		$comando=$crt." &";
		$salida=shell_exec($comando);

		$app->render(200,array(
				'msg' => $salida,
				));
		});


$app->run();


?>


