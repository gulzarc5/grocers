<?php
  include "include/header.php";

  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Product Added Successfully</p>";
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
<style>
.required{
  color:red;
}
</style>
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Add New Product</h2>
            <div class="clearfix"></div>
            <?php 
              if (isset($_GET['msg'])) {
                showMessage($_GET['msg']);
              }           
            ?>
          </div>
          <div class="x_content"><br />
            <form action="php/product/add_product.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" onsubmit="return validate();">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_name">Product Name <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="text" placeholder="Enter Product Name" required="required" class="form-control col-md-7 col-xs-12" name="name">
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
                        print '<option value="'.$cat_row['id'].'">'.$cat_row['name'].'</option>';
                      }
                    }
                    ?>
                  </select>
                  
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="composition">Sub Category<!-- <span class="required">*</span> -->
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select name="sub_category" class="form-control col-md-7 col-xs-12" id="sub_category">
                    <option value="" selected>Please Select Sub Category</option>
                  </select>
                  
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="brand">Brand <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select name="brand" required="required" class="form-control col-md-7 col-xs-12" id="brand">
                    <option value="" selected>Please Select Product Brand</option>
                  </select>
                  
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Product Description
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <textarea placeholder="Enter Product Description" name="description" class="form-control col-md-7 col-xs-12"></textarea>
                </div>
              </div>

		          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">M.R.P. <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" cast="any"  name="mrp" placeholder="Enter Product MRP" class="form-control col-md-7 col-xs-12" required>
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" cast="any" placeholder="Enter Sale Price"  name="price"  class="form-control col-md-7 col-xs-12" required>
                </div>
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stock">Stock</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" placeholder="Enter Stock"  name="stock" class="form-control col-md-7 col-xs-12">
                </div>
              </div>


               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expiry_date">Expiry Date</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="date"   name="expiry_date" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label for="popular" class="control-label col-md-3 col-sm-3 col-xs-12">Is Popular</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  Yes:
                  <input type="radio" class="flat" name="popular" value="2"  /> No:
                  <input type="radio" class="flat" name="popular" value="1" checked=""/>
                </div>
              </div> 

              <div class="form-group">
                <label for="tranding" class="control-label col-md-3 col-sm-3 col-xs-12">Is Tranding</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  Yes:
                  <input type="radio" class="flat" name="tranding" value="2"  /> No:
                  <input type="radio" class="flat" name="tranding" value="1" checked=""/>
                </div>
              </div> 

             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Product Image <span class="required">*</span></label>
                <div class="col-md-5 col-sm-5 col-xs-12">
                  <input type="file"  name="image" class="form-control col-md-5 col-xs-12 demoInputBox" id="file"  onchange="fileTest(this);" required><span id="file_error"></span><br><span>Please Upload Image Less Then 1.5 MB</span>
                </div>
                <div  class="col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                </label>
                  <img src="" id="preview" style="padding-left: 5px">
                </div>
              </div>
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="add_product" value="add_product" class="btn btn-success">Submit</button>
                  </div>
                </div>
              </form>
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


    // $("#sub_category").change(function(){
    //   var cat_id = $("#sub_category").val();

    //     $.ajax({
    //     type: "POST",
    //     url: "php/ajax/fetch_brand.php",
    //     data:{ sub_cat_id : cat_id,},
    //       success: function(data){
    //           console.log(data);
    //           if (data != "2") {
    //             $("#brand").html(data);
    //           }
               
    //       }
    //     });
    // });
  });
</script>

