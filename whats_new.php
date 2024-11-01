<?php
/*
Plugin Name: Whats New 
Description: Shows post,pages,products added since user last visit
Plugin URI: http://wordpress.org/plugins/whats-new/
Version: 1.2
Author: Skomfare2
Author URI: http://wordpress.org/plugins/whats-new/
*/

class skomfare2_whats_new {
    
	
	
	public function __construct(){

		//define some constants
		define( 'skomfare2_WHATSNEW_PLUGIN_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
		define( 'skomfare2_WHATSNEW_PLUGIN_DIR', plugin_dir_path(__FILE__) );

		//add the plugin options page on the admin menu
		add_action( 'admin_menu', array($this,'register_skomfare2_menu') );
		

		// associating a function to login hook
		add_action('wp_login', array($this,'skomfare2_set_last_login'));
		
		//enqueue CSS file 
		add_action('wp_footer',array($this,'enqueue_scripts_and_styles'));

    }
	

	
	public function register_skomfare2_menu(){
		
		add_menu_page( 'Whats New', 'Whats New','manage_options', 'skomfare2_whatsnew_post',array( $this, 'show_options_page' ) );
		
	}

	

	public function show_options_page(){
	
		require_once(plugin_dir_path(__FILE__). 'settings_page_form.php');

	}

	
	
	/*
	*	Enqueue CSS 
	*/
	function enqueue_scripts_and_styles(){
	
		wp_enqueue_style( 'skomfare2_whats_new_css',skomfare2_WHATSNEW_PLUGIN_URL.'/style.css' );
	
	}
	
	
	/*
	*	set last login date for user
	*/
	function skomfare2_set_last_login($login) {
	
	   $user = get_user_by('login',$login);
	   
	   if($user->ID==0){
	   
			return ;
			
	   }
	 
	   //add or update the last login value for logged in user
	   update_user_meta( $user->ID, 'skomfare2_last_login', current_time('mysql') );
	   
	}	
	

	
	/*
	* get last login
	*/
	static function skomfare2_get_last_login(){
	
		$current_user = wp_get_current_user();
		
		if( $current_user->ID == 0){
		
			return ;
			
		}
		
		$user_last_login = get_user_meta( $current_user->ID, 'skomfare2_last_login', current_time('mysql') );

		return $user_last_login;
		
	}


	
	/*
	*	Filter posts published after a certain date
	*/
	static function filter_posts_published_after_date($where='') {
	
		$date = skomfare2_whats_new::skomfare2_get_last_login();
		
		$where .= " AND post_date >= '".$date."'";
		
		return $where;
		
	}

	
	
	
	/*
	*	Get posts,pages,products
	*/
	static function skomfare2_get_posts_pages_products() {
	
		//check if a loggedin user or guest
		$current_user = wp_get_current_user();
		
		if( $current_user->ID == 0){
			return ;
		}	
	
		global $post;
				
		//initialize arrays;
		$posts_array=array();		
		$pages_array=array();		
		$products_array=array();

		$response=array();
		
		$total_new_posts_found = 0; 

	
		//get saved options
		$skomfare2_newpost_saved_options = get_option('skomfare2_whatsnew_options');		

		//check if "show new posts" is enabled 
		if(isset($skomfare2_newpost_saved_options) && isset($skomfare2_newpost_saved_options['enabled_for_posts']) && $skomfare2_newpost_saved_options['enabled_for_posts']=='yes'){
				
				$args_type_post = array(
					
					'post_type' => 'post',
					'post_status' => 'publish',
					'showposts' => -1,
					'perm' => 'readable'
					
				);

				//Filter by date
				add_filter( 'posts_where', array('skomfare2_whats_new','filter_posts_published_after_date'));
				
				$query2_posts = new WP_Query( $args_type_post );
				
				remove_filter( 'posts_where', array('skomfare2_whats_new','filter_posts_published_after_date'));
				
				
				// Create an array with posts infos
				if ( $query2_posts->have_posts() ) {
				
					while ( $query2_posts->have_posts() ) {
					
						$query2_posts->the_post();
						
						$posts_array[get_the_id()]['id'] = get_the_id();
						
						$posts_array[get_the_id()]['title'] = get_the_title();
						
						$posts_array[get_the_id()]['permalink'] = get_the_permalink();
						
						$posts_array[get_the_id()]['author'] = get_the_author();

						
						//What image to show 
						if($skomfare2_newpost_saved_options['show_images']=='yes'){
							
							//POST FEATURED IMAGE
							$page_featured = wp_get_attachment_image( get_post_thumbnail_id($query2_posts->post->ID),'thumbnail');
							
							if($page_featured){
							
								$posts_array[get_the_id()]['featured_image'] = $page_featured;
								
							}
								
						}
										
					} //end while
					
				} //end if have_posts
				
				wp_reset_query();
				
				
				$response['posts']= $posts_array;
				
				//increase total posts count
				$total_new_posts_found = $total_new_posts_found +  count($posts_array);

		} // end IF enabled for posts	
					
					
				
		//check if "show new pages" is enabled
		if(isset($skomfare2_newpost_saved_options) && isset($skomfare2_newpost_saved_options['enabled_for_pages']) && $skomfare2_newpost_saved_options['enabled_for_pages']=='yes'){
				
				$args_type_pages = array(
					'post_type' => 'page',
					'post_status' => 'publish',
					'showposts' => -1,
					'perm' => 'readable'
				);
				
				//Filter by date
				add_filter( 'posts_where', array('skomfare2_whats_new','filter_posts_published_after_date'));
				
				$query2_pages = new WP_Query( $args_type_pages );	
				
				remove_filter( 'posts_where', array('skomfare2_whats_new','filter_posts_published_after_date'));
				
				
				// Create an array with pages infos
				if ( $query2_pages->have_posts() ) {
				
					while ( $query2_pages->have_posts() ) {
					
						$query2_pages->the_post();
						
						$pages_array[get_the_id()]['id'] = get_the_id();
						
						$pages_array[get_the_id()]['title'] = get_the_title();
						
						$pages_array[get_the_id()]['permalink'] = get_the_permalink();
						
						$pages_array[get_the_id()]['author'] = get_the_author();

						
						//What image to show 
						if($skomfare2_newpost_saved_options['show_images']=='yes'){
							
							//POST FEATURED IMAGE
							$post_featured = wp_get_attachment_image( get_post_thumbnail_id($query2_pages->post->ID),'thumbnail');
							
							if($post_featured){
							
								$pages_array[get_the_id()]['featured_image'] = $post_featured;
								
							}
								
						}
										
					} //end while
					
				} //end if have_posts				
				
			wp_reset_query();
				
			$response['pages']= $pages_array;
			$total_new_posts_found = $total_new_posts_found +  count($pages_array);
				
		} //end IF enabled for pages		
		
		
					
					
		//check if "show new woocommerce products" is enabled
		if(isset($skomfare2_newpost_saved_options) && isset($skomfare2_newpost_saved_options['enabled_for_wc_products']) && $skomfare2_newpost_saved_options['enabled_for_wc_products']=='yes'){
		
				$args_type_product = array(
					'post_type' => 'product',
					'post_status' => 'publish',
					'showposts' => -1,
					'perm' => 'readable'
				);
				
				//Filter by date
				add_filter( 'posts_where', array('skomfare2_whats_new','filter_posts_published_after_date'));
				
				$query2_product = new WP_Query( $args_type_product );	
				
				remove_filter( 'posts_where', array('skomfare2_whats_new','filter_posts_published_after_date'));
				
				
				// Create an array with pages infos
				if ( $query2_product->have_posts() ) {
				
					while ( $query2_product->have_posts() ) {
					
						$query2_product->the_post();
						
						$products_array[get_the_id()]['id'] = get_the_id();
						
						$products_array[get_the_id()]['title'] = get_the_title();
						
						$products_array[get_the_id()]['permalink'] = get_the_permalink();
						
						$products_array[get_the_id()]['author'] = get_the_author();

						
						//What image to show 
						if($skomfare2_newpost_saved_options['show_images']=='yes'){
							
							//PRODUCT FEATURED IMAGE
							$product_featured = wp_get_attachment_image( get_post_thumbnail_id($query2_product->post->ID),'thumbnail');
							
							if($product_featured){
							
								$products_array[get_the_id()]['featured_image'] = $product_featured;
								
							}
								
						}
										
					} //end while
					
				} //end if have_posts				
				
				wp_reset_query();
				
			$response['products']= $products_array;
			
			$total_new_posts_found = $total_new_posts_found + count($products_array);
				
		} //end IF enabled for wc products		

		$response['total_found'] = $total_new_posts_found;
		
		
		
		return $response;
		
	}	

	/*
	*	Get the excerpt by id
	*/
	function get_excerpt_by_id($post_id){
	
		$skomfare2_get_saved_options_excerpt_length = get_option('skomfare2_whatsnew_options');	
	
		$the_post = get_post($post_id); 
		
		$the_excerpt = $the_post->post_content; 
		
		$excerpt_length = $skomfare2_get_saved_options_excerpt_length['excerpt_length']; //Sets excerpt length by word count
		
		$the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
		
		$words = explode(' ', $the_excerpt, $excerpt_length + 1);
		
		if(count($words) > $excerpt_length) {
			
			array_pop($words);
			
			array_push($words, '…');
			
			$the_excerpt = implode(' ', $words);
		}
		
		$the_excerpt = '<p>' . $the_excerpt . '</p>';
		
		return $the_excerpt;
	}	
	
	/*
	*	Find template
	*/
	static public function skomfare2_locate_template($file){

			//check if we are overriding from the theme folder
			if (file_exists(TEMPLATEPATH . '/skomfare2_whatsnew/'.$file)){
				$return_template = TEMPLATEPATH .'/skomfare2_whatsnew/'.$file;
			}
			else {
				//no overridings. use the templates from plugin folder
				$return_template = skomfare2_WHATSNEW_PLUGIN_DIR . 'templates/'.$file;
				
			}

			return $return_template;

	}
		
		

	/*
	* Register the shortcode
	*/
	static public function add_shortcode_support(){
	
		global $skomfare2_whatsnew_ouput_array;
		
		$rendered_output='';
		
		$options_array = get_option('skomfare2_whatsnew_options');
		
		//print_r($options_array);
		
		
		$new_posts_text_header = $options_array['skomfare2_whatsnew_post_header'];
		$new_pages_text_header = $options_array['skomfare2_whatsnew_page_header'];
		$new_products_text_header = $options_array['skomfare2_whatsnew_product_header'];

		$show_featured_image = $options_array['show_images'];
		$show_author = $options_array['show_author'];
		$show_date = $options_array['show_date'];
		
		$show_excerpt = $options_array['show_excerpt'];
		
		$nothing_new_posted = $options_array['nothing_new'];
		
		

		$skomfare2_whatsnew_ouput_array = self::skomfare2_get_posts_pages_products();
		
		
		ob_start();
		
		$template = self::skomfare2_locate_template('whatsnew.php');
		
		//if nothing new 
		
		if($skomfare2_whatsnew_ouput_array['total_found'] <= 0){

			$skomfare2_whatsnew_ouput_array['error']='Nothing new';

		}

		
		include($template);
		
		$rendered_output = ob_get_clean();
					
		return $rendered_output;

	}
	



} //end class
 
 
 
$skomfare2_whats_new = new skomfare2_whats_new();

add_shortcode( 'albdesign_whatsnew', array( 'skomfare2_whats_new','add_shortcode_support' ) );
add_shortcode( 'skomfare2_whatsnew', array( 'skomfare2_whats_new','add_shortcode_support' ) );

