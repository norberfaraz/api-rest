<?php
function renice($pid,$app){


                $process=find($pid,$app);
                if($process!=null){
                        $put=$app->request();
                        $ni=$put->put('ni');
                        if(is_numeric($ni)){
                                if(((int)$ni)>-21 && ((int)$ni)<20){

                                        $par="sudo renice ".$ni." ".$pid;
                                        $salida=shell_exec($par);
                                        if($salida==null){
                                       		$salida="No tiene permisos para repriorizar el proceso con ID:".$pid;
                                        	$app->render (202,array('msg'=>$salida,'error'=>'true'));
					}
					else						
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

}
?>
