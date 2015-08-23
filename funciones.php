<?php


	function process (){

		 $salida=shell_exec('ps -e -o user,pid,%cpu,%mem,vsz,rss,tty,stat,start,time,ni,command');


//                $salida=shell_exec('ps faxu');
                $i=$j=$a=$m=$n=0;
                $user=$pid=$cpu=$mem=$vsz=$rss=$tty=$stat=$start=$time=$com=$conca='';
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

                                        $datos[$m][$n]=$valor2;
                                        $n++;

                                        }

                                }

                        }

                $datos[$m][$n]=$conca;
                $conca='';
                $j=0;
                $n=0;
                $m++;

                }


                echo"<table border=1><tr><td><b>USER</b></td><td><b>PID</b></td><td><b>%CPU</b></td><td><b>%MEM</b></td><td><b>VSZ</b></td><td><b>RSS</b></td><td><b>TTY</b></td><td><b>STAT</b></td><td><b>START</b></td><td><b>TIME</b></td><td><b>NI</b></td><td><b>COM</b></td></tr>";


                for($c=0;$c<($m-1);$c++){

                        echo"<tr>";

                        for($j=0;$j<12;$j++){


                                echo"<td>".$datos[$c][$j]."</td>";


                        }
                        echo"</tr>";


                }

                echo"</table>";
}
	
	





?>
