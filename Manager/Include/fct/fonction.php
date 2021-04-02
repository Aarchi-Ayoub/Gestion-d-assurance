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
    function returnCount($table,$select,$colone=null,$condition=null)
    {
        global $cnx;
        if($colone !=null && $condition != null){
            $sql    = "SELECT COUNT($select) FROM $table WHERE $colone = $condition ";
        }else{
            $sql    = "SELECT COUNT($select) FROM $table ";
        }
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
?>
