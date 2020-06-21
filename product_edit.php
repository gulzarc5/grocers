<?php
  include "include/header.php";

  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Product Updated Successfully</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
    if ($msg == 3) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
    if ($msg == 4) {
      print "<p class='alert alert-danger'>Please Check Image Type</p>";
    }
    if ($msg == 5) {
      print "<p class='alert alert-danger'>Product Already Exist</p>";
    }
    if ($msg == 6) {
      print "<p class='alert alert-danger'>Image Size is Larger Then The Upload Size</p>";
    }
    if ($msg == 7) {
      print "<p class='alert alert-danger'>Bar Code Already Exist Please Try With Another Bar Code</p>";
    }
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Product</h2>
            <div class="clearfix"></div>
            <?php 
              if (isset($_GET['msg'])) {
                showMessage($_GET['msg']);
              }           
            ?>
          </div>
          <div class="x_content"><br />

             <?php
              if (isset($_GET['p_id'])) {
                 $p_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['p_id']));
                  $sql_get_p = "SELECT * FROM `product` WHERE `id`='$p_id'";
                  if ($res_get_p = $connection->query($sql_get_p)) {
                     $product_row = $res_get_p->fetch_assoc();

                
            ?>

            <form action="php/product/update_product.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
              <input type="hidden" name="p_id" value="<?php echo $p_id ?>">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_name">Product Name <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="text"  required="required" class="form-control col-md-7 col-xs-12" name="name" value="<?php echo  $product_row['name']; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="composition">Product Category<span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select name="category" required="required" class="form-control col-md-7 col-xs-12" id="category">
                    <option value="" selected>Please Select Category</option>

                    <?php
                    $sql_category = "SELECT * FROM `category` Order by `name` ASC";
                    if ($res_cat = $connection->query($sql_category)) {
                      while($cat_row = $res_cat->fetch_assoc()){
                        if ( $product_row['category_id'] == $cat_row['id']) {
                           print '<option value="'.$cat_row['id'].'" selected>'.$cat_row['name'].'</option>';
                        }else{
                          print '<option value="'.$cat_row['id'].'">'.$cat_row['name'].'</option>';
                        }
                      }
                    }
                    ?>
                  </select>
                  
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="composition">Sub Category
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select name="sub_category" class="form-control col-md-7 col-xs-12" id="sub_category">
                    <option value="" selected>Please Select Sub Category</option>
                    <?php
                      $sql_sub_category = "SELECT * FROM `sub_category` WHERE `category_id`='$product_row[category_id]' Order by `name` ASC";
                      if ($res_sub_cat = $connection->query($sql_sub_category)) {
                        while($sub_cat_row = $res_sub_cat->fetch_assoc()){
                          if ( $product_row['sub_cat_id'] == $sub_cat_row['id']) {
                             print '<option value="'.$sub_cat_row['id'].'" selected>'.$sub_cat_row['name'].'</option>';
                          }else{
                            print '<option value="'.$sub_cat_row['id'].'">'.$sub_cat_row['name'].'</option>';
                          }
                        }
                      }
                    ?>
                  </select>
                  
                </div>
              </div>
              

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="brand">Brand <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select name="brand" required="required" class="form-control col-md-7 col-xs-12" id="brand">
                    <option value="" selected>Please Select Product Brand</option>
                    <?php                    
                      if (!empty($product_row['category_id'])) {
                        $sql_brands = "SELECT * FROM `brands` WHERE `category_id`='$product_row[category_id]' Order by `name` ASC";
                      } elseif(!empty( $product_row['sub_cat_id'])) {
                        $sql_brands = "SELECT * FROM `brands` WHERE `sub_category_id`='$product_row[sub_cat_id]' Order by `name` ASC";
                      }  
                      if (!empty($product_row['category_id']) || !empty( $product_row['sub_cat_id'])) {                  
                        if ($res_cat = $connection->query($sql_brands)) {
                          while($cat_row = $res_cat->fetch_assoc()){
                            if ( $product_row['brand_id'] == $cat_row['id']) {
                              print '<option value="'.$cat_row['id'].'" selected>'.$cat_row['name'].'</option>';
                            }else{
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Product Description
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <textarea type="text" name="description"   class="form-control col-md-7 col-xs-12"><?php echo $product_row['description'] ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">M.R.P.<span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" cast="any"  name="mrp" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $product_row['mrp']; ?>">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price<span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" cast="any"  name="price" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $product_row['price']; ?>">
                </div>
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stock">Stock<span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number"   name="stock" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $product_row['stock']; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expiry_date">Expiry Date
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="date" value="<?php echo $product_row['expiry_date']; ?>"  name="expiry_date" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label for="popular" class="control-label col-md-3 col-sm-3 col-xs-12">Is Popular</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  Yes:
                  <input type="radio" class="flat" name="popular" value="2"  <?=$product_row['is_popular'] == '2'?"checked":""?>/> No:
                  <input type="radio" class="flat" name="popular" value="1" <?=$product_row['is_popular'] == '1'?"checked":""?>/>
                </div>
              </div> 

              <div class="form-group">
                <label for="tranding" class="control-label col-md-3 col-sm-3 col-xs-12">Is Tranding</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  Yes:
                  <input type="radio" class="flat" name="tranding" value="2" <?=$product_row['is_tranding'] == '2'?"checked":""?> /> No:
                  <input type="radio" class="flat" name="tranding" value="1" <?=$product_row['is_tranding'] == '1'?"checked":""?>/>
                </div>
              </div>


             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Product Image
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12">
                  <input type="file"  name="image" class="form-control col-md-5 col-xs-12 demoInputBox"  onchange="fileTest(this);" id="file"><span id="file_error"></span><br><span>Please Upload Image Less Then 1.5 MB</span>
                </div>
                <div  class="col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                </label>
                  <img src="uploads/product_image/thumb/<?php echo $product_row['image'] ?>" id="preview" style="padding-left: 5px">
                </div>
              </div>
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="update_product" value="update_product" class="btn btn-success">Submit</button>
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
 function fileTest(input) {
    readURL(input);
    validateFile();
  }
  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview')
                .attr('src', e.target.result)
                .height(120);
        };

        reader.readAsDataURL(input.files[0]);
    }
  }

  function validateFile(input) {
    $("#file_error").html("");
    $(".demoInputBox").css("border-color","#F0F0F0");
    var file_size = $('#file')[0].files[0].size;
    if(file_size>2097152) {
      $("#file_error").html("<b style='color:red'>File size is greater than 1.5 MB</b>");
      $(".demoInputBox").css("border-color","#FF0000");
      $('#file').val('');
      return false;
    } 
    return true;
  }
</script>


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

      $.ajax({
      type: "POST",
      url: "php/ajax/fetch_brand.php",
      data:{ cat_id : cat_id,},
        success: function(data){
            console.log(data);
            if (data != "2") {
              $("#brand").html(data);
            }
            
        }
      });
    });


    
    $("#sub_category").change(function(){
      var cat_id = $("#sub_category").val();

        $.ajax({
        type: "POST",
        url: "php/ajax/fetch_brand.php",
        data:{ sub_cat_id : cat_id,},
          success: function(data){
              console.log(data);
              if (data != "2") {
                $("#brand").html(data);
              }
               
          }
        });
    });
  })
</script>