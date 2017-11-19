<?php
//print_r($_FILES);
if(isset($_FILES['image']))
{
    $errors=array();
    $allowed_ext= array('jpg','jpeg','png','gif');
    $file_name =$_FILES['image']['name'];
 //   $file_name =$_FILES['image']['tmp_name'];
    $file_ext = strtolower( end(explode('.',$file_name)));


    $file_size=$_FILES['image']['size'];
    $file_tmp= $_FILES['image']['tmp_name'];
    echo $file_tmp;echo "<br>";

    $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
    $data = file_get_contents( $file_tmp );
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    echo "Base64 is ".$base64;



    if(in_array($file_ext,$allowed_ext) === false)
    {
        $errors[]='Extension not allowed';
    }

    if($file_size > 2097152)
    {
        $errors[]= 'File size must be under 2mb';

    }
    if(empty($errors))
    {
       if( move_uploaded_file($file_tmp, 'images/'.$file_name));
       {
        echo 'File uploaded';
       }
    }
    else
    {
        foreach($errors as $error)
        {
            echo $error , '<br/>'; 
        }
    }
   //  print_r($errors);

}
?>
