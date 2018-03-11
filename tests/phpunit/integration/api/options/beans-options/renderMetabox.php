<?php
/**
 * Tests for render_metabox() method of the _Beans_Options.
 *
 * @package Beans\Framework\Tests\Integration\API\Options
 *
 * @since   1.5.0
 */

namespace Beans\Framework\Tests\Integration\API\Options;

use _Beans_Options;
use Beans\Framework\Tests\Integration\API\Options\Includes\Options_Test_Case;
use Brain\Monkey;

require_once dirname( __DIR__ ) . '/includes/class-options-test-case.php';

/**
 * Class Tests_Beans_Options_Render_Metabox
 *
 * @package Beans\Framework\Tests\Integration\API\Options
 * @group   api
 * @group   api-options
 */
class Tests_Beans_Options_Render_Metabox extends Options_Test_Case {

//	/**
//	 * Test render_metabox() should return null when the section does not fields registered.
//	 */
//	public function test_should_return_null_when_no_fields_registered() {
//		$instance = new _Beans_Options();
//
//		foreach ( static::$test_data as $option ) {
//			// Register the option.
//			$instance->register( $option['section'], $option['args'] );
//
//			// Run the test.
//			$this->assertNull( $instance->render_metabox() );
//		}
//	}

	/**
	 * Test render_metabox() should render registered fields.
	 */
	public function test_should_render_registered_fields() {
		$instance = new _Beans_Options();

		// Register the field and option.
		$option = end( static::$test_data );
		beans_register_fields( $option['fields'], 'option', $option['section'] );
		beans_add_smart_action( 'beans_field_checkbox', 'beans_field_checkbox' );
		$instance->register( $option['section'], $option['args'] );

		// Run the method and grab the HTML out of the buffer.
		ob_start();
		$instance->render_metabox();
		$html = ob_get_clean();

		// Run the tests.
		$this->assertFileExists( BEANS_THEME_DIR . '/lib/api/fields/types/checkbox.php' );
		$expected = <<<EOB
<div class="bs-field-wrap bs-checkbox option">
	<div class="bs-field-inside">
		<div class="bs-field bs-checkbox">
			<input type="hidden" value="0" name="beans_fields[beans_dev_mode]" />
			<input id="beans_dev_mode" type="checkbox" name="beans_fields[beans_dev_mode]" value="1" />
			<span class="bs-checkbox-label">Enable development mode</span>
		</div>
	</div>
</div>
EOB;
		$this->assertSame( $this->format_the_html( $expected ), $this->format_the_html( $html ) );
	}
}
