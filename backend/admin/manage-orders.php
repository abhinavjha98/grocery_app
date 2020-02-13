<!--- Contact For App/Web Design ajayrandhawartg@gmail.com -->
<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{	
header('location:index.php');
}
else{
if(isset($_REQUEST['confirmid']) && isset($_REQUEST['user']) && isset($_REQUEST['mobileno']))
{
$eid=intval($_GET['confirmid']);
$user = $_GET['user'];
$mobileno = $_GET['mobileno'];
$status='Confirmed';
$sql = "UPDATE orders SET status=:status WHERE orderid=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
$msg="Status Updated Sucessfully";
}

if(isset($_REQUEST['prepareid'])  && isset($_REQUEST['user']) && isset($_REQUEST['mobileno']))
{
$eid=intval($_GET['prepareid']);
$user = $_GET['user'];
$mobileno = $_GET['mobileno'];
$status='Preparing';
$sql = "UPDATE orders SET status=:status WHERE orderid=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
$msg="Status Updated Sucessfully";
}

if(isset($_REQUEST['wayid']) && isset($_REQUEST['user']) && isset($_REQUEST['mobileno']))
{
$eid=intval($_GET['wayid']);
$user = $_GET['user'];
$mobileno = $_GET['mobileno'];
$status='On Way';
$sql = "UPDATE orders SET status=:status WHERE orderid=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
$msg="Status Updated Sucessfully";
}

if(isset($_REQUEST['deliveredid']) && isset($_REQUEST['user']) && isset($_REQUEST['mobileno']))
{
$eid=intval($_GET['deliveredid']);
$user = $_GET['user'];
$mobileno = $_GET['mobileno'];
$status='Delivered';
$sql = "UPDATE orders SET status=:status WHERE orderid=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
$msg="Status Updated Sucessfully";
}

if(isset($_REQUEST['cancelid']) && isset($_REQUEST['user']) && isset($_REQUEST['mobileno']))
{
$eid=intval($_GET['cancelid']);
$user = $_GET['user'];
$mobileno = $_GET['mobileno'];
$status='Cancelled';
$sql = "UPDATE orders SET status=:status WHERE orderid=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
$msg="Status Updated Sucessfully";
}
?>
<!doctype html>
<html lang="en" class="no-js">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>HK | Orders  
    </title>
    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <style>
      .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #dd3d36;
        color:#fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
      .succWrap{
        padding: 10px;
        margin: 0 0 20px 0;
        background: #5cb85c;
        color:#fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
    </style>
  </head>
  <body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
      <?php include('includes/leftbar.php');?>
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h2 class="page-title">
                <a href="manage-orders.php">Manage Orders 
                </a>
              </h2>
              <!-- Zero Configuration Table -->
              <div class="panel panel-default">
                <div class="panel-heading">Orders
                </div>
                <div class="panel-body">
                  <?php if($error){?>
                  <div class="errorWrap">
                    <strong>ERROR
                    </strong>:
                    <?php echo htmlentities($error); ?> 
                  </div>
                  <?php } 
else if($msg){?>
                  <div class="succWrap">
                    <strong>SUCCESS
                    </strong>:
                    <?php echo htmlentities($msg); ?> 
                  </div>
                  <?php }?>
                  <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                      <th>S.No
                        </th>
                        <th>OrderID
                        </th>
                        <th>Order Time
                        </th>
                        <th>Name
                        </th>
                        <th>Mobile Number
                        </th>
                        <th>Address
                        </th>
                        <th>Status
                        </th>
                        <th>Action
                        </th>
                        <th>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $sql = "SELECT * FROM orders order by orderid desc";
                      $query = $dbh -> prepare($sql);
                      $query->execute();
                      $results=$query->fetchAll(PDO::FETCH_OBJ);
                      $cnt=1;
                      if($query->rowCount() > 0)
                      {
                      foreach($results as $result)
                      {				?>	
                      <tr>
                      <td>
                          <?php echo htmlentities($cnt);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->orderid);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->ordertime);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->fname);?> 
                        </td>
                        <td>
                          <?php echo htmlentities($result->mobile);?>
                        </td>
                        <td>
                          <?php echo htmlentities($result->address);?>
                        </td>
                        <td>
                          <b class="text-warning">
                            <?php echo htmlentities($result->status);?>
                          </b>
                        </td>
                        <td>
                          <a href="view-order.php?orderid=<?php echo $result->orderid;?>" >View Order
                          </a>
                        </td>
                        <td>
                          <select onchange="location = this.value;">
                            <option>
                            </option>
                            <option value="manage-orders.php?confirmid=<?php echo $result->orderid;?>&user=<?php echo $result->fname;?>&mobileno=<?php echo $result->mobile;?>">Confirmed
                            </option>
                            <option value="manage-orders.php?prepareid=<?php echo $result->orderid;?>&user=<?php echo $result->fname;?>&mobileno=<?php echo $result->mobile;?>">Prepared
                            </option>
                            <option value="manage-orders.php?wayid=<?php echo $result->orderid;?>&user=<?php echo $result->fname;?>&mobileno=<?php echo $result->mobile;?>">On Way
                            </option>
                            <option value="manage-orders.php?deliveredid=<?php echo $result->orderid;?>&user=<?php echo $result->fname;?>&mobileno=<?php echo $result->mobile;?>">Delivered
                            </option>
                            <option value="manage-orders.php?cancelid=<?php echo $result->orderid;?>&user=<?php echo $result->fname;?>&mobileno=<?php echo $result->mobile;?>">Cancelled
                            </option>
                          </select>
                        </td>
                      </tr>
                      <?php $cnt=$cnt+1; }} ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Loading Scripts -->
    <script src="js/jquery.min.js">
    </script>
    <script src="js/bootstrap-select.min.js">
    </script>
    <script src="js/bootstrap.min.js">
    </script>
    <script src="js/jquery.dataTables.min.js">
    </script>
    <script src="js/dataTables.bootstrap.min.js">
    </script>
    <script src="js/Chart.min.js">
    </script>
    <script src="js/fileinput.js">
    </script>
    <script src="js/chartData.js">
    </script>
    <script src="js/main.js">
    </script>
    <script type="text/javascript">
      $(document).ready(function () {
        setTimeout(function() {
          $('.succWrap').slideUp("slow");
        }
                   , 3000);
      }
                       );
    </script>
  </body>
</html>
<?php } ?>
