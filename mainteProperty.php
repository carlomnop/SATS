<?php
  session_start();
  require_once('connection.php');
  include('config.php');
  include('validatePage.php');

  $thisPage = "EditProperty";

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Property Accountability</title>
    <link rel="icon" href="logo/logo.png" type="image/png" sizes="16x22">

    <link href="build/css/metro.css" rel="stylesheet">
    <link href="build/css/backend.css" rel="stylesheet">
    <link href="build/css/metro-colors.min.css" rel="stylesheet">
    <link href="build/css/metro-schemes.min.css" rel="stylesheet">

    <link href="build/css/admin.css" rel="stylesheet">
    <link href="build/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="build/css/metro-icons.css" rel="stylesheet">
    <link href="build/css/metro-responsive.css" rel="stylesheet">
    <script src="build/js/jquery-2-1-3.min.js"></script>
    <script src="build/js/metro.js"></script>



  </head>
  <body style="overflow:hidden;">
 <div class="flex-grid no-responsive-feature" style="height:100%;">
    <div class="row" style="height: 100%;">
    <?php include_once('admin_navigation.php'); ?>
      <div class="cell auto-size padding20 no-margin-top grid container place-right" id="style-4" style="overflow-y:scroll;height:100%;">
        <h1 class="text-light"><span class="mif-file-empty icon"></span> Property Maintenance</h1>
        <hr class="thin bg-grayLighter">
        <button class="button primary" onclick="showMetroDialog('#adminAdd')"></span> Add Property</button>
        <div id="history_request_div"  style="display:none;"></div>
        <!--pre loader-->
        <center>
          <div class="cell auto-size padding20" style="height:77.5vh;" data-role="preloader" data-type="cycle" data-style="color"  id="history_loader"></div>
        </center>
      </div>
      <div data-role="dialog" data-overlay="true" data-overlay-color="op-dark" data-height="80%" data-width="50%" data-overlay-click-close="true" id="adminAccountabilityDialog" data-close-button="true" style="overflow-y:scroll;">
        <h3 class="padding20 text-light header">Property Information</h3>
        <div class="padding20" id="adminInformation" style="padding-top:0;" ></div>
      </div>
      <div data-role="dialog" data-overlay="true" data-overlay-color="op-dark" data-height="100%" data-place="top-center" data-width="30%" data-overlay-click-close="true" id="adminAdd" data-close-button="true" style="overflow-y:scroll;">
        <h3 class="padding20 text-light header">Property Information</h3>
        <div class="padding20" style="padding-top:0;">
          <div class="input-control text full-size">
            <input type="text" class="" id="pcode" placeholder="Property Code">
          </div>
          <div class="input-control text full-size" >
            <input type="text" class="" id="sno" placeholder="Serial Number">
          </div>
          <div class="input-control textarea full-size">
            <textarea type="text" class="" id="propertyDescription" placeholder="Property Description"></textarea>
          </div>
          <div class="input-control number full-size">
            <input type="number" class="" id="qty" placeholder="Quantity"/>
          </div>
          <div class="input-control text full-size">
            <input type="text" class="" id="brand" placeholder="Brand">
          </div>
          <div class="input-control text full-size">
            <input type="text" class="" id="model" placeholder="Model">
          </div>
          <div class="input-control text full-size">
            <input type="text" class="" id="uom" placeholder="Unit of measurement">
          </div>

          <div class="input-control text full-size">
            <input type="number" class="" id="cost" placeholder="Cost">
          </div>
          <div class="input-control text full-size">
            <input type="text" class="" id="orno" placeholder="P.O Number">
          </div>
          <div class="input-control text full-size">
              <input type="date" id="dateAcquired" placeholder="Date Acquired">
          </div>
          <form method="POST" action="build/ajax/uploadInsertImage.php" enctype="multipart/form-data" id="addProperty">
            <div class="input-control file full-size" data-role="input">
                <input type="file" name="propertyUploader" id="propertyUploader">
                <button class="button" type="button"><span class="mif-folder"></span></button>
            </div>
          </form>
          <div class="input-control select full-size">
            <select id="majorCategory" style="display:none;">
              <option disabled selected value="0">Choose a Major Category</option>

              <?php
                $majorDatas = $db->select("major_category",["id","description"],["ORDER"=>["description"=>"ASC"]]);
                foreach($majorDatas AS $majorData)
                {
              ?>
                <option value=<?php echo $majorData['id'] ?>> <?php echo $majorData['description'] ?></option>
              <?php
                }
            ?>
            </select>
          </div>
          <div class="input-control select full-size">
            <select id="minorCategory" style="display:none;">
              <option disabled selected value="0">Choose a Minor Category</option>

              <?php
                $minorDatas = $db->select("minor_category",["id","description"],["ORDER"=>["description"=>"ASC"]]) ;
                foreach($minorDatas AS $minorData)
                {
              ?>
                <option value=<?php echo $minorData['id'] ?>> <?php echo $minorData['description'] ?></option>
              <?php
                }
            ?>
            </select>
          </div>
          <div class="input-control full-size" data-role='select'>
            <select id="locations" style="display:none;">
              <option disabled selected value="0">Choose a Location</option>
              <?php
                $locationDatas = $db->select("location",["id","location"],["ORDER"=>["location"=>"ASC"]]);
                foreach($locationDatas AS $locationData)
                {
              ?>
                <option value=<?php echo $locationData['id'] ?>> <?php echo $locationData['location'] ?></option>
              <?php
                }
            ?>
            </select>
          </div>
          <div class="input-control full-size" data-role="select">
            <select id="conditions" style="display:none;">
              <option disabled selected value="0">Choose a Condition</option>
              <?php
                $conditionDatas = $db->select("condition_info",["id","condition_info"],["ORDER"=>["condition_info"=>"ASC"]]);
                foreach($conditionDatas AS $conditionData)
                {
              ?>
                <option value=<?php echo $conditionData['id'] ?>> <?php echo $conditionData['condition_info'] ?></option>
              <?php
                }
            ?>
            </select>
          </div>

          <div class="input-control select full-size">
            <select id="accountCategory" style="display:none;">
              <option disabled selected value="0">Accountability of</option>

              <?php
                $accountDatas = $db->select("account_table",["emp_id","first_name","last_name","department"]) ;
                foreach($accountDatas AS $accountData)
                {
              ?>
                <option value=<?php echo $accountData['emp_id'] ?>> <?php echo $accountData['last_name'] .", ". $accountData['first_name']. " - ". $accountData['department']?></option>
              <?php
                }
            ?>
            </select>
          </div>
          <span class="text-light">Periperals</span><br/>
          <br/>
          <div class="padding20">
            <label class="input-control intermediate checkbox">
                <input type="checkbox" id="parent" name="periperalsParent">
                <span class="check"></span>
                <span class="caption">Parent Property</span>
            </label>
            <label class="input-control intermediate checkbox">
                <input type="checkbox" id="sub" name="periperalsSub">
                <span class="check"></span>
                <span class="caption">Sub Property</span>
            </label>
          </div>
          <div class="padding10" id="subProperty" style="border:0.5px solid rgba(0,0,0,0.5); display:none;">
            <div class="padding10" id="subProperties">
            <small>Add Sub Property</small>
              <button onClick='addAnotherSubProperty()' class="mini-button button primary place-right"><span class="mif-plus icon"></span></button>
            </div>
          </div>
          <div class="padding10" id="parentProperty" style="border:0.5px solid rgba(0,0,0,0.5); display:none;">
            <div class="padding10" id="parentProperties">
            <small>Add Parent</small>
            </div>
          </div>
          <span class="text-light">Rental Equipment</span><br/>
          <div class="padding20">
            <label class="input-control intermediate checkbox" >
                <input type="checkbox" id="rental" name="rentalEquipment">
                <span class="check"></span>
                <span class="caption">Rental Equipment</span>
            </label>
          </div>
          <div class="padding10 full-size" id="rentalEquipments" style="border:0.5px solid rgba(0,0,0,0.5); display:none;">
            <div class="padding10" id="rentals">
            <small>Add Supplier</small>
              <div class="input-control full-size" data-role="select">
                <select id="supplierSelecter" style="width:100%;display:none;">
                  <option selected value="0">Select Supplier</option>
                  <?php

                  $supplierSelects = $db->select("supplier",["sup_id","sup_name"]);
                  foreach($supplierSelects as $supplierSelect){
                    echo '<option value='.$supplierSelect['sup_id'].'>'.$supplierSelect['sup_name'].'</option>';
                  }

                  ?>
                </select>
              </div>
            </div>
          </div>
          <br/>
          <button class="button warning" onclick="addProperty()">Add Property</button>
        </div>
      </div>
      <div data-role="dialog" data-place = "top-center" style='overflow-y:scroll' data-height="100%" class="padding20" data-overlay="true"  data-width="30%"  data-overlay-color="op-dark" data-overlay-click-close="true" id="editPropertyDialog" data-close-button="true">
        <h3 class="text-light header">Edit Property <span id="propertyName"></span></h3>
        <input type="hidden" id="propertyId" />
        <div class="input-control full-size">
          <input type="text" id="editPropertyCode" placeholder="Property Code"/>
        </div>
        <div class="input-control full-size">
          <input type="text" id="editSerialNumber" placeholder="Serial Number"/>
        </div>
        <div class="input-control full-size textarea">
          <textarea type="text" id="editPropertyDescription" placeholder="Property Description"></textarea>
        </div>
        <div class="input-control full-size">
          <input type="text" id="editBrand" placeholder="Property Brand" />
        </div>
        <div class="input-control full-size">
          <input type="text" id="editModel" placeholder="Property Model"/>
        </div>
        <div class="input-control number full-size">
          <input type="number" id="editQty" placeholder="Quantity"/>
        </div>
        <div class="input-control full-size select" data-role="select" data-placeholder="Minor Category">
          <select id="editMinorId"style="display:none;" >
            <option selected disabled value="0">Select a Minor Category</option>
            <?php
              $editMinorDatas=$db->select("minor_category",["id","description"]);
              foreach($editMinorDatas as $editMinorData)
              {
                echo "<option value=".$editMinorData['id'].">".$editMinorData['description']."</option>";
              }
            ?>
          </select>
        </div>
        <div class="input-control full-size">
          <input type="text" id="editUom" placeholder="Unit of Measurement"/>
        </div>
        <div class="input-control full-size">
          <input type="text" id="editCost" placeholder="Cost"/>
        </div>
        <div class="input-control full-size"/>
          <input type="text" id="ornumber" placeholder="P.O Number"/>
        </div>
        <div class="input-control text full-size">
            <input type="date" id="editDateAcquired"  placeholder="Date Acquired">
        </div>
        <!-- <div class="input-control text full-size" data-role="datepicker" data-scheme="darcula" data-format="yyyy-mm-d">
            <input type="text" id="editDateAcquired" placeholder="Date Acquired">
            <button class="button"><span class="mif-calendar"></span></button>
        </div> -->

          <div class="input-control full-size" id="editSupplier" style="display:none;" data-role="select">
            <small>Edit Supplier</small><br/>
            <select id="editSpplierSelecter" style="width:100%;display:none;">
              <option selected disable value="0">Select Supplier</option>
              <?php

              $supplierSelects = $db->select("supplier",["sup_id","sup_name"]);
              foreach($supplierSelects as $supplierSelect){
                echo '<option value='.$supplierSelect['sup_id'].'>'.$supplierSelect['sup_name'].'</option>';
              }

              ?>
            </select>
          </div>

        Current Image<br/>
        <div class="image-container">
          <div class="frame">
            <img id="files">
          </div>
        </div>
        <form method="POST" action="build/ajax/uploadUpdateImage.php" enctype="multipart/form-data" id="formUpload">
          <input type="hidden" name="propertiesId" id="propertiesId" />
          <div class="input-control file full-size" data-role="input">
              <input type="file" name="mainteUploader" id="mainteUploader">
              <button class="button" type="button"><span class="mif-folder"></span></button>
          </div>
        </form>
        <button class="button primary" onclick="updateProperty();"><span class="mif-pencil icon"></span> Update Property</button>
      </div>
      <div data-role="dialog" data-overlay="true" class="padding20" data-overlay-color="op-dark" data-overlay-click-close="true" id="deletePropertyDialog" data-close-button="true">
        <input type="hidden" id="deletePropertyID" />
        <h5 class="text-light">Are you sure you want to Delete? <br/><b><span id="propertyCode"></span></b></h5>
        <button class="button danger" onclick="DeleteProperty()"> Delete</button>
        <button class="button default" onclick="hideMetroDialog('#deletePropertyDialog')"> Cancel</button>
        <!-- <div class="input-control"/>
          edittable values here
        </div> -->
      </div>
    </div>
  </div>
  </body>

<script src="build/js/jquery.dataTables.min.js"></script>
<script src="build/js/mainteProperty.js"></script>
<script src="build/js/jquery.form.min.js"></script>
<script src="build/js/select2.min.js"></script>
<script src="build/js/admin.js"></script>
</html>
