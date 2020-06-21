<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Offer Added Successfully</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
    }
    if ($msg == 3) {
      print "<p class='alert alert-danger'>Please Check Uploaded Image Size</p>";
    }
     if ($msg == 4) {
      print "<p class='alert alert-danger'>Please Check Uploaded Image Type</p>";
    }
    if ($msg == 5) {
      print "<p class='alert alert-danger'>Package Deleted Successfully</p>";
    }
     if ($msg == 6) {
      print "<p class='alert alert-danger'>Package Deleted Successfully</p>";
    }
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Star Product Min Purchase<small></small></h2>
                <div class="clearfix"></div>
                 
              </div>
              <div class="x_content ">
                <form action="php/charges/update_charges.php" method="post">
                  <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Action</th>
                        <!-- <th>Actions</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $package_sql = "SELECT * FROM `charges`";
                        if ($res_package = $connection->query($package_sql)) {
                          $count = 1;
                          while($charges_row = $res_package->fetch_assoc()){
                            print "<tr>
                            <td>$count</td>
                           
                            <td>$charges_row[name]</td>
                            <td>
                              <b id='star_input_div$count' style='display:none;'>
                                <input type='hidden' name='id[]' value='$charges_row[id]' >
                                <input type='number' name='amount[]' value='$charges_row[amount]' class='form-control'>
                              </b>
                              <b id='star_div$count'>$charges_row[amount]</b>
                            </td>
                            <td id='star_action$count'>
                                <button type='button' class='btn btn-warning' onclick='starEdit($count)'>Edit</a>
                            </td>
                            </tr>";
                            $count++;
                          }
                        }
                      ?>                        
                    </tbody>
                  </table>
                </form>      
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
<?php
include "include/footer.php";
?>

<script type="text/javascript">
  function starEdit(id){
    $("#star_div"+id).hide();
    $("#star_input_div"+id).show();
    $("#star_action"+id).html("<button type='submit' name='star' value='star' class='btn btn-success'>Save</a>");
  }
</script>