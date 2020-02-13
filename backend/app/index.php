<?php
require 'config.php';
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->post('/login','login');
$app->post('/register','register');
$app->post('/gethomepage','gethomepage');
$app->post('/categoryfilter','categoryfilter');
$app->post('/placeorder','placeorder');
$app->post('/getnotification','getnotification');
$app->post('/fetchorder','fetchorder');
$app->post('/fetchorderdetail','fetchorderdetail');
$app->post('/sendmessage','sendmessage');
$app->post('/sendfeedback','sendfeedback');
$app->post('/searchproduct','searchproduct');
$app->post('/offers','offers');
$app->run();

/**********************  LOGIN *********************/

function register() {
    
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    
    try {
        
        $db = getDB();
        $userData ='';
        $sql = "INSERT INTO users(fname, email, mobile, password, address)VALUES(:fname,:email,:mobile, :password, :address)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fname", $data->name,PDO::PARAM_STR);
        $stmt->bindParam("email", $data->email,PDO::PARAM_STR);
        $stmt->bindParam("mobile", $data->mobile,PDO::PARAM_STR);
        $stmt->bindParam("password", $data->password,PDO::PARAM_STR);
        $stmt->bindParam("address", $data->address,PDO::PARAM_STR);
        $stmt->execute();
         if($lastid = $db->lastInsertId()){
                echo '{"userData": "registered"}';
                $db = null;
            } else {
               echo '{"error":{"text":"Bad request"}}';
            }

           
    }
    catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}



function login() {
    
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    
    try {
        
        $db = getDB();
        $userData ='';
        $sql = "SELECT user_id,fname,email,mobile,address FROM users WHERE email=:email and password=:password ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("email", $data->email, PDO::PARAM_STR);
        $stmt->bindParam("password", $data->password, PDO::PARAM_STR);
        $stmt->execute();
        $mainCount=$stmt->rowCount();
        $userData = $stmt->fetch(PDO::FETCH_OBJ);
        
        if(!empty($userData))
        {
            $user_id=$userData->user_id;
            $userData->token = apiToken($user_id);
        }
        
        $db = null;
         if($userData){
               $userData = json_encode($userData);
                echo '{"userData": ' .$userData . '}';
            } else {
               echo '{"error":{"text":"Bad request"}}';
            }

           
    }
    catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


function gethomepage(){

    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $systemToken=apiToken($data->user_id);
    $homepage = "YES";
    
    try {
        if($token == $systemToken){
            $db = getDB();
            $sqlhome = "SELECT * FROM items WHERE homepage = :homepage ORDER BY rand()";
            $stmthome = $db->prepare($sqlhome);
            $stmthome->bindParam("homepage",$homepage, PDO::PARAM_STR);
            $stmthome->execute();
            $tempData = $stmthome->rowCount();
            $homeData = $stmthome->fetchAll(PDO::FETCH_OBJ);

            $sqlcate = "SELECT * FROM category";
            $stmtCate = $db->prepare($sqlcate);
            $stmtCate->execute();
            $catetempData = $stmtCate->rowCount();
            $CateData = $stmtCate->fetchAll(PDO::FETCH_OBJ);
            
            $sqlbanner = "SELECT * FROM banner ORDER BY rand()";
            $stmtbanner = $db->prepare($sqlbanner);
            $stmtbanner->execute();
            $bannertempData = $stmtbanner->rowCount();
            $bannerData = $stmtbanner->fetchAll(PDO::FETCH_OBJ);
            
            $db = null;

            echo '{
                "HomeData": '. json_encode($homeData) .' ,
                "CateData": '. json_encode($CateData) .' ,
                "BannData": '. json_encode($bannerData) .' 
            }';
                }
            else{
                echo '{"Error":"Error"}'; 
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    } 
}

function getnotification(){

    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $systemToken=apiToken($data->user_id);
    
    try {
        if($token == $systemToken){
            $db = getDB();
            $sqlhome = "SELECT * FROM notification ORDER BY id DESC";
            $stmthome = $db->prepare($sqlhome);
            $stmthome->execute();
            $NotiData = $stmthome->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"NotiData": ' . json_encode($NotiData) . '}';
            }
            else{
                echo '{"Error":"Error"}'; 
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    } 

}


function fetchorder(){

    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $userid=$data->user_id;
    $systemToken=apiToken($data->user_id);
    
    try {
        if($token == $systemToken){
            $db = getDB();
            $sqlorder = "SELECT * FROM orders WHERE user_id = :userid ORDER BY orderid DESC";
            $stmtOrder = $db->prepare($sqlorder);
            $stmtOrder->bindParam("userid",$userid, PDO::PARAM_STR);
            $stmtOrder->execute();
            $OrderData = $stmtOrder->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"OrderData": ' . json_encode($OrderData) . '}';
            }
            else{
                echo '{"Error":"Error"}'; 
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    } 

}

function fetchorderdetail(){

    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $orderid=$data->orderid;
    $systemToken=apiToken($data->user_id);
    
    try {
        if($token == $systemToken){
            $db = getDB();
            $sqlorder = "SELECT * FROM orderslist WHERE orderid = :orderid";
            $stmtOrder = $db->prepare($sqlorder);
            $stmtOrder->bindParam("orderid",$orderid, PDO::PARAM_STR);
            $stmtOrder->execute();
            $OrderDetail = $stmtOrder->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"OrderDetail": ' . json_encode($OrderDetail) . '}';
            }
            else{
                echo '{"Error":"Error"}'; 
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    } 

}

function categoryfilter(){

    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $category=$data->categoryname;
    $systemToken=apiToken($data->user_id);
    
    try {
        if($token == $systemToken){
            $db = getDB();
            $sqlhome = "SELECT * FROM items where category = :categoryname";
            $stmthome = $db->prepare($sqlhome);
            $stmthome->bindParam("categoryname",$category, PDO::PARAM_STR);
            $stmthome->execute();
            $tempData = $stmthome->rowCount();
            $homeData = $stmthome->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"CateFilterData": ' . json_encode($homeData) . '}';
            }
            else{
                echo '{"Error":"Error"}'; 
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    } 

}

function offers(){

    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $systemToken=apiToken($data->user_id);
    $offers = "YES";
    
    try {
        if($token == $systemToken){
            $db = getDB();
            $sqlhome = "SELECT * FROM items where offer = :offers";
            $stmthome = $db->prepare($sqlhome);
            $stmthome->bindParam("offers",$offers, PDO::PARAM_STR);
            $stmthome->execute();
            $tempData = $stmthome->rowCount();
            $homeData = $stmthome->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"offersData": ' . json_encode($homeData) . '}';
            }
            else{
                echo '{"Error":"Error"}'; 
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    } 

}

function searchproduct(){

    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $token=$data->token;
    $search=$data->squery;
    $systemToken=apiToken($data->user_id);
    
    try {
        if($token == $systemToken){
            $db = getDB();
            $sqlsearch = "SELECT * FROM items Where name like ?";
            $params = array("%$search%");
            $stmtsearch = $db->prepare($sqlsearch);
            $stmtsearch->execute($params);
            $tempData = $stmtsearch->rowCount();
            $searchData = $stmtsearch->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"SearchData": ' . json_encode($searchData) . '}';
            }
            else{
                echo '{"Error":"Error"}'; 
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    } 

}

function placeorder() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());

    $token=$data->token;
    $user_id=$data->user_id;
    $fname=$data->fname;
    $mobile=$data->mobile;
    $address=$data->address;

    $orderitems=$data->items;

    $systemToken=apiToken($data->user_id);
    try {
         
        if($systemToken == $token){
            $db = getDB();
            $sqlorder = "INSERT INTO orders(user_id, fname, address, mobile)VALUES(:userid, :fname,:address,:mobile)";
            $stmtorder = $db->prepare($sqlorder);
            $stmtorder->bindParam("fname", $fname,PDO::PARAM_STR);
            $stmtorder->bindParam("userid", $user_id,PDO::PARAM_STR);
            $stmtorder->bindParam("mobile", $mobile,PDO::PARAM_STR);
            $stmtorder->bindParam("address", $address,PDO::PARAM_STR);
            $stmtorder->execute();
            $lastid = $db->lastInsertId();

            foreach ($orderitems as $orderitem) {

                $itemname = $orderitem->itemname;
                $itemquantity = $orderitem->itemquantity;
                $itemquantitytype = $orderitem->itemquantitytype;
                $itemprice = $orderitem->itemprice;
                $itemtotal = $orderitem->itemtotal;
                $itemMquantity = $orderitem->Mquantity;

                $sqlitem = "INSERT INTO orderslist (orderid,itemname,itemquantity,itemquantitytype, Mquantity, itemprice,itemtotal) VALUES (:orderid,:itemname,:itemquantity,:itemquantitytype, :Mquantity, :itemprice,:itemtotal)";   
                $stmtitem = $db->prepare($sqlitem);
                $stmtitem->bindParam("orderid", $lastid, PDO::PARAM_STR);
                $stmtitem->bindParam("itemname", $itemname, PDO::PARAM_STR);
                $stmtitem->bindParam("itemquantity",$itemquantity, PDO::PARAM_INT);
                $stmtitem->bindParam("itemquantitytype",$itemquantitytype, PDO::PARAM_STR);
                $stmtitem->bindParam("Mquantity",$itemMquantity, PDO::PARAM_STR);
                $stmtitem->bindParam("itemprice", $itemprice, PDO::PARAM_INT);
                $stmtitem->bindParam("itemtotal", $itemtotal, PDO::PARAM_INT);
                $stmtitem->execute();
          }  
            $db = null;
            echo '{"success":"' . $lastid .'"}';
            
        } else{
            echo '{"error":{"text":"No access"}}';
        }
       
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}



function sendmessage() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());

    $token=$data->token;
    $cname=$data->cname;
    $cmobile=$data->cmobile;
    $cmsg=$data->cmsg;

    $systemToken=apiToken($data->user_id);
    try {
         
        if($systemToken == $token){
            $db = getDB();
            $sqlorder = "INSERT INTO message(cname, cmobile, cmsg)VALUES(:cname,:cmobile,:cmessage)";
            $stmtorder = $db->prepare($sqlorder);
            $stmtorder->bindParam("cname", $cname,PDO::PARAM_STR);
            $stmtorder->bindParam("cmobile", $cmobile,PDO::PARAM_STR);
            $stmtorder->bindParam("cmessage", $cmsg,PDO::PARAM_STR);
            $stmtorder->execute();
            $lastid = $db->lastInsertId();

            $db = null;
            echo '{"success":"' . $lastid .'"}';
        } else{
            echo '{"error":{"text":"No access"}}';
        }
       
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


function sendfeedback() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());

    $token=$data->token;
    $fmsg=$data->fmsg;

    $systemToken=apiToken($data->user_id);
    try {
         
        if($systemToken == $token){
            $db = getDB();
            $sqlorder = "INSERT INTO feedback(fmsg)VALUES(:fmessage)";
            $stmtorder = $db->prepare($sqlorder);
            $stmtorder->bindParam("fmessage", $fmsg,PDO::PARAM_STR);
            $stmtorder->execute();
            $lastid = $db->lastInsertId();
            $db = null;
            echo '{"success":"' . $lastid .'"}';
        } else{
            echo '{"error":{"text":"No access"}}';
        }
       
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
?>