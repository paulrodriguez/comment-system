<?php
declare(strict_types=1);

$base_path = dirname(dirname(dirname(__FILE__)));
require $base_path.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'Globals.php';

require APP_ROOT.DS.'configs'.DS.'Db.php';
require APP_ROOT.DS.'models'.DS.'DbConn.php';
require APP_ROOT.DS.'models'.DS.'Comment.php';

use PHPUnit\Framework\TestCase;
class CommentTest extends TestCase {
  public function setUp() {
    $this->_obj = new \Model\Comment();
  }
  public function testCreateInstance() {
    $this->assertInstanceOf('\Model\Comment',$this->_obj);
  }

  /**
   * data is return for valid field
   */
  public function testSetDataValidField() {
    $this->_obj->setData('author','Paul');
    $this->assertEquals('Paul',$this->_obj->getData('author'));
  }

  /**
   * data for invalid field key should return null
   */
  public function testSetDataInvalidValidField() {
    $this->_obj->setData('field1','Paul');
    $this->assertEquals(null,$this->_obj->getData('field1'));
  }

  public function testDataCount() {
    $this->_obj->setData('field1','Paul');
    $this->_obj->setData('author','Paul');
    $this->_obj->setData('parent_id',0);
    $this->assertCount(2,$this->_obj->getData());
  }


}
