<?php
declare(strict_types=1);

$base_path = dirname(dirname(dirname(__FILE__)));
require $base_path.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'Globals.php';


require APP_ROOT.DS.'models'.DS.'Block.php';

use PHPUnit\Framework\TestCase;
class BlockTest extends TestCase {
  public function testCreateInstance() {
    $block = new \Model\Block();
    $this->assertInstanceOf('\Model\Block',$block);
  }

  /**
   * test setting data is correctly saved
   */
  public function testSetData() {
    $block = new \Model\Block();
    $block->setData('field1','value1');
    $this->assertEquals('value1',$block->getData('field1'));
  }

  /**
   * return null when key does not exist in data
   */
  public function testEmptyField() {
    $block = new \Model\Block();
    $this->assertEquals(null,$block->getData('field1'));
  }

  /**
   * field count of data matches the data we set
   */
  public function testDataArray() {
    $block = new \Model\Block();
    $block->setData('field1','value1');
    $block->setData('field2','value2');
    $this->assertCount(2,$block->getData());
  }

  public function testJsUrl() {
      $block = new \Model\Block();
      $url = DOMAIN_URL.'assets/js/test.js';
      $this->assertEquals($url,$block->getJsUrl('test'));
  }

  public function testCssUrl() {
    $block = new \Model\Block();
    $url = DOMAIN_URL.'assets/css/styles.css';
    $this->assertEquals($url,$block->getCssUrl('styles'));
  }

  public function testActrionUrl() {
    $block = new \Model\Block();
    $url = DOMAIN_URL.'getComments';
    $this->assertEquals($url,$block->getUrl('getComments'));
  }

}
