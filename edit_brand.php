<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Brand Added Successfully</p>";
    }elseif ($msg == 2) {
      print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
    }elseif ($msg == 6) {
        print "<p class='alert alert-danger'>Image Size Should Be Less Then 1.5 MB</p>";
    }elseif ($msg == 4) {
        print "<p class='alert alert-danger'>Please Upload Image JPG Or PNG Format</p>";
    }
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Brand</h2>
            <div class="clearfix"></div>
            <?php
                if (isset($_GET['msg'])) {
                  showMessage($_GET['msg']);
                }
              ?>
          </div>
          <div class="x_content"><br />
          <?php
              if (isset($_GET['main_id'])) {
                $brands = $connection->real_escape_string(mysql_entities_fix_string($_GET['main_id']));
                $fetch_brands = "SELECT * FROM `brands` WHERE `id`='$brands'";
                if ($fetch_brands_res = $connection->query($fetch_brands)) {
                  $fetch_brands_row = $fetch_brands_res->fetch_assoc();
               
            ?>
            <form  class="form-horizontal form-label-left" action="php/brand/update_brand.php" method="post" enctype="multipart/form-data" >

                <input type="hidden" name="brand_id" value="<?= $fetch_brands_row['id']; ?>">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name" >Name <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" required="required" class="form-control col-md-7 col-xs-12" name="name" placeholder="Enter Brand Name" value="<?= $fetch_brands_row['name']; ?>">
                    </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="composition">Product Category<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="category" required="required" class="form-control col-md-7 col-xs-12" id="category">
                    <option value="" selected>Please Select Category</option>

                    <?php
                    $sql_category = "SELECT * FROM `category` Order by `name` ASC";
                    if ($res_cat = $connection->query($sql_category)) {
                      while($cat_row = $res_cat->fetch_assoc()){
                        if ($cat_row['id'] == $fetch_brands_row['category_id']) {
                          print '<option value="'.$cat_row['id'].'" selected>'.$cat_row['name'].'</option>';
                        } else {
                          print '<option value="'.$cat_row['id'].'">'.$cat_row['name'].'</option>';
                        }
                        
                      }
                    }
                    ?>
                  </select>
                  
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="composition">Sub Category<!-- <span class="required">*</span> -->
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="sub_category" class="form-control col-md-7 col-xs-12" id="sub_category">
                    <option value="" selected>Please Select Sub Category</option>
                    <?php
                    if (!empty($fetch_brands_row['category_id'])) {                      
                      $sql_category = "SELECT * FROM `sub_category` WHERE `category_id`='$fetch_brands_row[category_id]' Order by `name` ASC";
                      if ($res_cat = $connection->query($sql_category)) {
                        while($cat_row = $res_cat->fetch_assoc()){
                          if ($cat_row['id'] == $fetch_brands_row['sub_category_id']) {
                            print '<option value="'.$cat_row['id'].'" selected>'.$cat_row['name'].'</option>';
                          } else {
                            print '<option value="'.$cat_row['id'].'">'.$cat_row['name'].'</option>';
                          }
                          
                        }
                      }
                    }
                    ?>
                  </select>
                  
                </div>
              </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Brnad Image 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" class="form-control col-md-7 col-xs-12" name="image">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <img src="uploads/brand/thumb/<?= $fetch_brands_row['image'] ?>" alt="" height="100" id="preview"> 
                    </div>
                </div>
                
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
            <?php
               }
              }
            ?>

            </div>
          </div>
        </div>
      </div>
</div>
<?php
include "include/footer.php";
?>

<script type="text/javascript">
  $(document).ready(function(){
    $("#category").change(function(){
      var cat_id = $("#category").val();

       $.ajax({
        type: "POST",
        url: "php/ajax/fetch_sub_cat.php",
        data:{ cat_id : cat_id,},
          success: function(data){
              console.log(data);
              if (data != "2") {
                $("#sub_category").html(data);
              }
               
          }
        });
    });
  });
</script>