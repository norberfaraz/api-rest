<?php

function process ($app,$users){


	$salida=shell_exec('ps -e -o user,pid,%cpu,%mem,vsz,rss,tty,stat,start,time,ni,command');
	//     $salida=shell_exec('ps faxu');
	$i=$j=$a=$m=$n=$mrc=$usr=$cont=$ent=0;
	$vari=12;
	$mes=$user=$pid=$cpu=$mem=$vsz=$rss=$tty=$stat=$start=$time=$com=$conca='';
	$saltos=preg_split("[\n]",$salida);

	foreach($saltos as $valor){
		if($i==0){
			$i=1;
			continue;
		}

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

				}

			}

		}

		$datos[$m][$n]=$conca;
		$conca='';
		$j=0;
		$n=0;
		$m++;
		$cont=0;

	}


	if($users==null){
		for($c=0;$c<($m-1);$c++){

			$process[]= array('USER'=>$datos[$c][0],'PID'=>$datos[$c][1],'%CPU'=>$datos[$c][2],'%MEM'=>$datos[$c][3],'VSZ'=>$datos[$c][4],'RSS'=>$datos[$c][5],'TTY'=>$datos[$c][6],'STAT'=>$datos[$c][7],'START'=>$datos[$c][8],'TIME'=>$datos[$c][9],'NI'=>$datos[$c][10],'COMAND'=>$datos[$c][11]);

		}

		$app->render(200,array('process'=>$process));

	}
	else{
		for($c=0;$c<($m-1);$c++){

			if($datos[$c][0]==$users){
				$process[]= array('USER'=>$datos[$c][0],'PID'=>$datos[$c][1],'%CPU'=>$datos[$c][2],'%MEM'=>$datos[$c][3],'VSZ'=>$datos[$c][4],'RSS'=>$datos[$c][5],'TTY'=>$datos[$c][6],'STAT'=>$datos[$c][7],'START'=>$datos[$c][8],'TIME'=>$datos[$c][9],'NI'=>$datos[$c][10],'COMAND'=>$datos[$c][11]);
				$usr++;
			}
		}
	if($usr>0)
		$app->render(200,array('process'=>$process));

	else
		$app->render(202,array('msg'=>'No hay procesos para mostrar para el usurio:'.$users));

	}
}

?>
