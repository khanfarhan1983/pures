<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include 'get_api_connect.php';

// Get Treatment and Aligner date
$from_date = $startdate;
    
//$nextdate = date('M j Y', strtotime('+14 days', strtotime($from_date)));
$treatmentend = date('M j Y', strtotime('+'.$no_wks_days. 'days', strtotime($from_date)));

$system_date = date('Y-m-d');
$currentdate = date('M j Y', strtotime($system_date));




//Get No. of days bw dates - Treatment Days counting
$treatmentdays = getTreatmentDays($currentdate,$treatmentend);

function getTreatmentDays($startDate,$endDate){
  $startDate = strtotime($startDate);
  $endDate = strtotime($endDate);

  if($startDate <= $endDate){
    $datediff = $endDate - $startDate;
    return floor($datediff / (60 * 60 * 24));
  }
  return false;
}

//Convert Treatment days spent into percent
$trt_prg = $no_wks_days - $treatmentdays ;
$trt_prd_pct = round(($trt_prg / $no_wks_days)  * 100);
?>
<style type="text/css">
.progress {height:14px;  border: 2px solid #fff; border-radius:7px !important; background:none !important; margin-bottom: 0px !important;}
.progress-bar {background-color: rgba(255, 255, 255, 0.5) !important;}
  <?php $wide = 40; ?>
  .progresswidth {width:<?php echo $trt_prd_pct; ?>%;}
  </style>

<?php


//Get remaining Aligners
$rem_aligners = $treatmentdays/14;
$aligners_rnd = round($rem_aligners);

$rm_wks = round($treatmentdays / 7);
$snextdate = $get_no_wks - $rm_wks ;

$snextdate = $snextdate + 1;	

/*
for($x=0; $x<$snextdate; $x++)
{ 
 $ddays =  ($diffdays * 7);
 $nextdate = date('M j Y', strtotime('+'.$ddays.'days', strtotime($from_date)));
} */
$y = round($snextdate/2); 

for($upd=0; $upd<=$y; $upd++)
{
    //$upd = $upd + 1;    
    $upds = 14 * $y;
   // $upd = $upd * $y; 
    $nextdate = date('M j Y', strtotime('+'.$upds.'days', strtotime($from_date))); 
    //$upd = $upd * $y;
}

//Get No. of days for Aligner Swap - You have XX days until you swap aligners
$remainingdays = getAlignersDays($currentdate,$nextdate);
 
function getAlignersDays($startDate,$endDate){
  $startDate = strtotime($startDate);
  $endDate = strtotime($endDate);

  if($startDate <= $endDate){
    $datediff = $endDate - $startDate;
    return floor($datediff / (60 * 60 * 24));
  }
  return false;
}
?>
<?php if ($remainingdays == NULL || $from_date == "Jan 1 0001") { ?>
 	<div class="row"><div class="col-md-12" style="padding: 30px; background: rgba(216,216,216,0.15); border: 1px solid rgba(151,151,151,0.15);">
<h5 style="letter-spacing: .095em; color:#000; font-size:16px;">Hello <?php echo $cust_name; ?>,</h5>
<h5 style="letter-spacing: .285em; color:gray;">THERE IS NO ALIGNERS SCHEDULE YET!</h5>
</div></div>
<?php } else { ?>

<div class="col-md-7" style="padding: 30px; background: rgba(216,216,216,0.15); border: 1px solid rgba(151,151,151,0.15);">
<h5 style="letter-spacing: .095em; color:#000; font-size:16px;">Hello <?php echo $cust_name; ?>,</h5>
<h5 style="letter-spacing: .285em; color:gray;">YOUR PROGRESS</h5>
<h3 style="color: #9ace6e;">You have <?php  echo $remainingdays; ?> days until you swap aligners.</h3>

<h5 style="letter-spacing: .095em; color:gray; font-size:15px;"><strong>Current Treatment:</strong> Aligner No. 1 started on <?php echo $startdate; ?></h5>

<h5 style="letter-spacing: .095em; color:gray; font-size:15px;"><strong>Next Aligner Set:</strong> Aligner No. <?php echo $y+1; ?> switch on <?php echo $nextdate; ?></h5>

</div>

<div class="col-md-4 col-md-offset-1" style="padding: 7px 30px; background: #9ace6e; ">
<h3 style="color: #FFF">Your future smile is just on the horizon.</h3>

<p style="letter-spacing: .095em; color:#FFF; font-size:11px; line-height: 0px; padding-bottom: 7px;">TREATMENT TIME REMAINING:</p>
<h3 style="font-size:36px; color: #fff; line-height:0px;"><?php echo $treatmentdays-1; ?> days</h3>
<div style="padding:3px 0px;"></div>
<!-- Progress bar -->
<div class="col-sm-8 col-xs-8" style="padding-top:5px; margin-left:-10px;">
   <div class="progress"> 
    <div class="progress-bar progresswidth" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" />
    </div>
  </div>
</div>
<div class="col-sm-3 col-xs-3 col-sm-offset-1 col-xs-offset-1">
<p style="font-size:15px; color: #fff;"><?php echo $trt_prd_pct."%"; ?></p>
</div>

<div class="clearfix"></div>
<div style="padding:5px 0px;"></div>
<p style="letter-spacing: .095em; color:#FFF; font-size:11px;">ALIGNERS REMAINING:</p>
<h3 style="font-size:36px; color: #fff; line-height:0px;"><?php echo $aligners_rnd; ?></h3>

</div>
<?php  } /* if ($treatmentdays <=1 ){ ?>
 <div class="col-md-12" style="padding: 30px; background: rgba(216,216,216,0.15); border: 1px solid rgba(151,151,151,0.15);">
<h5 style="letter-spacing: .095em; color:#000; font-size:16px;">Hello <?php echo $cust_name; ?>,</h5>
<h5 style="letter-spacing: .285em; color:gray;">YOU DID IT!</h5>
<h3 style="color: #9ace6e;">Congratulations!</h3>

<p style="letter-spacing: .095em; color:gray; font-size:15px;">Hey, Hope your smile is looking good</p>
 
 
 <?php }*/ ?>
 

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
