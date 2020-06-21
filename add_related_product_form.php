<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Product Added To Related List</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
    }
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <?php
            if (isset($_GET['p_id'])) {
              $row_stock = 0.00;
             $p_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['p_id']));
           
              $sql_stock = "SELECT `stock`,`name` FROM `product` WHERE `id`='$p_id'";
              if ($res_stock = $connection->query($sql_stock)) {
                $row_stock = $res_stock->fetch_assoc();
            
          ?>
        <div class="x_panel">
          <div class="x_title">
            <h2>Add Related Product of <b style='color:#26B99A;'><?=$row_stock['name']?></b></h2>
            <h2 style="float:right;">
              <a href="education.php" class="btn btn-warning">Back To Product List</a>
              <a href="related_product_list.php?p_id=<?=$p_id?>" class="btn btn-info">View Related Products</a>
            </h2>
            <div class="clearfix"></div>
            <?php
                if (isset($_GET['msg'])) {
                  showMessage($_GET['msg']);
                }
              ?>
          </div>
          <div class="x_content">
            <form  class="form-horizontal form-label-left" action="php/related_product/add_related_product.php" method="post" id="related_form">
            

              <input type="hidden" name="p_id" value="<?php echo $p_id; ?>">
              <div id="related_div">
              </div>
             
              <div class="ln_solid"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                    <div class="x_content">
            
                        <table id="productTable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                            <th>Sl</th>
                            <th>Product Id</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                                
                        </tbody>
                        </table>
            
            
                    </div>
                    </div>
                </div>
              </form>
            </div>
          </div>
            <?php
                }
              }
            ?>
        </div>
      </div>
</div>
<?php
include "include/footer.php";
?>

<script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    var dataTable=$("#productTable").DataTable({
      "processing" : true,
      "serverSide" : true,
       "columns": [
        null,
        null,
        null,
        null,
        null,
        ],
        "pageLength": 50,
      "ajax" :{
        data:{p_id:<?=$_GET['p_id']?>},
        url : "php/ajax/product_list_fetch_for_related.php",
        type : "post"
      }
    });
  });


  function related_add(id){
        $("#related_div").html('<input type="hidden" name="related_id" value="'+id+'">');
        $("#related_form").submit();
  }
</script>