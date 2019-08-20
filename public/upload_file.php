<?php
    function is_valid_file_type($file_type):bool 
    {
	if (($file_type == "image/gif")
            || ($file_type == "image/jpeg")
	    || ($file_type == "image/jpg")
	    || ($file_type == "image/png")
	    || ($file_type == "image/doc")
	    || ($file_type == "application/pdf")
	    || ($file_type == "application/wps-office.pptx")
	    || ($file_type == "application/wps-office.xlsx")
	    || ($file_type == "application/wps-office.docx")
	    || ($file_type == "application/wps-office.ppt")
	    || ($file_type == "application/wps-office.xls")
	    || ($file_type == "application/wps-office.doc")){
	    return True;
	}else{
	    return False;
	}
    }

    function is_valid_file($file_type, $size):bool {
        echo "type=".$file_type.", ";
        echo "size=".$size;

        if (is_valid_file_type($file_type)
            && ($size < 10*1024*1024)){
            return True;
        }else{
            return False;
        }
    }

    function gen_filename():string {
    	return strtotime(date("Y-m-d H:i:s"));
    }

    $target_path = "/var/www/public/upload/";
    $size = $_FILES["file"]["size"];
    $file_type = $_FILES["file"]["type"];
    if (is_valid_file($file_type, $size)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        }else{
            echo "Upload: " . $_FILES["file"]["name"] . "<br />";
            echo "Type: " . $_FILES["file"]["type"] . "<br />";
            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
            echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
	    $name = $_FILES["file"]["name"];
	    $re = strpos($name, ".");
	    if ($re !== False){
	    	$name = substr($name, $re);
	    }

	    $store_filename = gen_filename() . $name;
	    echo "store_filename=".$store_filename . "<br />";

            if (file_exists($target_path. $store_filename)) {
                echo $store_filename . " already exists. ";
            }else{
                move_uploaded_file($_FILES["file"]["tmp_name"],
                $target_path . $store_filename);
                echo "Stored in: " . $target_path . $store_filename;
            }
        }
    }else{
        echo "Invalid file";
    }
?>
