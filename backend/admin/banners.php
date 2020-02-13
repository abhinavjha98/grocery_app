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
$file = $_FILES['bnimg']['name'];
$file_loc = $_FILES['bnimg']['tmp_name'];
$folder="banner/";
$new_size = $file_size/1024;  
$new_file_name = strtolower($file);
$final_file=str_replace(' ','-',$new_file_name);
if(move_uploaded_file($file_loc,$folder.$final_file))
{
$bnimg=$final_file;
$sql="INSERT INTO banner(bnimg) VALUES(:bnimg)";
$query = $dbh->prepare($sql);
$query->bindParam(':bnimg',$bnimg,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Banner added successfully";
}
else 
{
$error="Something went wrong. Please try again";
}
}
else 
{
$error="Something went wrong. Please try again";
}
}

if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from banner WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$msg="Data Deleted successfully";
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
    <title>HK | Banners
    </title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
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
              <h2 class="page-title">Add Banner
              </h2>
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading">Form fields
                    </div>
                    <div class="panel-body">
                      <form enctype="multipart/form-data" method="post" class="form-horizontal" onSubmit="return valid();">
                        <?php if($error){?>
                        <div class="errorWrap">
                          <?php echo htmlentities($error); ?> 
                        </div>
                        <?php } 
							else if($msg){?>
                        <div class="succWrap">
                          <strong>
                            <?php echo htmlentities($msg); ?> 
                            </div>
                          <?php }?>
                          <div class="form-group">
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Upload Image
                            </label>
                            <div class="col-sm-7">
                              <input type="file" class="form-control" name="bnimg"  required>
                            </div>
                            <div class="col-sm-3">
                              <button class="btn btn-primary" name="submit" type="submit">Add
                              </button>
                            </div>
                          </div>
                          </form>
                        </div>
                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>#
                        </th>
                        <th>Action
                        </th>	
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sql = "SELECT * from  banner ";
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
                          <img width="150px" src="banner/<?php echo htmlentities($result->bnimg);?>" />
                        </td>
                        <td>
                          <a href="banners.php?del=<?php echo $result->id;?>" onclick="return confirm('Do you want to delete');">
                            <i class="fa fa-trash" style="color:red">
                            </i>
                          </a>
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
