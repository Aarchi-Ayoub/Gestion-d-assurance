<?php 
    //Return all rows
    function returnAllResultat($table,$colone=null,$condition=null)
    {
        global $cnx;
        if($colone != null && $condition != null){
            $sql    = "SELECT * FROM $table WHERE $colone = $condition ";
        }else{
            $sql    = "SELECT * FROM $table";
        }        
        $req    = $cnx->prepare($sql);
        $req->execute();
        $rows    = $req->fetch();
        return $rows;
    }
    //Return column
    function returnOneColumn($table,$select,$colone,$condition)
    {
        global $cnx;
        $sql    = "SELECT $select FROM $table WHERE $colone = $condition ";
        $req    = $cnx->prepare($sql);
        $req->execute();
        $col    = $req->fetchColumn();
        return $col;
    }
    //Return count
    function returnCount($table,$select,$colone,$condition)
    {
        global $cnx;
        $sql    = "SELECT COUNT($select) FROM $table WHERE $colone = $condition ";
        $req    = $cnx->prepare($sql);
        $req->execute();
        $col    = $req->fetchColumn();
        return $col;
    }
    //Lister par order
    function byOrder($table,$select,$colone,$condition,$order,$type='DESC',$limit=10)
    {
        global $cnx;
        $sql    = "SELECT $select FROM $table WHERE $colone = $condition ORDER BY $order $type LIMIT $limit";       
        $req    = $cnx->prepare($sql);
        $req->execute();
        $rows    = $req->fetchAll();
        return $rows;
    }
    //Activé ou Non-activé
    function activate($status='1',$group,$type='DESC',$limit=10)
    {
        global $cnx;
        $sql    = "SELECT * FROM user WHERE Activate = $status AND GroupID = $group ORDER BY idUser $type LIMIT $limit";       
        $req    = $cnx->prepare($sql);
        $req->execute();
        $rows    = $req->fetchAll();
        return $rows;
    }
    function returnCountActivate($table,$select,$colone,$condition,$status = '1')
    {
        global $cnx;
        $sql    = "SELECT COUNT($select) FROM $table WHERE $colone = $condition AND Activate = $status ";
        $req    = $cnx->prepare($sql);
        $req->execute();
        $col    = $req->fetchColumn();
        return $col;
    }
    //Assurance
    function returnAssur ($table,$colone=null,$condition=null)
    {
        global $cnx;
        if($colone != null && $condition != null){
            $sql    = "SELECT * FROM $table WHERE $colone = ? ";
        }else{
            $sql    = "SELECT * FROM $table";
        }        
        $req    = $cnx->prepare($sql);
        $req->execute(array($condition));
        $rows    = $req->fetchAll();
        return $rows;
    }
    //Offre
    function returnOffre ($colone)
    {
        global $cnx;
        //JOIN
        $sql    = " SELECT * FROM insurance,offer
                    WHERE insurance.idAsr = offer.idAsr                    
                    AND insurance.Nom = ? ";
        $req    = $cnx->prepare($sql);
        $req->execute(array($colone));
        $rows    = $req->fetchAll();

        
        echo '<div class="container">
        <h1 class="display-2 text-center text-secondary">Product list</h1>';
        //return $rows;
        if(!$rows){
            echo '
            <div class="container"><div class="alert mt-5 alert-warning" role="alert">
                No offer for the moment !
            </div></div>';
        }else{
            echo '<div class="row row-cols-1 mt-2 row-cols-md-2">';
            foreach($rows as $row){
            ?>    
            <div class="col mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title  text-center"><?php echo $row['description'];if(!empty($row['rate'])){echo " <span class='offre-rate'>-".$row['rate']."%</span>";}?></h4>
                    </div>
                </div>
            </div>        
            <?php
                    }echo '</div>';
                }echo '</div>';
            }

?>
