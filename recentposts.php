<?php
/*
Plugin Name: Recent Posts for CM
Description: Site specific code changes for cricketmachan.com
*/
/* Start Adding Functions Below this Line */


/* Stop Adding Functions Below this Line */
// Creating the widget 
class cm_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'cm_widget', 

// Widget name will appear in UI
__('CM Recent Posts', 'cm_widget_domain'), 

// Widget description
array( 'description' => __( 'Display your recent posts', 'wpb_widget_domain' ), ) 
);
}


// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'no_of_posts' ] ) ) {
$title = $instance[ 'no_of_posts' ];
}
else {
$title = __( 10, 'cm_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'no_of_posts' ); ?>"><?php _e( 'Number of Posts to Show:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'no_of_posts'  ); ?>" name="<?php echo $this->get_field_name( 'no_of_posts' ); ?>" type="number" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['no_of_posts'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] .  $args['after_title'];

// This is where you run the code and display the output
	$buzz=array(
	'orderby'=>'date',
	'posts_per_page'=>$instance[ 'no_of_posts' ],
	'offset'=>5,
	
	);
	$querybuz=new WP_Query($buzz);
		$count=2;
				while($querybuz->have_posts()):$querybuz->the_post();
					if ($count%2==0):
					get_template_part('content-four');
					else:
					get_template_part('content-four-blue');
					endif;
					$count++;
				endwhile;
//-----------------------------------------------
echo $args['after_widget'];
}
		

	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['no_of_posts'] = ( ! empty( $new_instance['no_of_posts'] ) ) ? strip_tags( $new_instance['no_of_posts'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function cm_load_widget() {
	register_widget( 'cm_widget' );
}
add_action( 'widgets_init', 'cm_load_widget' );
?>
