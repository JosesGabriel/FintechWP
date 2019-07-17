<style>
/* Responsive */
.slideleft, .slideright,
.left-slide-trigger, .right-slide-trigger, .top-slide-trigger,
.ui-btn.ui-input-btn.ui-corner-all.ui-shadow {
    display: none;
}
.left-slide-trigger {
	display:none;
	position: fixed;
	top:0;
	bottom:0;
	left:0;
	width: 48px;
	background-color: transparent; 
	z-index: 9999999999;
}
.right-slide-trigger {
	display:none;
	position: fixed;
	top:0;
	bottom:0;
	right:0;
	width: 48px;
	background-color: transparent; 
	z-index: 2147483646;
}
.top-slide-trigger {
    display:none;
    position: fixed;
    top: 0;
    height: 46px;
    width: 46px;
    left: 0;
    z-index: 21474836467;
    background-color: transparent;
}
/* Tablet Landscape */
@media only screen and (min-width: 981px) and (max-width: 1024px){

}
/* Tablet Portrait */
@media only screen and (min-width: 740px) and (max-width: 981px){

	.left-dashboard-part {
		display: none !important;
	}

	.left-slide-trigger {
		display:block !important;
	}

	.slideleft {
		display: block;
	}

	.left-dashboard-part {
		transition: all 0.5s ease;
		position: fixed !important;
		z-index: 2147483646;
		top: 0 !important;
		left: -100%;
		width: 85%;
		background-color: #0d1f33;
		bottom: 0;
	}
	.left-dashboard-part-overlay {
		position: fixed !important;
		z-index: 2147483645;
		top: 0 !important;
		left: 0;
		right: 0;
		width: 100%;
		background-color: rgba(0,0,0,0.6);
		bottom: 0;
		display: none;
	}
	.dashboard-sidebar-left {
		padding: 0 12px 0;
	}

}
/* Mobile */
@media only screen and (max-width: 767px){
	body {
		overflow-x: hidden;
	}
	.center-dashboard-part {
		transition: all 0.5s ease;
	}
	.left-slide-trigger, .right-slide-trigger, .top-slide-trigger,
	.showonmobonly {
		display:block !important;
	}
	.searchbar {
    	display: none !important;
	}
	.slideleft, .slideright {
		display: block;
	}
	.side-content ul li a {
    	padding: 5px !important;
	}
	div#et-main-area {
		padding: 0 12px;
	}
	.center-dashboard-part {
		margin-left: 0;
		z-index: 1;
		min-width: 317px;
		width: 100%;
		max-width: 708px;
	}
	.header-dashboard-inner {
		padding-left: 10px;
		padding-right: 10px;
	}
	.searchbar {
		top: 7px;
    	position: absolute;
		z-index: 99;
		width: 180px;
	}
	.closerff,
	.cls-inner {
		width: 100% !important;
	}
	a.dmeta {
		position: relative;
	}
	.um-activity-bodyinner-txt span.post-image img {
		max-width: 200%;
		margin-left: -50%;
		height: auto !important;
		width: 200% !important;
	}
	.side-content ul li {
		margin-bottom: 5px;
	}
	.slidecloseoverlay {
		z-index: 2147483647;
		position: fixed;
		display: none;
		right: 0;
		left: 200px;
		top: 0;
		bottom: 0;
		height: 100%;
		width: 100%;
	}
	.left-dashboard-part {
		transition: all 0.5s ease;
		position: fixed !important;
		z-index: 2147483646;
		top: 0 !important;
		left: -100%;
		width: 85%;
		background-color: #0d1f33;
		bottom: 0;
	}
	.left-dashboard-part-overlay {
		position: fixed !important;
		z-index: 2147483645;
		top: 0 !important;
		left: 0;
		right: 0;
		width: 100%;
		background-color: rgba(0,0,0,0.6);
		bottom: 0;
		display: none;
	}
	.dashboard-sidebar-left {
		padding: 0 12px 0;
	}
	.inner-main-content {
		position: relative;
	}
	.inner-placeholder .inner-main-content .right-dashboard-part {
		transition: all 0.5s ease;
		display: block !important;
		position: absolute !important;
		float: none !important;
		right: -110%;
		z-index: 9 !important;
		top: -39px !important;
		padding: 15px 29px 0 8px !important;
		background-color: rgb(13, 31, 51) !important;
		width: 100% !important;
		max-width: 512px !important;
		height: auto !important;
	}
	li.eight.slideleft.open img {
		-webkit-transform: scaleX(-1);
  		transform: scaleX(-1);
	}

	body .um-notification-live-feed {
		right: 180px !important;
	}
	.um-notification-live-feed:before{
		right: 13% !important;
	}
	.left-dashboard-part.open {
		left: 0;
	}
	.inner-main-content .left-dashboard-part {
		padding: 9px 0px 0 !important;
	}
	.top-traiders .to-content-part .trader-item .traider-image {
		margin-right: 0 !important;
	}
}
/* Mobile Smaller */
@media only screen and (max-width: 414px){

}

</style>