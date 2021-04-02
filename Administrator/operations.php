<?php 
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }else{
        include 'add.php';
        $direction = isset($_GET['dir'])? $_GET['dir'] :'';
        if($direction == 'add'){
            $type = isset($_GET['type'])? $_GET['type'] :'';
            if($type == 'Vechil'){
                include 'form.php';
            }elseif($type == 'Home'){
                include 'form.php';
            }elseif($type == 'Hobbies'){
                include 'form.php';
            }elseif($type == 'Helath'){
                include 'form.php';
            }
        }else{
            
                $option = isset($_GET['opt'])? $_GET['opt'] :'';
                if($option == ''){
        ?>
<div class="container">
    <h1 class="display-2 text-center text-secondary">Liste des produits</h1>
<?php
            $rows    = returnAssur ('insurance');
            if(!$rows){
                echo '<div class="container"><div class="alert mt-5 alert-danger" role="alert">
                    Url no-valid!
                </div></div>';
            }else{
                echo '<div class="row row-cols-1 row-cols-md-2">';
                foreach($rows as $row){
?>    
<div class="col mb-4">
    <div class="card">
        <img src="../Upload/imgs/<?php echo $row['Image'];?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title text-center"><a href="?opt=<?php echo $row['Nom'];?>"><?php echo $row['Nom'];?></a></h5>
            <p class="card-text"><?php echo $row['Description'];?></p>
        </div>
    </div>
</div>        
<?php
                }
                echo '</div>';
            }
            echo '</div>';
            }elseif($option == 'Home'){
                returnOffre ($option); 
            }elseif($option == 'Helath'){
                returnOffre ($option);
            }elseif($option == 'Vechil'){
                returnOffre ($option);
            }elseif($option == 'Hobbies'){
                returnOffre ($option);
            }else{
                echo '
                <div class="container"><div class="alert mt-5 alert-danger" role="alert">
                    url no-valid ! <strong>Error 404</strong>
                </div></div>';
            }
    }
}
    include "Include/template/footer.php";
?>
