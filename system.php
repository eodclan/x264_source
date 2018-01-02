<?php
// ************************************************************************************//
// * D€ Source 2018
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2017 - 2018 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************// 
require_once(dirname(__FILE__) . "/include/engine.php");
x264_errormsg_header("Security Tactics System");

print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-warning'></i>Error
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
      <div class='error-page'>

        <div class='error-content'>
          <h3><i class='fa fa-warning text-red'></i> Oops! Something went wrong.</h3>

          <p>
            We've saved your illegal or inappropriate access and directors were informed! <a href='" . $GLOBALS["DEFAULTBASEURL"] . "/index.php' style='color:#555;'>Back to WebSite</a>
          </p>

        </div>
      </div>
      <!-- /.error-page -->
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>"; 

x264_errormsg_footer();
?>