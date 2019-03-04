<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_My_Custom_Elementor_Thing extends Widget_Base {

	public function get_name() {
		return 'my-test-widget';
	}
	public function get_title() {
		return __( 'בדיקות', 'plugin-name' );
	}

	public function get_icon() {
		return 'fa fa-user';
	}
	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'בדיקות', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'fname',
			[
				'label' => __( 'כתוב שם פרטי.', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'ירין', 'plugin-name' ),
			]
		);

		$this->add_control(
			'lname',
			[
				'label' => __( 'כתוב שם משפחה.', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'עיאש', 'plugin-name' ),
			]
		);
		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$fname = wp_oembed_get( $settings['fname'] );
		$lname = wp_oembed_get( $settings['lname'] );
		echo '<div class="elementor-widget text-center">';

		$firstName = ( $fname ) ? $fname : $settings['fname'];
		$lastName = ( $lname ) ? $lname : $settings['lname'];
		if ( ! empty( $settings['image']['url'] ) ) {
			$this->add_render_attribute( 'image', 'src', $settings['image']['url'] );
			$this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $settings['image'] ) );
			$this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $settings['image'] ) );

			$image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );

			if ( ! empty( $settings['link']['url'] ) ) {
				echo '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $image_html . '</a>';
			}

			echo '<figure class="elementor-image-box-img">' . $image_html . '</figure>';
			echo '<div class="text-center"><h2 class=" h2">' . $firstName . ' '. $lastName .'</h2></div>';
		}
		echo '</div>';

	}

}


