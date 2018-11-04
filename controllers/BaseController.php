<?php
namespace Controller;
abstract class BaseController {
	/**
	* function that runs on page load to call correct method
	*/
	public function run() {
		$url = explode('/',$_SERVER['REQUEST_URI']);
		//print_r($url);
		$offset = 1;
		if(count($url) < 2) {
			$this->error404();
		}

		if($url[$offset] == '') {
			$this->indexAction();
		} else if($url[$offset]=='assets') {
			return false;
		} else {
			if(method_exists($this,$url[$offset].'Action')) {
				$this->{$url[$offset].'Action'}();
			} else {
				$this->error404();
			}

		}

	}

	public function error404() {
		$block = new \Model\Block();
		$block->render('404');
	}


}
