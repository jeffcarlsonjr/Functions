<?php


class News
{
    public function custom_echo($x)
    {
        if(strlen($x)<=75)
        {
          echo $x;
        }
        else
        {
          $y=substr($x,0,75) . '...';
          echo $y;
        }
    }
    
//    public function displayNews()
//    {
//        $crud = new CRUD();
//        
//        $crud->multiSelectNoWhere('CRCNEWS');
//    }
        
}


?>
