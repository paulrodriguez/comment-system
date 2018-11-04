<?php
namespace Model;
/**
 * allows to render template files for UI.
 * contains some helper functions to getting asset files and
 * passing data to template
 */
class Block {
	private $_data;
	public function __construct() {
		$this->_data = array();
	}

	/**
	 * set value for this instance that can be used in template file
	 * @param $key
	 * @param $value
	 */
	public function setData($key,$value) {
		if($key!='' and $key!=null) {
			$this->_data[$key] = $value;
		}

		return $this;
	}

	/**
	 * get specific value based on key
	 * if key does not exists return null
	 * if no key specified, return all data
	 * @param $key
	 * @return string|array|null
	 */
	public function getData($key=null) {
		if($key==null) {
			return $this->_data;
		}
		if(isset($this->_data[$key])) {
			return $this->_data[$key];
		} else {
			return null;
		}
	}

	/**
	 * render a phtml file for UI part of app.
	 * @param $file_path: array of location to file under 'views folder'. each entry is a folder
	 * last entry is the file name without the extension
	 */
	public function render($file_path) {
		if(!is_array($file_path)) {
			$file_path = array($file_path);
		}

		$full_path = implode(DS,$file_path);

		require APP_ROOT.DS.'views'.DS.$full_path.'.phtml';
	}

	public function getBaseUrl() {
		return DOMAIN_URL;
	}

	public function getBaseAssetsUrl() {
		return DOMAIN_URL.'assets/';
	}

	/**
	 * get url for js file inside assets folder
	 * TODO: allow to get files nested in folders
	 */
	public function getJsUrl($js_file) {
		return $this->getBaseAssetsUrl().'js/'.$js_file.'.js';
	}

	/**
	 * get url for css file inside assets folder
	 * TODO: allow to get files nested in folders
	 */
	public function getCssUrl($css_file) {
		return $this->getBaseAssetsUrl().'css/'.$css_file.'.css';
	}

	public function getUrl($action) {
		return DOMAIN_URL.$action;
	}
}
