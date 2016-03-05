<?php 
class FB_event{
	
	//Fields
	private $name;
	private $start_date;
	private $start_date_day;
	private $starth_month;
	private $start_time;
	private $location;
	private $description;
	private $eid;
	private $pic_big;
	
	//Constructor
	public function FB_event($name, $start_date, $start_date_day, $start_month, $start_time, $location, $description, $eid, $pic_big){
			$this->name = $name;
			$this->start_date_day = $start_date_day;
			$this->start_date = $start_date;
			$this->start_month = $start_month;
			$this->start_time = $start_time;
			$this->location = $location;
			$this->description = $description;
			$this->eid = $eid;
			$this->pic_big = $pic_big;
		}
		
	//Methods
	private function Get_description_excerpt() {return substr(nl2br($this->description),0, 200); }
		
	/** 
	* Return html formated representation of event
	*/
	public function Print_event(){
		
		$random_color =	sprintf( "#%06X\n", mt_rand( 0, 0xFFFFFF )); 
		
		return ('<a data-gmstat="1" style="border-color: ' .  $random_color .
		'" class="hasFtIMG event_repeat desc_trig sin_val evcal_list_a"><span class="ev_ftImg" style="background-image:url(' . $this->pic_big .')"></span><span class="evcal_cblock" data-bgcolor="#ed705a" ><em class="evo_date"><span class="start">' . $this->start_date_day . '<em>' . $this->start_month . '</em></span></em><em class="evo_time"></em><em class="clear"></em></span><span class="evcal_desc evo_info " ><span class="evcal_desc2 evcal_event_title" itemprop="name">' . $this->name . '</span><span class="evcal_desc_info"><em>' . $this->start_time . '</em>, <em>' . $this->location . '</em></span><span class="evcal_desc3"></span></span><em class="clear"></em></a>
		<div class="event_description evcal_eventcard lightboxik" id="lightboxik" style="display: none;">
			<a href="' . $this->pic_big . '">
			<div class="evo_metarow_fimg evorow" data-imgheight="730" data-imgwidth="1095" style="background-image: url(&quot;' . $this->pic_big . '&quot;); background-repeat: no-repeat;  
			background-attachment: scroll;  
			background-position: center center;
			background-size: contain; " data-imgstyle="minmized" data-minheight="230" data-status="close">
			</div></a>
			
			<div class="evo_metarow_details evorow evcal_evdata_row bordb evcal_event_details">
				<div class="event_excerpt" style="display:none"><h3 class="padb5 evo_h3">' . __( 'Details', 'fb-display-events-shortcode' ) . '</h3><p>' . $this->Get_description_excerpt() . '[...]</p></div>
				<span class="evcal_evdata_icons"><i class="fa fa-align-justify"></i></span>
				<div class="evcal_evdata_cell shorter_desc" orhei="150" style=""><div class="fdes_details_shading_bot">
				<p class="fdes_shad_p" content="less"><span class="ev_more_text" data-txt="<strong>' . __( 'Less', 'fb-display-events-shortcode' ) . '</strong>"><strong>... ' . __( 'Show More', 'fb-display-events-shortcode' ) . '</strong></span><span class="ev_more_arrow"></span></p>
				</div><div class="fdes_full_description">
						<h3 class=" evo_h3">' . __( 'Details', 'fb-display-events-shortcode' ) . '</h3><div class="fdes_desc_in" itemprop="description">
						<p>' . nl2br($this->description) . '</p>
						</div><div class="clear"></div>
					</div>
				</div>
			</div>
			
		<div class="evo_metarow_time_location evorow bordb ">
			<div class="tb">
				<div class="tbrow">
					<div class="evcal_col50 bordr">
						<div class="evcal_evdata_row evo_time">
							<span class="evcal_evdata_icons"><i class="fa fa-clock-o"></i></span>
							<div class="evcal_evdata_cell">							
								<h3 class="evo_h3">' . __( 'Time', 'fb-display-events-shortcode' ) . '</h3><p>' . $this->start_time . '<br> ' . $this->start_date . '</p>
							</div>
						</div>
					</div>
					<div class="evcal_col50">
						<div class="evcal_evdata_row evo_location">
							<span class="evcal_evdata_icons"><i class="fa fa-map-marker"></i></span>
							<div class="evcal_evdata_cell">							
								<h3 class="evo_h3">' . __( 'Location', 'fb-display-events-shortcode' ) . '</h3><p>' . $this->location . '</p>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="evo_metarow_cusF1 evorow evcal_evdata_row bordb evcal_evrow_sm ">
			<span class="evcal_evdata_custometa_icons"><i class="fa fa-list-alt"></i></span>
			<div class="evcal_evdata_cell">							
				<h3 class="evo_h3">Facebook link</h3>
				<div class="evo_custom_content evo_data_val">
					<a href="https://www.facebook.com/events/' . $this->eid . '/" target="_blank">' . __( 'Go to facebook', 'fb-display-events-shortcode' ) . '</a></p>
				</div>
			</div>
		</div>');
	}
}
?>