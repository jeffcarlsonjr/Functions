<?php

class galleries extends photos
{
     protected $crud;
     
         
     public function __construct() {
        if(isset($_POST['addGallery']))
        {
            $this->addGallery();
        }
        
        $this->crud = new CRUD();
     }
     
     public function addGallery()
    {
        $query = "INSERT INTO gallery SET 
                    name = '".$_POST['albumName']."', 
                    description = '".$_POST['albumDescription']."', 
                    date_event = '".$_POST['albumDate']."', 
                    date_added= NOW()";
        mysql_query($query) or die(mysql_error());
        
        $gal_id = mysql_insert_id();
        $this->addGalleryFirstPhoto($gal_id);
    }
    
    
    public function displayGalleryAdmin()
    {
        
        $result = $this->crud->selectOrderBy('gallery','ORDER BY date_event ASC');
        while($row = mysql_fetch_assoc($result))
        {
            echo "<div class='albumDisplay'>";
            
            $q = $this->crud->multiSelect("img", "gal_id = '".$row['gal_id']."' LIMIT 1");
            while($r = mysql_fetch_assoc($q))
            {
                echo "<a href='photos.php?gal_id=".$row['gal_id']."'><img src='../images/gallery/".$r['string']."' width='150' height='auto' border='0'/></a><br/>";
            }
            echo "<div class='albumName'><a href='photos.php?gal_id=".$row['gal_id']."'>".$row['name']."</a></div>";
            echo "<div class='albumDate'>Created ".date('M-d-Y', strtotime($row['date_added']))."</div><br/>";
            echo "<a href='photos.php?gal_id=".$row['gal_id']."'>Add More Photos</a>";
            echo "</div>";
        }
    }
    
    public function showGalleryAdmin($id)
    {
        
        $result = $this->crud->multiSelect("gallery","gal_id = '".$id."' ");
        while($row = mysql_fetch_assoc($result))
        {
            echo "<h2>".$row['name']."</h2>";
            $q = $this->crud->multiSelect("img", "gal_id = '".$row['gal_id']."' ");
            while($r = mysql_fetch_assoc($q))
            {
                if($r['width'] > '300')
                    {
                    echo "<div class='imageDisplay'><img src='../images/gallery/".$r['string']."'  border='0' class='centered'  /></div></a>";
                }
                elseif($r['width'] < '300') 
                    {
                    echo "<div class='imageDisplay'><img src='../images/gallery/".$r['string']."'  border='0' width='300' height='250' class='centered' /></div></a>";
                    }
            }
        }
    }
    
    public function displayGallery()
    {
        
        $result = $this->crud->selectOrderBy('gallery','ORDER BY date_event ASC');
        while($row = mysql_fetch_assoc($result))
        {
            echo "<div class='albumDisplay'>";
            
            $q = $this->crud->multiSelect("img", "gal_id = '".$row['gal_id']."' LIMIT 1");
            while($r = mysql_fetch_assoc($q))
            {
                echo "<a href='photos.php?img_id=".$r['img_id']."'><img src='../images/gallery/".$r['string']."' width='150' height='auto' border='0'/><br/>";
            }
            echo "<div class='albumName'>".$row['name']."</div></a>";
            echo "<div class='albumDate'>Created ".date('M-d-Y', strtotime($row['date_added']))."</div><br/>";
            
            echo "</div>";
        }
    }
    
    public function displayGalleryName($id)
    {
        ;
        $result = $this->crud->select('gallery', 'gal_id='.$id);
        
        return $result['name'];
    }
    
    public function displayMainPhoto($id)
    {
        
        $row = $this->crud->select('img', 'img_id = '.$id);
        
        if($row['height'] < $row['width'])
        {
          echo '<img src="./images/gallery/'.$row['string'].'" width="600" height="450"/>';
        }
        elseif($row['height'] > $row['width']) 
            {
              echo '<div class="tallPhoto">';
              echo '<img src="./images/gallery/'.$row['string'].'" width="345" height="450"/>';
              echo '</div>';
              
            }
             
    }
    
    public function displayThumbs($id)
    {
        $galResult = $this->crud->select('img', 'img_id = '.$id);
        $result = $this->crud->multiSelect('img', 'gal_id = '.$galResult['gal_id']);
         while($row = mysql_fetch_assoc($result))
            {
                $this->string = $row['string'];
                $this->id = $row['img_id'];
                echo "<div style='width:75px; float:left; border: thin solid #fff'>";
                echo "<a href='photos.php?img_id=$this->id'>";
                echo "<img src='./images/gallery/$this->string' width='75' height='75' />";
                echo "</a>";
                echo "</div>";
            }
                                 
    }
    
    public function photoScroll($id)
    {
//        $q = mysql_query("SELECT gal_id FROM img WHERE img_id = '".$img_id."'");
//                       $r = mysql_fetch_assoc($q);
        $r = $this->crud->select('img', 'img_id = '.$id);
        
        $photo_result = $this->crud->multiSelect('img', 'gal_id = '.$r['gal_id']);
        while($row=mysql_fetch_array($photo_result)) {
           $photos[]=$row[0];
        }
        $count = count($photos);
        echo $count." Photos &nbsp;&nbsp;&nbsp;";

        $current = $id; // whatever your position is in the photo array
        $next = ($current+1); // modulo
        $prev = ($current-1);

        $photoidforward = end($photos);
        $photoidback = reset($photos);

        if($next > $photoidforward)
        {
            echo "<a href='photos.php?img_id=$prev'>Previous</a>";
        }
        elseif($photoidback > $prev)
        {
            echo "<a href='photos.php?img_id=$next'>Next</a>";
        }
        else
        {
            echo "<a href='photos.php?img_id=$prev'>Previous</a> | <a href='photos.php?img_id=$next'>Next</a>";
        }
    }
}
?>
