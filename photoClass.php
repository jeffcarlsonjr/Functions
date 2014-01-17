<?php

class photos
{
    
    private $target_path ="../images/gallery/"; 
    
    public function __construct() {
     
     if(isset($_POST['addPhoto']))
     {
         $this->addPhoto();
     }
     
     
    }
    
    
    public function addGalleryFirstPhoto($id){
        
        $checkimage = $_FILES['thePhoto']['name'];
        list($name,$ext)= explode(".", strtolower($checkimage));
        
        if (($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif") || ($ext == "tiff"))
            {
                $newTargetPath = $this->target_path .basename($checkimage);

                if(move_uploaded_file($_FILES['thePhoto']['tmp_name'], $newTargetPath)) {
                 list($width,$height) = getimagesize($newTargetPath);
                    mysql_query("INSERT INTO img SET 
                                    gal_id = '".$id."', 
                                    string = '".$checkimage."', 
                                    width = '".$width."', 
                                    height = '".$height."', 
                                    date_uploaded = NOW(); "
                            );
                }
                
             }
    }
    
    public function addPhoto()
    {
        $checkImage = $_FILES['thePhoto']['name'];
        list($name,$ext) = explode(".", strtolower($checkImage));
        if (($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif") || ($ext == "tiff"))
            {
                
                $newTargetPath = $this->target_path .basename( $_FILES['thePhoto']['name']);
                
                if(move_uploaded_file($_FILES['thePhoto']['tmp_name'], $newTargetPath))
                {
                list($width,$height) = getimagesize($newTargetPath);
                mysql_query("INSERT INTO img SET 
                                gal_id = '".$_SESSION['gal_id']."', 
                                string = '".$checkImage."', 
                                width = '".$width."', 
                                height = '".$height."', 
                                date_uploaded = NOW(); "
                        );
                }
            }
    }
    
    public function multipleAddPhoto()
    {
        foreach($_FILES['thePhoto']['tmp_name'] as $key =>$tmpName)
                {
                    $checkImage = $key.$_FILES['thePhoto']['name'][$key];
                    $checkImage = substr($checkImage, 1);
                    $fileTmp = $_FILES['thePhoto']['tmp_name'][$key];
                    
                    
                    list($name,$ext) = explode(".", strtolower($checkImage));
                    if (($ext == "jpg") || ($ext == "jpeg") || ($ext == "png") || ($ext == "gif") || ($ext == "tiff"))
                        {
                            
                        $newTargetPath = $this->target_path .basename($checkImage);

                            if(move_uploaded_file($fileTmp,$newTargetPath))
                            {
                            list($width,$height) = getimagesize($newTargetPath);
                            mysql_query("INSERT INTO img SET 
                                            gal_id = '".$_SESSION['gal_id']."', 
                                            string = '".$checkImage."', 
                                            width = '".$width."', 
                                            height = '".$height."', 
                                            date_uploaded = NOW(); "
                                    );
                            
                            
                            }
                        }
                }
    }
    
    
}
?>
