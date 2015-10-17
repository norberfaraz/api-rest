<?php


function find($pid,$app){

	$salida=shell_exec('ps -e -o user,pid,%cpu,%mem,vsz,rss,tty,stat,start,time,ni,command'); 
	//$salida=shell_exec('ps faxu'); 
	$saltos=preg_split("[\n]",$salida); 
	$i=$x=$j=$n=$m=$jo=$cont=$ent=0; 
	$conca=$mes='';
	foreach($saltos as $valor){ 
		if($x==1)        
			break; 


		$space=preg_split("[\s]",$valor); 
		foreach($space as $valor2 ){ 
			if($i==0) {
				$cab=$valor; 
				$jo++; 
				$i=1; 
				continue;	
			}

			if($jo!=0){ 

				if($valor2!=""){ 

					if (strcmp($valor2,$pid)==0){    
						$space=preg_split("[\s]",$valor);
						foreach($space as $valor2){
							if($j==0){

								$datos[$m][$n]=$valor2;
								$n++;
								$j=1;

							}

							else if($n==12 && $j=!0)
							{

								$conca=$conca." ".$valor2;


							}

							else{
								if($valor2 !="" && $n<12){


									if($cont==7 || $ent==1 )
									{

										if(strlen($valor2)>4 && $ent==0){
											$datos[$m][$n]=$valor2;
											$n++;
											$cont=-2;

										}
										else{
											if($ent==0){
												$mes=$valor2;
												$ent=1;
											}
											else{


												$mes=$mes." ".$valor2;
												//      $app->render(200,array('meses'=>'meses='.$mes.'valor2='.$valor2.'asdasd'));
												$datos[$m][$n]=$mes;
												$n++;
												$cont=-10;
												$ent=0;

											}

										}



									}

									else{

										$datos[$m][$n]=$valor2;
										$n++;
										$cont++;
									}



									//$datos[$m][$n]=$valor2;
									//$n++;

								}
							}
						}

						$datos[$m][$n]=$conca;
						$conca='';
						$j=0;
						$n=0;

						$x=1;     





						$process[]= array('USER'=>$datos[0][0],'PID'=>$datos[0][1],'%CPU'=>$datos[0][2],'%MEM'=>$datos[0][3],'VSZ'=>$datos[0][4],'RSS'=>$datos[0][5],'TTY'=>$datos[0][6],'STAT'=>$datos[0][7],'START'=>$datos[0][8],'TIME'=>$datos[0][9],'NI'=>$datos[0][10],'COMAND'=>$datos[0][11]);

						return $process;						

						//$app->render (200,array('process'=>$process));


					}        

				} 

			} 

		}        

	} 

	if($x==0)        
		return null;	
	//   $app->render (202,array('msg'=>'Proceso inexistente','error'=>true));

}


?>
