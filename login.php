<?php

    session_start();

    $link=mysqli_connect("localhost","root","","pocketmanager");
    if(mysqli_connect_error()){
		die("Connection Failed");
	}
    $query="";
    $result="";
    if($_POST){
        $type=$_POST["sg"];
        if($type=="userSignup"){
            $mail=$_POST["semail"];
            $fname=$_POST["fname"];
            $pass=$_POST["spassword"];
            $lname=$_POST["lname"];
            $query="select * from users where email='".mysqli_real_escape_string($link,$mail)."'";


            if(!mysqli_query($link,$query)){
                echo "Failure";
            }
            else{
                $result=mysqli_query($link,$query);
                if(mysqli_num_rows($result)==0){
                    
                    $query="insert into users(fname,lname,email,password) values('$fname','$lname','$mail','$pass')";
                    if($result=mysqli_query($link,$query)){
                        $_SESSION['userName']=$fname;
                        //echo"Account Created";
                        header("Location: indeX_.php?accCreatedSuccessfull");
                    }
                    else{
                        
                        //echo"Account not Created";
                        header("Location: indeX_.php?accCreationFailed");
                    }
                }
                else{
                    //echo "User already present";
                    header("Location: indeX_.php?accCreationFailed");
                }
            } 
        }
        else if($type=="userLogin"){
            $mail=$_POST["lemail"];
            $pass=$_POST["lpassword"];
            $query="select * from users where email='".mysqli_real_escape_string($link,$mail)."' and password='".$pass."' limit 1";
            $result=mysqli_query($link,$query);
           // print_r("Result:".$result);
            if (!$result) {
                echo("Error: %s\n");
                exit();
            }
            //echo mysqli_num_rows($result);
            $row=mysqli_fetch_array($result);
            $userName=$row['fname'];


            if(!$userName){
                echo "Failure";
            }
            else{
                $_SESSION['userName']=$userName;
                header("Location: indeX_.php?".$userName);

            } 
        }
        
           
        
    }
   

?>