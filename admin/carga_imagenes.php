<?php
//$img = $_FILES['img'];
$img = $_FILES['selectfile'];
$id = $_POST['id'];

if(strlen($_FILES['selectfile']['name'])>1)
{
	copy($_FILES['selectfile']['tmp_name'], "galery/".$_FILES['selectfile']['name']);
		$imagen=$_FILES['selectfile']['name'];
	}
	else
	{$imagen="sin-imagen.png";}
    print_r($imagen);


/*

if(!empty($img))
{
    $img_desc = reArrayFiles($img);
    print_r($img);
    
    foreach($img_desc as $val)
    {
        move_uploaded_file($val['tmp_name'],'galery/'.$val['name']);
    }
}
*/
//header("Location: abm_imagenes.php");
//header("Location: wiz_cursos.php?indice=2&id=".$id);

function reArrayFiles($file)
{
    $file_ary = array();
    $file_count = count($file['name']);
    $file_key = array_keys($file);
    
    for($i=0;$i<$file_count;$i++)
    {
        foreach($file_key as $val)
        {
            $file_ary[$i][$val] = $file[$val][$i];
        }
    }
    return $file_ary;
}
?>