<?

function auth(){
   	
	$app2 = \Slim\Slim::getInstance();
        $req=$app2->request();
        $key=$req->get('key');
        $key=md5($key);
        if($key==''){
                $app2->render (401,array('msg'=>'Key incorrecto','error'=>'true'));
        }

        $conn = mysqli_connect('127.0.0.1','root','155070847','monitoreo');
        if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
        }
        $sql="select * from users where pass='".$key."'";

        $result = mysqli_query($conn,$sql);
        $row_cnt = mysqli_num_rows($result);

        if($row_cnt == 0)
                $app2->render (401,array('msg'=>'Key incorrecto','error'=>'true'));

	mysqli_close($conn);


}





?>
