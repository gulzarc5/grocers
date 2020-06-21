<?php
require_once "include/header.php";

function showMessage($msg){
    if ($msg == 3) {
      print "<p class='alert alert-success'>Batch Updated Successfully</p>";
    }
    if ($msg == 4) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
    if ($msg == 5) {
      print "<p class='alert alert-danger'>Batch Deleted Successfully</p>";
    }
    if ($msg == 6) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
  }

function getRelatedProduct($connection,$p_id){
  $sql = "SELECT `product`.`name` AS p_name, `category`.`name` AS c_name, `sub_category`.`name` AS sub_cat_name, `related_product`.`id` AS id FROM `related_product` LEFT JOIN `product` ON `product`.`id`=`related_product`.`related_to_id` LEFT JOIN `category` ON `category`.`id`=`product`.`category_id` LEFT JOIN `sub_category` ON `sub_category`.`id`=`product`.`sub_cat_id` WHERE `related_product`.`product_id`='$p_id'";
  if ($res = $connection->query($sql)) {
    $sl_count = 1;
    while($category = $res->fetch_assoc()){
      print '<tr>
                <td>'.$sl_count.'</td>
                <td>'.$category['p_name'].'</td>
                <td>'.$category['c_name'].'</td>
                <td>'.$category['sub_cat_name'].'</td>
                <td><a href="./php/related_product/remove_related_product.php?id='.$category['id'].'&p_id='.$p_id.'" class="btn btn-danger">Remove</a>
                </td>
             </tr>';
      $sl_count++;
    }

  }
}
?>
<div class="clearfix"></div>
<div class="right_col" role="main">
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
           <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Related Product List Of <b style='color:#26B99A;'><?=$row_stock['name']?></b></h2>
                    <h2 style="float:right;">
                      <a href="add_related_product_form.php?p_id=<?=$p_id?>" class="btn btn-warning">Back </a>
                    </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content table-responsive">
          
                    <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Sl</th>
                          <th>Name</th>
                          <th>Category</th>
                          <th>Sub Category</th>
                          <th>Action</th>
                          <!-- <th>Actions</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        getRelatedProduct($connection,$p_id);
                        ?>                        
                      </tbody>
                    </table>
          
          
                  </div>
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
require_once "include/footer.php";
?>

<script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
