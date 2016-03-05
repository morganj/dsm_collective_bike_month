<?php

function TssFrontpageUI(){
$ulp = 'ultimate-landing-page';
	$ulp_install_link = '<a href="' . esc_url( network_admin_url('plugin-install.php?tab=plugin-information&plugin=' . $ulp . '&TB_iframe=true&width=600&height=550' ) ) . '" class="thickbox" title="More info about ' . $ulp . '">Install Now' . '</a>';


$tss = 'ultimate-bar';
	$tss_install_link = '<a href="' . esc_url( network_admin_url('plugin-install.php?tab=plugin-information&plugin=' . $tss . '&TB_iframe=true&width=600&height=550' ) ) . '" class="thickbox" title="More info about ' . $tss . '">Install Now' . '</a>';

$msfp = 'mailchimp-subscribe-sm';
	$msfp_install_link = '<a href="' . esc_url( network_admin_url('plugin-install.php?tab=plugin-information&plugin=' . $msfp . '&TB_iframe=true&width=600&height=550' ) ) . '" class="thickbox" title="More info about ' . $msfp . '">Install Now' . '</a>';


$pss = 'posts-slider';
	$pss_install_link = '<a href="' . esc_url( network_admin_url('plugin-install.php?tab=plugin-information&plugin=' . $pss . '&TB_iframe=true&width=600&height=550' ) ) . '" class="thickbox" title="More info about ' . $pss . '">Install Now' . '</a>';



	?>
<style type="text/css">
	.butt_tes{
		background: #2fd123; 
		color:#fff;
		 text-decoration:none;
		 border-radius:10px;
		 padding:20px 50px 20px 50px; 
		 border-bottom:10px solid #0DAD01;
		 margin-bottom: 10px;
		 display: inline-block;
		 float: right;
		 margin-left: 20px;
		 font-size: 18px;
	}
	.butt_tes2{
		font-size: 18px;
		 background: #00A0D2; 
		 color:#fff;
		 text-decoration:none;
		 border-radius:10px;
		 padding:20px 50px 20px 50px; 
		 border-bottom:10px solid #037BA1;
		 margin-bottom: 40px;
		 display: inline-block;
		 float: right;
		 margin-left: 20px;
	}
	.butt_tes2:hover{
		color: #e3e3e3;
	}
	.ub-heading-bar{
		background-color: #00A0D2;
		padding:25px 30% 25px 30%;
		text-align: center;
		color: #fff;
		font-size: 38px;
		margin-left: -20px;
	}
</style>

		<h1 class="ub-heading-bar" >Testimonials Plugin</h1>
		<div id="detasd">
			<p>
				If you have any issues or want us to make some changes Contact Us 24/7 : <span style='color:#00A0D2;'>support@web-settler.com</span>
			</p>
		</div>
		<div id='sec_left'>

		<a  style='' class="butt_tes2" 
			href="post-new.php?post_type=tss_data"> Add New Testimonial</a>
		
		<a  style='' class="butt_tes2" 
			href="edit.php?post_type=tss_data"> All Testimonials </a>
		
			<a style='' class="butt_tes" 
			href="edit.php?post_type=tss_slider"><b>All Sliders</a>
			
			<a  style='' class="butt_tes" 
			href="post-new.php?post_type=tss_slider">Add New Testimonial Slider</a>
			<br>
			<br>
			<br>
			<br>
			
			</div>
		
		<div id='sec_right'>
				<h3>Recommended Plugins</h3>
				<img src="<?php echo plugins_url('imgs/ulp.png',__FILE__); ?>" class="rc_plugin_thumb">
				<p><b>Ultimate Landing Page - <?php echo $ulp_install_link; ?></p>
				<img src="<?php echo plugins_url('imgs/psp.png',__FILE__); ?>" class="rc_plugin_thumb">
				<p>Posts Slider Plugin - <?php echo $pss_install_link; ?></p>
				<img src="<?php echo plugins_url('imgs/ts.png',__FILE__); ?>" class="rc_plugin_thumb">
				<p>Ultimate Bar Plugin - <?php echo $tss_install_link; ?></p>
				<img src="<?php echo plugins_url('imgs/msf.png',__FILE__); ?>" class="rc_plugin_thumb">
				<p>Subscribe Form Plugin - <?php echo $msfp_install_link; ?></p>
				<p>Need Help ? <br> Or Hire a developer : <a href="mailto:support@web-settler.com?subject=Posts Slider Support" "Email Us" target="_blank">Email Us</a> </p>
				</b>
		</div>
		<div id='how-to-use'>
			<ul>
			<h3>How to use :</h3>
				<li>
					Step 1. Add New Testimonials.
				</li>
				<li>
					Step 2. Add New Slider.
				</li>
				<li>
					Step 3. Setup your slider.
				</li>
				<li>
					Step 4. Copy shortcode and paste at the place where you want your testimonials to be displayed.
				</li>
				<li>
				</li>

				
			</ul>
		</div>

		
		


		<style>
		#how-to-use{
			position: absolute;
			top: 40%;
		 	left: 40px;
		 	background-color: #fff;
		 	border: 2px solid #e3e3e3;
		 	border-radius: 10px;
		 	padding: 20px;
		 	margin-top: 80px;

		}
		#detasd{
			background-color: #fff;
		 	border: 2px solid #e3e3e3;
		 	border-radius: 10px;
		 	padding: 20px;
		 	width: 70%;
		}
		#img_ad{
			width:50%;
			height: 400px;
			display: inline-block;
			float: left;
			margin-top: 15px;
		}
		.rc_plugin_thumb{
			width: 200px;
			height: 100px;
			border:7px solid #fff;
			background: #fff;
		}

		#sec_left{
			margin-top:100px;
			width:50%;
			display: inline-block;
			float: left;
		}
		#sec_right{
			margin-top:10px;
			width:20%;
			display: inline-block;
			float: right;
			background: #e3e3e3;
			padding: 20px;

		}
		#prem_ver{
			display: inline-block;
			margin-top: 100px;
			padding: 40px;
			background: #23282D;
			color: #fff;


		}

			#rate_button{
		text-align: center;
		padding:8% 5% 8% 5%;
		background:#FFA635;font-size:22px;border:none;color:#fff; border-bottom:10px solid #E08A1C;
		text-decoration: none;
		border-radius: 10px;
		margin-top: 22px;
		font-size: 29px;
	}
	#rate_button:hover{
		background: #FF9918;

	}
	#rate_button:active{
		border: none;
		padding-top: 9%;
	}

	#prem_ver > li{
		font-size: 18px;
		line-height: 1.2em;
	}

		</style>

	<?php


}


 ?>