<?php
class ElggManifestValidatorTest extends PHPUnit_Framework_TestCase {

	private function getGoodFilePaths() {
		$path = dirname(__FILE__) . '/test_files/manifests18/good/';
		$files = array(
			$path . 'manifest1.xml',
			$path . 'manifest2.xml',
			$path . 'manifest3.xml',
			$path . 'manifest4.xml',
			$path . 'manifest5.xml',
			$path . 'manifest6.xml',
		);
		return $files;
	}

	public function testXsdValidationGoodInputs() {
		$schemaPath = dirname(dirname(dirname(__FILE__))) . '/xsds/manifest18.xsd';
		$files = $this->getGoodFilePaths();
		if (!extension_loaded('dom')) {
			$this->markTestSkipped("DOM extension is required");
		}
		foreach ($files as $filePath) {
			$xml = new DOMDocument();
			$xml->load($filePath);

			$this->assertTrue($xml->schemaValidate($schemaPath));
		}
	}

	public function testXsdValidationBadInputs() {
		$schemaPath = dirname(dirname(dirname(__FILE__))) . '/xsds/manifest18.xsd';
		$path = dirname(__FILE__) . '/test_files/manifests18/bad/';
		$files = array(
//			$path . 'manifest1.xml',//FIXME we don't catch missing fields...
//			$path . 'manifest2.xml',
			$path . 'manifest3.xml',
		);
		if (!extension_loaded('dom')) {
			$this->markTestSkipped("DOM extension is required");
		}
		foreach ($files as $filePath) {
			$xml = new DOMDocument();
			$xml->load($filePath);

			try {
				$this->assertFalse($xml->schemaValidate($schemaPath));
				$this->fail("Should have failed on validation!");
			} catch (PHPUnit_Framework_Error_Warning $e) {
				$prefix = 'DOMDocument::schemaValidate(): Element \'{http://www.elgg.org/plugin_manifest/1.8}not_defined_field\': This element is not expected.';
				$this->assertStringStartsWith($prefix, $e->getMessage());
			}
		}
	}

//	public function testRngValidationGoodInputs() {
//		$schemaPath = dirname(dirname(dirname(__FILE__))) . '/rngs/manifest18.rng';
//		$path = dirname(__FILE__) . '/test_files/manifests18/good/';
//		$files = $this->getGoodFilePaths();
//		if (!extension_loaded('dom')) {
//			$this->markTestSkipped("DOM extension is required");
//		}
//		foreach ($files as $filePath) {
//			$xml = new DOMDocument();
//			$xml->load($filePath);
//
//			$this->assertTrue($xml->relaxNGValidate($schemaPath));
//		}
//	}


}