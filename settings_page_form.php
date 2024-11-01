<?php 


if(isset($_POST)){
	
	
	if(isset($_POST['skomfare2_whatsnew_post_header']) && $_POST['skomfare2_whatsnew_post_header']!=''){
	
		$skomfare2_whatsnew_options_array = array();
	
		//save option for new pages
		$skomfare2_whatsnew_options_array['enabled_for_pages'] = (isset($_POST['skomfare2_whatsnew_popup_for_pages'])) ? sanitize_text_field($_POST['skomfare2_whatsnew_popup_for_pages']) : 'no';
		
		//save option for new posts
		$skomfare2_whatsnew_options_array['enabled_for_posts'] = (isset($_POST['skomfare2_whatsnew_popup_for_posts'])) ? sanitize_text_field($_POST['skomfare2_whatsnew_popup_for_posts']) : 'no';
		
		//save option for new wc_products
		$skomfare2_whatsnew_options_array['enabled_for_wc_products'] = (isset($_POST['skomfare2_whatsnew_popup_for_wc_products'])) ? sanitize_text_field($_POST['skomfare2_whatsnew_popup_for_wc_products']) : 'no';

		//save new posts  text header
		$skomfare2_whatsnew_options_array['skomfare2_whatsnew_post_header'] = (isset($_POST['skomfare2_whatsnew_post_header'])) ? sanitize_text_field($_POST['skomfare2_whatsnew_post_header']) : 'New Posts';

		//save new pages  text header		
		$skomfare2_whatsnew_options_array['skomfare2_whatsnew_page_header'] = (isset($_POST['skomfare2_whatsnew_pages_header'])) ? sanitize_text_field($_POST['skomfare2_whatsnew_pages_header']) : 'New Pages';
		
		//save new products  text header		
		$skomfare2_whatsnew_options_array['skomfare2_whatsnew_product_header'] = (isset($_POST['skomfare2_whatsnew_products_header'])) ? sanitize_text_field($_POST['skomfare2_whatsnew_products_header']) : 'New Products';
	

		//save what image to show
		$skomfare2_whatsnew_options_array['show_images'] = (isset($_POST['skomfare2_whatsnew_show_image'])) ? sanitize_text_field($_POST['skomfare2_whatsnew_show_image']) : 'yes';
		
		//save author
		$skomfare2_whatsnew_options_array['show_author'] = (isset($_POST['skomfare2_whatsnew_show_author'])) ? sanitize_text_field($_POST['skomfare2_whatsnew_show_author']) : 'yes';
		
		//save show date
		$skomfare2_whatsnew_options_array['show_date'] = (isset($_POST['skomfare2_whatsnew_show_date_published'])) ? sanitize_text_field($_POST['skomfare2_whatsnew_show_date_published']) : 'no';
		
		//save show excerpt 
		$skomfare2_whatsnew_options_array['show_excerpt'] = (isset($_POST['skomfare2_whatsnew_show_excerpt'])) ? sanitize_text_field($_POST['skomfare2_whatsnew_show_excerpt']) : 'yes';
		
		//save excerpt length
		$skomfare2_whatsnew_options_array['excerpt_length'] = (isset($_POST['skomfare2_whatsnew_show_excerpt_word_length'])) ? sanitize_text_field($_POST['skomfare2_whatsnew_show_excerpt_word_length']) : '35';
		
		
		//save "nothing new"
		$skomfare2_whatsnew_options_array['nothing_new'] = (isset($_POST['nothing_new'])) ? sanitize_text_field($_POST['nothing_new']) : 'No new post found';		
		
		
		//update option 
		update_option('skomfare2_whatsnew_options',$skomfare2_whatsnew_options_array);
	}
	
}



?>


<div class="wrap" style="background-color: #fff;padding: 20px;">

	<h2>Whats New Settings</h2>
	
	

	<?php 


		//get saved options
		$skomfare2_whatsnew_saved_options = get_option('skomfare2_whatsnew_options');
		
		//get if enabled for pages
		$skomfare2_enabled_for_pages =  (isset($skomfare2_whatsnew_saved_options['enabled_for_pages'])) ? $skomfare2_whatsnew_saved_options['enabled_for_pages']: 'no';
		
		//get if enabled for posts
		$skomfare2_enabled_for_posts =  (isset($skomfare2_whatsnew_saved_options['enabled_for_posts'])) ? $skomfare2_whatsnew_saved_options['enabled_for_posts']: 'no';
		
		//get if enabled for woocommerce products
		$skomfare2_enabled_for_wc_products =  (isset($skomfare2_whatsnew_saved_options['enabled_for_wc_products'])) ? $skomfare2_whatsnew_saved_options['enabled_for_wc_products']: 'no';

		//get new posts text header
		$skomfare2_new_posts_text_header = (isset($skomfare2_whatsnew_saved_options['skomfare2_whatsnew_post_header'])) ? $skomfare2_whatsnew_saved_options['skomfare2_whatsnew_post_header']: 'New Posts Found';
		
		//get new pages text header
		$skomfare2_new_pages_text_header = (isset($skomfare2_whatsnew_saved_options['skomfare2_whatsnew_page_header'])) ? $skomfare2_whatsnew_saved_options['skomfare2_whatsnew_page_header']: 'New Pages Found';
		
		//get new products text header
		$skomfare2_new_products_text_header = (isset($skomfare2_whatsnew_saved_options['skomfare2_whatsnew_product_header'])) ? $skomfare2_whatsnew_saved_options['skomfare2_whatsnew_product_header']: 'New Products Added';

		//get what image to show
		$skomfare2_newposts_show_what_image =  (isset($skomfare2_whatsnew_saved_options['show_images'])) ? $skomfare2_whatsnew_saved_options['show_images']: 'yes';
		
		//get if show author
		$skomfare2_newposts_show_author =  (isset($skomfare2_whatsnew_saved_options['show_author'])) ? $skomfare2_whatsnew_saved_options['show_author']: 'yes';
		
		//get if show date
		$skomfare2_newposts_show_date_published =  (isset($skomfare2_whatsnew_saved_options['show_date'])) ? $skomfare2_whatsnew_saved_options['show_date']: 'no';
		
		//get if show excerpt
		$skomfare2_newposts_show_excerpt =  (isset($skomfare2_whatsnew_saved_options['show_excerpt'])) ? $skomfare2_whatsnew_saved_options['show_excerpt']: 'yes';
		
		
		//get excerpt length
		$skomfare2_newposts_show_excerpt_length =  (isset($skomfare2_whatsnew_saved_options['excerpt_length'])) ? $skomfare2_whatsnew_saved_options['excerpt_length']: '35';
		
		
		//get "nothing new" text 
		$skomfare2_newposts_no_new_posts_text =  (isset($skomfare2_whatsnew_saved_options['nothing_new'])) ? $skomfare2_whatsnew_saved_options['nothing_new']: 'No new post found';
		

		
	?>	
	
	
	<form method="post" >
		<table class="form-table">

			<tr valign="top">
				<th scope="row">Enable notification for new</th>
				<td  colspan="3">
					 <input type="checkbox" name="skomfare2_whatsnew_popup_for_posts" value="yes" <?php echo ($skomfare2_enabled_for_posts=='yes') ? 'checked="checked"' : '' ;  ?> > Posts <br>
					 <input type="checkbox" name="skomfare2_whatsnew_popup_for_pages" value="yes" <?php echo ($skomfare2_enabled_for_pages=='yes') ? 'checked="checked"' : '' ;  ?> > Pages <br>
					


				<?php
				//check if woocommerce is active at all 
				if (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {  
				?>
					<input type="checkbox" name="skomfare2_whatsnew_popup_for_wc_products" value="yes"  <?php echo ($skomfare2_enabled_for_wc_products=='yes') ? 'checked="checked"' : '' ;  ?>> Woocommerce Products <br>
				<?php } ?>

					<p class="description">Select what type of new posting to show </p>
				</td>
			</tr>


			<tr valign="top">
				<th scope="row">Show Excerpt</th>
				<td  colspan="3">
					
						<select name="skomfare2_whatsnew_show_excerpt" >
							<option value="yes"  <?php if( $skomfare2_newposts_show_excerpt =='yes'){ echo ' selected="selected" '; }  ?>>Yes</option>
							<option value="no" <?php if( $skomfare2_newposts_show_excerpt =='no'){ echo ' selected="selected" '; }  ?>>No </option>
						
						</select>
					
					<p class="description">Show excerpt </p>
				</td>
			</tr>			
			
			<tr valign="top">
				<th scope="row">Excerpt Length</th>
				<td  colspan="3">
						<input type="number" min="1" max="9999999" name="skomfare2_whatsnew_show_excerpt_word_length"  value="<?php echo $skomfare2_newposts_show_excerpt_length; ?>">
					<p class="description">Excerpt length </p>
				</td>
			</tr>

			
			<tr valign="top">
				<th scope="row">Show Images</th>
				<td  colspan="3">
					
						<select name="skomfare2_whatsnew_show_image" >
							<option value="yes"  <?php if( $skomfare2_newposts_show_what_image =='yes'){ echo ' selected="selected" '; }  ?>>Show Featured Image</option>
							<option value="no" <?php if( $skomfare2_newposts_show_what_image =='no'){ echo ' selected="selected" '; }  ?>>Dont show images </option>
						
						</select>
					
					<p class="description">Show featured image </p>
				</td>
			</tr>	



			<tr valign="top">
				<th scope="row">Show Author</th>
				<td  colspan="3">
					
						<select name="skomfare2_whatsnew_show_author" >
							<option value="yes"  <?php if( $skomfare2_newposts_show_author =='yes'){ echo ' selected="selected" '; }  ?>>Yes</option>
							<option value="no" <?php if( $skomfare2_newposts_show_author =='no'){ echo ' selected="selected" '; }  ?>>No</option>
						</select>
					
					<p class="description">Show author name </p>
				</td>
			</tr>	
			
			
			<tr valign="top">
				<th scope="row">Show Date Published</th>
				<td  colspan="3">
					
						<select name="skomfare2_whatsnew_show_date_published" >
							<option value="yes"  <?php if( $skomfare2_newposts_show_date_published =='yes'){ echo ' selected="selected" '; }  ?>>Yes</option>
							<option value="no" <?php if( $skomfare2_newposts_show_date_published =='no'){ echo ' selected="selected" '; }  ?>>No</option>
						</select>
					
					<p class="description">Show post/page/product published date </p>
				</td>
			</tr>				

			<tr valign="top">
				<th scope="row"> <h3> Text Customization  </h3> </th>
				<td  colspan="3">&nbsp;</td>
			</tr>			
			
			
			<tr valign="top">
				<th scope="row">Posts  </th>
				<td  colspan="3">
					<input type="text"  name="skomfare2_whatsnew_post_header" value="<?php echo $skomfare2_new_posts_text_header;?>">
					<p class="description">Text for the header of posts section i.e 'New Posts found' .</p>
									
				</td>
			</tr>				


			
			<tr valign="top">
				<th scope="row">Pages  </th>
				<td  colspan="3">
					<input type="text"  name="skomfare2_whatsnew_pages_header" value="<?php echo $skomfare2_new_pages_text_header;?>">
					<p class="description">Text for the header of pages section i.e 'New Pages Published'.</p>
									
				</td>
			</tr>	

			<tr valign="top">
				<th scope="row">Woocommerce Products  </th>
				<td  colspan="3">
					<input  type="text"  name="skomfare2_whatsnew_products_header" value="<?php echo $skomfare2_new_products_text_header;?>">
					<p class="description">Text for the header of product section i.e 'New Products added'.</p>
									
				</td>
			</tr>			
			
			
			

			


			<tr valign="top">
				<th scope="row">No new posts</th>
				<td  colspan="3">
					
						<input type="text" name="nothing_new"  value="<?php echo $skomfare2_newposts_no_new_posts_text; ?>" >

					<p class="description">Text to display if nothing new was posted since user last login time</p>
				</td>
			</tr>			
			
			

		</table>
		
		<h4> Place the shortcode [skomfare2_whatsnew] where you want the plugin to show  </h4>
		
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
		</p>
		
		
		
	</form>
	
	
	
	
	<div>
		<p> <img src="<?php echo skomfare2_WHATSNEW_PLUGIN_URL;?>/icon-heart.png" alt="" width="20" /> We also have other plugins that you might like <a href="http://pidhasome.com/skomfare2/plugins/woocommerce_donations/" target="_blank"> click here</a></p> 
	</div>
	
</div>