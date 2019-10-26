<!--<div class="box-portlet virtualsidebar">-->
<div class="left-user-details">

  <div class="header-image" style="margin: 10px 40px;">
      <div class="user-image-sidebar" style="background: url('<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>') no-repeat center center;">&nbsp;</div>
  </div>
  <div style="text-align: center;font-weight: 600;">
    <a href="/user" style="color:#fff;"><span><?php echo um_user( 'first_name' ) . " " . um_user( 'last_name' ); ?></span></a>
    <span class="available_funds" style="display: block;font-size: 13px;margin-top: -5px;"></span>
  </div>
  <div class="realized_unrealized" style="display: flex;margin-top: 12px;">
      <div class="up_realized" style="width: 50%; text-align: center;">
        <span class="up_arrow_realized dgreenpart"><i class="fas fa-arrow-circle-up"></i></span>
        <span class="down_arrow_realized dredpart" style="display: none"><i class="fas fa-arrow-circle-down"></i></span>
      </div>
      <div class="up_unrealized" style="width: 50%; text-align: center;">
        <span class="up_arrow_unrealized dgreenpart"><i class="fas fa-arrow-circle-up"></i></span>  
        <span class="down_arrow_unrealized dredpart" style="display: none"><i class="fas fa-arrow-circle-down"></i></span>     
      </div>
  </div>
  <div class="realized_unrealized" style="display: flex; line-height: 1;">
      <div style="width: 50%; text-align: center; border-right: 1px solid #305273;">
          <span style="font-size: 10px;">Realized P/L</span>
          <span class="realized" style="font-weight: bold; font-size: 13px;"></span>
      </div>
      <div style="width: 50%; text-align: center;">
          <span style="font-size: 10px;">Unrealized P/L</span>
          <span class="unrealized" style="font-weight: bold; font-size: 13px;"></span>
      </div>   
  </div>
  <div class="performance" style="display: flex; line-height: 1;margin-top: 12px;">
      <div style="width: 50%; text-align: center; border-right: 1px solid #305273;">
          <span style="font-size: 10px;">Port Performance</span>
          <span class="vperformance" style="font-weight: bold; font-size: 13px;"></span>
      </div>
      <div style="width: 50%; text-align: center;">
          <span style="font-size: 10px;">Starting Capitalize</span>
          <span class="vcapital" style="font-weight: bold; font-size: 13px;"></span>
      </div>   
  </div>
  <!--<div class="left-user-details-inner">
      <div class="side-header" style="padding-bottom: 10px;">
          <div class="capital">STARTING CAPITAL</div><div class="vcapital">100,000.00</div>
      </div>
      <div class="side-content">
          <div class="side-content-inner sidebariconsvirtual">
              <ul class="sidebarvirtual">
				          <li><span>Realized P/L</span><span class="realized" style="float: right;">₱7,000.00</span></li>
                  <li><span>Unrealized P/L</span><span class="unrealized" style="float: right;">₱7,000.00</span></li>
                  <li><span>Total Equity</span><span class="total_equity" style="float: right;">₱7,000.00</span></li>
                  <li><span>Port Performance</span><span class="vperformance" style="float: right;">₱7,000.00</span></li>
              </ul>
          </div>
      </div>
  </div>-->
</div>
<!--</div>-->