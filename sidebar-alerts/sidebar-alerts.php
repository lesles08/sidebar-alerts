<?php
/**
 * Plugin Name: Sidebar Alerts
 * Plugin URI: http://lesliew.com
 * Description: Creates alert box widget
 * Author: Leslie W
 * Author URI: http://lesliew.com
 * Version: 0.1.0
 */

/**
 * Adds Alert_Widget widget.
 */
class Alert_Widget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      'alert_widget', // Base ID
      esc_html__( 'Alert Widget', 'text_domain' ), // Name
      array( 'description' => esc_html__( 'Alert Widget for sidebar', 'text_domain' ), ) // Args
    );
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
    extract( $args );
    $title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
    $alert_textarea = isset( $instance['alert_textarea'] ) ?$instance['alert_textarea'] : '';
    if ( $title || $alert_textarea) {
      echo $before_widget;
      echo '<div class="widget-text wp_widget_plugin_box">';

      if ( $title ) {
        echo '<div class="widgettitle">'.$title.'</div>';
      }
      if ( $alert_textarea ) {
        echo '<div class="sidebar-alerts">' . $alert_textarea . '</div>';
      }
      echo '</div>';
      echo $after_widget;
    }
  }

  public function form( $instance ) {

    $defaults = array(
    'title'    => '',
    'text'     => '',
    'alert_textarea' => '',
    'checkbox' => '',
    'select'   => '',
  );
  
  // Parse current settings with defaults
  extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'alert_textarea' ) ); ?>"><?php _e( 'Alert:', 'text_domain' ); ?></label>
    <textarea class="widefat" rows="5" cols="5" id="<?php echo esc_attr( $this->get_field_id( 'alert_textarea' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'alert_textarea' ) ); ?>"><?php echo wp_kses_post( $alert_textarea ); ?></textarea>
    </p>
    <?php 
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
    $instance['alert_textarea'] = isset( $new_instance['alert_textarea'] ) ? wp_kses_post( $new_instance['alert_textarea'] ) : '';

    return $instance;
  }

} // class Alert_Widget
// register alert_widget widget
function register_alert_widget() {
    register_widget( 'Alert_Widget' );
}
add_action( 'widgets_init', 'register_alert_widget' );
?>
