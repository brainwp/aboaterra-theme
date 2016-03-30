<?php
/**
 * Widget API: WP_Widget_Section_Title
 *
 * @package odin
 */

/**
 * Core class used to implement a Text widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class WP_Widget_Section_Title extends WP_Widget {

	/**
	 * Sets up a new Text widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_section_title',
			'description' => __( 'Arbitrary text or HTML.' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'section_title', __( 'Título de Seção', 'odin' ), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the content for the current Text widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Text widget instance.
	 */
	public function widget( $args, $instance ) {

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$widget_sub_title = ! empty( $instance['sub-title'] ) ? $instance['sub-title'] : '';

		echo $args['before_widget'];
		if ( ! empty( $title ) ) : ?>
			<div class="col-md-12 section-title-bg">
				<h2 class="section-title">
					<?php echo apply_filters( 'the_title', $title );?>
				</h2><!-- .section-title -->
				<?php if ( ! empty( $widget_sub_title ) ) : ?>
					<div class="section-sub-title">
						<span class="sub-title">
							<?php echo apply_filters( 'the_title', $widget_sub_title );?>
						</span>
					</div><!-- .section-sub-title -->
				<?php endif;?>
			</div><!-- .col-md-12 section-title-bg -->
		<?php endif; ?>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Handles updating settings for the current Text widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['sub-title'] = $new_instance['sub-title'];
		} else {
			$instance['sub-title'] = wp_kses_post( $new_instance['sub-title'] );
		}
		return $instance;
	}

	/**
	 * Outputs the Text widget settings form.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'sub-title' => '' ) );
		$title = sanitize_text_field( $instance['title'] );
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'odin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'sub-title' ); ?>"><?php _e( 'Sub-title:', 'odin' ); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('sub-title'); ?>" name="<?php echo $this->get_field_name('sub-title'); ?>"><?php echo esc_textarea( $instance['sub-title'] ); ?></textarea></p>

		<?php
	}
}

/**
 * Register the Widget.
 */
function wp_widget_section_title_register() {
	register_widget( 'WP_Widget_Section_Title' );
}

add_action( 'widgets_init', 'wp_widget_section_title_register' );
