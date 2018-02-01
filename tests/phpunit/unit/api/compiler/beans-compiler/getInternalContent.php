<?php
/**
 * Tests the get_internal_content method of _Beans_Compiler.
 *
 * @package Beans\Framework\Tests\Unit\API\Compiler
 *
 * @since   1.5.0
 */

namespace Beans\Framework\Tests\Unit\API\Compiler;

use _Beans_Compiler;
use Beans\Framework\Tests\Unit\API\Compiler\Includes\Compiler_Test_Case;
use org\bovigo\vfs\vfsStream;

require_once dirname( __DIR__ ) . '/includes/class-compiler-test-case.php';

/**
 * Class Tests_Beans_Compiler_Get_Internal_Content
 *
 * @package Beans\Framework\Tests\Unit\API\Compiler
 * @group   unit-tests
 * @group   api
 */
class Tests_Beans_Compiler_Get_Internal_Content extends Compiler_Test_Case {

	/**
	 * Test get_internal_content() should return false when fragment is empty.
	 */
	public function test_should_return_false_when_fragment_is_empty() {
		$compiler = new _Beans_Compiler( array() );

		// Run the test.
		$this->assertfalse( $compiler->get_internal_content() );
	}

	/**
	 * Test get_internal_content() should return false when the file does not exist.
	 */
	public function test_should_return_false_when_file_does_not_exist() {
		// Set up the compiler.
		$fragment = vfsStream::url( 'compiled/fixtures/' ) . 'invalid-file.js';
		$compiler = new _Beans_Compiler( array(
			'fragments' => array( $fragment ),
		) );
		$this->set_current_fragment( $compiler, $fragment );

		// Run the test.
		$this->assertfalse( $compiler->get_internal_content() );
	}

	/**
	 * Test get_internal_content() should return a fragment's contents.
	 */
	public function test_should_return_fragment_contents() {
		// Set up the compiler.
		$fragment = vfsStream::url( 'compiled/fixtures/test.less' );
		$compiler = new _Beans_Compiler( array(
			'fragments' => array( $fragment ),
		) );
		$this->set_current_fragment( $compiler, $fragment );

		// Set up the mocks.
		$this->mock_filesystem_for_fragments( $compiler );

		// Run the tests.
		$contents = $compiler->get_internal_content();
		$this->assertContains( 'body {', $contents );
		$this->assertContains( 'color: @body-color;', $contents );
	}
}
