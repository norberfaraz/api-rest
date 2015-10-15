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

$app->get('/process',$auth, function () use ($app)  { process($app,null);});

$app->get('/process/:pid',$auth,function($pid) use ($app) { 

	if(is_numeric($pid)){ 
	$process=find($pid,$app);
	if($process!=null)
           $app->render (200,array('process'=>$process));
	else
 	   $app->render (202,array('msg'=>'Proceso inexistente','error'=>true));


	}
	else
	process($app,$pid);
		
});

$app->delete('/process/:pid',$auth, function($pid) use ($app) {
		$mypid=getmypid();
		if($mypid==$pid){
		$app->render (202,array('msg'=>'Proceso pid='.$pid.' no pude ser eliminado','error'=>'true'));
		}
		else{	

		$str="kill -9 ".$pid." &> prueba";


		$salida=posix_kill($pid,9);		

		if($salida==1){

		$app->render (200,array('msg'=>'Proceso pid='.$pid.' eliminado','error'=>'false'));
		}


		else
		$app->render (202,array('msg'=>'error el proceso pid='.$pid.' no se pudo eliminar, verifique si existe','error'=>'true'));	


		}	

});

$app->put('/process/:pid', function ($pid) use ($app) { 

		$process=find($pid,$app);
		if($process!=null){
			$put=$app->request();
		        $ni=$put->put('ni');
//			$app->render (202,array('msg'=>$ni,'error'=>'false'));
			if(is_numeric($ni)){
				if(((int)$ni)>-21 && ((int)$ni)<21){


					




					$par="sudo renice ".$ni." ".$pid;
					$salida=shell_exec($par);
					$app->render (200,array('msg'=>$salida,'error'=>'false'));
				}
				else
					$app->render (202,array('msg'=>'la variable ni(prioridad) no esta bien definida, debe ser un valor numerico entre 20 y -20 2 ' ,'error'=>'true') );

			}
			else
				$app->render (202,array('msg'=>'la variable ni(prioridad) no esta bien definida, debe ser un valor numerico entre 20 y -20  1 '.$ni.'h','error'=>'true'));

		}

		else
			$app->render (202,array('msg'=>'Proceso inexistente','error'=>true));


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


