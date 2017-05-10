<?php require_once('Connections/signinsales.php'); ?>
<?php include_once('includes/access.php') ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "newkart")) {
  $insertSQL = sprintf("INSERT INTO tblchargesales (chargeType, price, quantity, extendedPrice, payed, customer, debt, `date`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['chargeType'], "text"),
                       GetSQLValueString($_POST['price'], "int"),
                       GetSQLValueString($_POST['quantity'], "int"),
                       GetSQLValueString($_POST['extendedPrice'], "int"),
                       GetSQLValueString($_POST['payed'], "int"),
                       GetSQLValueString($_POST['customer'], "text"),
                       GetSQLValueString($_POST['debt'], "int"),
                       GetSQLValueString($_POST['date'], "date"));

  mysql_select_db($database_signinsales, $signinsales);
  $Result1 = mysql_query($insertSQL, $signinsales) or die(mysql_error());

  $insertGoTo = "charge.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "newname")) {
  $insertSQL = sprintf("INSERT INTO tblcustomer (customerName) VALUES (%s)",
                       GetSQLValueString($_POST['customerName'], "text"));

  mysql_select_db($database_signinsales, $signinsales);
  $Result1 = mysql_query($insertSQL, $signinsales) or die(mysql_error());

  //$insertGoTo = "charge.php";
  //header(sprintf("Location: %s", $insertGoTo));
}

$date=date('Y-m-d');
$colname_sales = "-1";
if (isset($date)) {
  $colname_sales = $date;
}
mysql_select_db($database_signinsales, $signinsales);
$query_sales = sprintf("SELECT * FROM tblchargesales WHERE `date` = %s ORDER BY chargesalesId DESC", GetSQLValueString($colname_sales, "date"));
$sales = mysql_query($query_sales, $signinsales) or die(mysql_error());
$row_sales = mysql_fetch_assoc($sales);
$totalRows_sales = mysql_num_rows($sales);

mysql_select_db($database_signinsales, $signinsales);
$query_types = "SELECT * FROM tblchargetypes ORDER BY chargeType ASC";
$types = mysql_query($query_types, $signinsales) or die(mysql_error());
$row_types = mysql_fetch_assoc($types);
$totalRows_types = mysql_num_rows($types);

mysql_select_db($database_signinsales, $signinsales);
$query_customers = "SELECT * FROM tblcustomer ORDER BY customerName ASC";
$customers = mysql_query($query_customers, $signinsales) or die(mysql_error());
$row_customers = mysql_fetch_assoc($customers);
$totalRows_customers = mysql_num_rows($customers);
?>
<?php $pagename='Charges'; ?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- The styles -->
	<?php include_once('includes/head.php') ?>

    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/favicon.ico">

<script language="javascript">

	function setprice()
	{
		var type=document.getElementById("type");
		var price=document.getElementById("price");
		if(type.value=="Alfa 22$" || type.value=="MTC 22$"){
			price.value=39000;
		}
		else if(type.value=="Alfa 9$") {
			price.value=15000;
			}
			else if(type.value=="MTC 11$") {
			price.value=20000;
			}
	}
	
	function fordebt() {
		var debt=document.getElementById("debt");
		var name=document.getElementById("name");
		if(debt.value!=0 && name.value == "") {
			alert("يجب إدخال إسم الزبون");
		} 
	}
	
	function kart()
	{
		var price=document.getElementById("price");
		var qty=document.getElementById("qty");
		var ext=document.getElementById("ext");
		var payed=document.getElementById("payed");
		var debt=document.getElementById("debt");
		ext.value = price.value * qty.value;
		debt.value = ext.value - payed.value;
	}
</script>

</head>

<body>
    <!-- topbar starts -->
    <?php include_once('includes/topbar.php') ?>
    <!-- topbar ends -->
    
<div class="ch-container">

    <div class="row">    
    

    	<?php include_once('includes/menu.php') ?>
        <!-- left menu ends -->

        <!--/.fluid-container-->

<div id="content" class="col-lg-10 col-sm-10">
    <!-- content starts -->
            
    <div>
        <ul class="breadcrumb">
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>
                <a href="#"><?php echo $pagename; ?></a>
            </li>
        </ul>
    </div>     
    
     <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
            
                <div class="box-header well">
                    <h2><i class="glyphicon glyphicon-star-empty"></i> <?php echo $pagename; ?></h2>
    
                    <div class="box-icon">
                        <a href="#" class="btn btn-minimize btn-round btn-default">
                        	<i class="glyphicon glyphicon-chevron-up"></i>
                        </a>
                        <a href="#" class="btn btn-close btn-round btn-default">
                        	<i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </div>
                </div>
                
                <div class="box-content" align="center">
                	<a class="btn btn-default btn-lg" href="charge.php?type=kart"> 
                    <b> كارت كامل </b>&ensp;<i class="glyphicon glyphicon-plus-sign icon-white"></i>
                    </a>
                    &emsp;
                    <a class="btn btn-default btn-lg" href="charge.php?type=days"> 
                    <b> تشريج أيام </b>&ensp;<i class="glyphicon glyphicon-plus-sign icon-white"></i>
                    </a>
                    &emsp; 
                    <a class="btn btn-default btn-lg" href="charge.php?type=dollars"> 
                    <b> بيع دولارات </b>&ensp;<i class="glyphicon glyphicon-plus-sign icon-white"></i>
                    </a>
                </div> 
                <hr>
                <div class="box-content">
                	<h4 style="margin-right:40px;" align="right"><?php $day=date('D'); echo $date. " " .$day; ?> :التاريخ </h4>
                </div>
                <?php if(isset($_GET['type']) && $_GET['type']=='kart') { ?>
                <div class="box-content">
                	<h4 style="margin-right:40px;" align="right"><b> كارت جديد </b></h4>
                	<table class="table table-striped table-bordered responsive">
                   	<thead>
                    <tr>
                        <th></th>
                        <th> الباقي </th>
                        <th> واصل </th>
                        <th> السعر الاجمالي </th>
                        <th> العدد </th>
                        <th> السعر الإفرادي </th>
                        <th> إختر نوع الكارت &emsp;&emsp;&emsp;</th>
                        <th><a href="#" class="btn btn-setting btn-round btn-default"> اسم الزبون </a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <form name="newkart" method="POST" action="<?php echo $editFormAction; ?>">
                    	<input type="date" name="date" value="<?php echo $date; ?>" id="date" hidden="">
                      <tr>
                      	<td><input type="submit" onMouseOver="fordebt()" class="btn-success btn" name="submit" value="إدخـــال" id="submit"></td>
                        
                        <td><input type="number" class="form-control" name="debt" id="debt" onkeyup="kart()" value="<?php if(isset($_POST['debt'])){ echo $_POST['debt'] ;} ?>"></td>
                        
                        <td><input type="number" class="form-control" name="payed" id="payed" onBlur="fordebt()" onkeyup="kart()"  value="<?php if(isset($_POST['payed'])){ echo $_POST['payed'] ;} else {echo "0";} ?>"></td>
                        
                        <td><input type="number" class="form-control" name="extendedPrice" id="ext" onkeyup="kart()" value="<?php if(isset($_POST['extendedPrice'])){ echo $_POST['extendedPrice'] ;} ?>"></td>
                        
                        <td><input type="number" class="form-control" name="quantity" id="qty" onkeyup="kart()" value="<?php if(isset($_POST['quantity'])){ echo $_POST['quantity'] ;} ?>"></td>
                        
                        <td><input type="number" class="form-control" name="price" id="price" onclick="kart()" value="<?php if(isset($_POST['price'])){ echo $_POST['price'] ;} ?>"></td>
                        
                        <td>
                        	<select class="form-control" name="chargeType" id="type" onBlur="setprice()">
   								<option><?php if(isset($_POST['chargeType'])){ echo $_POST['chargeType'] ;} else { echo '<b> إختر النوع </b>';} ?></option>
                              <?php do { ?>   
                                <option value="<?php echo $row_types['chargeType']; ?>"><?php echo $row_types['chargeType']; ?></option>
                              <?php } while ($row_types = mysql_fetch_assoc($types)); ?>   
                        	</select>
                        </td>
                        
                        <td>
                        	<select class="form-control" data-rel="chosen" name="customer" id="name">
          <option><?php if(isset($_POST['customer'])){ echo $_POST['customer'] ;} else {echo "";} ?></option>
                              <?php do { ?>  
                                <option><?php echo $row_customers['customerName']; ?></option>
                              <?php } while ($row_customers = mysql_fetch_assoc($customers)); ?>  
                            </select>
                        </td>
                      </tr>
                      <input type="hidden" name="MM_insert" value="newkart">
                    </form>  
                    </table>
                    <br />
                    <div class="clearfix"></div>
                    <h4 style="margin-right:40px;" align="right"><b> المبيعات خلال اليوم </b></h4>
                	<table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                    <thead>
                    <tr>
                        <th></th>
                        <th>اسم الزبون</th>
                        <th>الباقي</th>
                        <th>واصل</th>
                        <th>المجموع</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>النوع</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
					  <?php $i=$totalRows_sales; do { ?>
                      <tr>
                        <td class="center">
                        	<a class="btn btn-warning" href=""> 
                            <b> تـعـد يـل </b>&ensp;<i class="glyphicon glyphicon-edit icon-white"></i></a>                        </td>
                        <td class="center"><?php echo $row_sales['customer']; ?></td>
                        <td><?php echo $row_sales['debt']; ?></td>    
                        <td class="center"><?php echo $row_sales['payed']; ?></td>
                        <td class="center"><?php echo $row_sales['extendedPrice']; ?></td>
                        <td class="center"><?php echo $row_sales['quantity']; ?></td>
                        <td class="center"><?php echo $row_sales['price']; ?></td>
                        <td class="center"><?php echo $row_sales['chargeType']; ?></td>
                        <td class="center"><?php echo $i; ?></td>
					  </tr>
                      <?php $i--; } while ($row_sales = mysql_fetch_assoc($sales)); ?> 
                                         
  					</tbody>
                    </table> 
              </div>
              <?php } ?>
            </div>
        </div>
    </div>    
    
    
    <!-- content ends -->
    </div><!--/#content.col-md-0-->
    
</div><!--/fluid-row-->

    <hr>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>إسم زبون جديد</h3>
                </div>
                <div class="modal-body">
                    <form name="newname" method="POST" action="<?php echo $editFormAction; ?>" role="form">
                        <div class="form-group">
                            <label for="name"> إسم الزبون </label>
                            <input type="text" name="customerName" class="form-control" id="name" placeholder="أدخل إسم الزبون">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"> Submit </button>
                    <a href="#" class="btn btn-default" data-dismiss="modal"> Close </a>
                    <input type="hidden" name="MM_insert" value="newname">
                    </form>
                </div>
            </div>
        </div>
    </div> 
        
    <?php include_once('includes/footer.php') ?>

     

</div><!--/.fluid-container-->


<!-- external javascript -->
<?php include_once('includes/footlinks.php') ?>



</body>
</html>
<?php
mysql_free_result($sales);

mysql_free_result($types);

mysql_free_result($customers);
?>
