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
if(isset($_POST['submit']))
{
$file = $_FILES['itemimg']['name'];
$file_loc = $_FILES['itemimg']['tmp_name'];
$folder="itemimg/";
$new_file_name = strtolower($file);
$final_file=str_replace(' ','-',$new_file_name);
$itemname=$_POST['itemname'];
$itemcategory=$_POST['itemcategory'];
$itemdes=$_POST['itemdes'];
$itemprice=$_POST['itemprice'];
$itemqtn=$_POST['itemqtn'];
$itemqtntype=$_POST['itemqtntype'];
if(move_uploaded_file($file_loc,$folder.$final_file))
{
$itemimg=$final_file;
}
$sql="INSERT INTO items(name,category,description,price,quantity,quantitytype,image) VALUES(:name,:category,:description,:price,:itemqtn,:itemqtntype,:images)";
$query = $dbh->prepare($sql);
$query->bindParam(':name',$itemname,PDO::PARAM_STR);
$query->bindParam(':category',$itemcategory,PDO::PARAM_STR);
$query->bindParam(':description',$itemdes,PDO::PARAM_STR);
$query->bindParam(':itemqtn',$itemqtn,PDO::PARAM_STR);
$query->bindParam(':itemqtntype',$itemqtntype,PDO::PARAM_STR);
$query->bindParam(':price',$itemprice,PDO::PARAM_STR);
$query->bindParam(':images',$itemimg,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Item added successfully";
}
else 
{
$error="Something went wrong. Please try again";
}
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
    <title>Add Items
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
    <script type= "text/javascript" src="../vendor/countries.js">
    </script>
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
              <h2 class="page-title">Add Items
              </h2>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">Basic Info
                    </div>
                    <?php if($error){?>
                    <div class="errorWrap">
                      <?php echo htmlentities($error); ?> 
                    </div>
                    <?php } 
else if($msg){?>
                    <div class="succWrap">
                      <?php echo htmlentities($msg); ?> 
                    </div>
                    <?php }?>
                    <div class="panel-body">
                      <form method="post" class="form-horizontal" enctype="multipart/form-data">
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Name
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <input type="text" name="itemname" class="form-control" required>
                          </div>
                          <label class="col-sm-2 control-label">Category
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <select name="itemcategory" class="form-control" required>
                              <option value="">Select
                              </option>
                              <?php $sql = "SELECT * from category";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
                              <option value="<?php echo htmlentities($result->categry);?>">
                                <?php echo htmlentities($result->categry);?>
                              </option>
                              <?php }} ?>
                            </select>
                          </div>
                        </div>
                        <div class="hr-dashed">
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Description
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-10">
                            <textarea class="form-control" name="itemdes" >
                            </textarea>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Quantity
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <input type="number" name="itemqtn" class="form-control" required>
                          </div>
                          <label class="col-sm-2 control-label">Quantity Type
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <select name="itemqtntype" class="form-control" required>
                              <option value="">Select
                              </option>
                              <option value="Kg">KG
                              </option>
                              <option value="Grams">Grams
                              </option>
                              <option value="Dozon">Dozen
                              </option>
                              <option value="Unit">Unit
                              </option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Price
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <input type="number" name="itemprice" class="form-control" required placeholder="In USD">
                          </div>
                          <label class="col-sm-2 control-label">Image
                            <span style="color:red">*
                            </span>
                          </label>
                          <div class="col-sm-4">
                            <input type="file" name="itemimg" class="form-control" value="Select Image File">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn btn-default" type="reset">Cancel
                            </button>
                            <button class="btn btn-primary" name="submit" type="submit">Save Changes
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <img src="itemimg/sample.png" />
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
