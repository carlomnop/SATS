<?php
  session_start();
  require_once('connection.php');
  include('config.php');
  include('validatePage.php');

  $thisPage="Repair";
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Manage Accounts</title>
    <link rel="icon" href="logo/logo.png" type="image/png" sizes="16x22">
    <link href="build/css/metro.css" rel="stylesheet">
    <link href="build/css/backend.css" rel="stylesheet">
    <link href="build/css/admin.css" rel="stylesheet">
    <link href="build/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="build/css/metro-icons.css" rel="stylesheet">
    <link href="build/css/metro-responsive.css" rel="stylesheet">
    <link href="build/css/metro-schemes.min.css" rel="stylesheet">
    <link href="build/css/metro-colors.min.css" rel="stylesheet">
    <script src="build/js/jquery-2-1-3.min.js"></script>
    <script src="build/js/select2.min.js"></script>
    <script src="build/js/metro.js"></script>
  </head>
  <body style="overflow:hidden;">
    <div class="flex-grid no-responsive-feature" style="height:100%;">
        <div class="row" style="height: 100%;">
        <?php include_once('admin_navigation.php'); ?>
          <div class="cell auto-size padding20 no-margin-top grid container place-right" id="style-4" style="overflow-y:scroll;height:100%;">
            <h1 class="text-light fg-darkBrown">Repair Item<span class="mif-ani-fast mif-ani-shuttle
              mif-wrench place-right text-light"></span></h1>

            <hr class="thin bg-grayLighter">
            <div id="history_request_div"  style="display:none;"></div>

            <!--pre loader-->
            <center>
              <div class="cell auto-size padding20" style="height:77.5vh;" data-role="preloader" data-type="cycle" data-style="color"  id="history_loader"></div>
            </center>
          </div>
    </div>
    <div data-role="dialog" class="padding20" data-overlay="true" data-overlay-color="op-dark" data-height="auto" data-width="30%" data-overlay-click-close="true" id="adminAddRecommendation" data-close-button="true">
      <h3 class="padding20 text-light header">Recommendation</h3>
      <input type="hidden" id="audit_id"/>
      <div class="input-control textarea full-size"  data-text-auto-resize="true" data-text-max-height="200">
        <textarea id="recommendation" style="resize:none;"></textarea>
      </div>
      <br/>
      <button class="button danger place-right" onClick="hideMetroDialog('#adminAddRecommendation')"><span class="mif-cross icon"></span></button>
      <button class="button success place-right" onClick="addedRecommendation()"><span class="mif-checkmark icon"></span></button>
    </div>
  </div>
  </body>
  <script src="build/js/jquery.dataTables.min.js"></script>
  <script src="build/js/accountability_repair.js"></script>
</html>
