<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Application_Helper
{
	protected $_controller;
	
	public function __construct()
	{
		$this->_controller =& get_instance();
	}
	
	/**
	 * This function
	 * @param unknown $filePath
	 * @return mixed
	 */
	protected function _getFileName($filePath)
	{
		$parserFilePath = explode('/', $filePath);
		$fileName = end($parserFilePath);
		return $fileName;
	}
	
	protected function _getModelName($modelFilePath)
	{
		$parserFilePath = explode('/', $modelFilePath);
		$fileName = end($parserFilePath);
		if(!empty($fileName)){
			$fileName = str_replace('.php', '', $fileName);
			$fileName = str_replace('_', ' ', $fileName);
			$fileName = ucwords($fileName);
			return str_replace(' ', '_', $fileName);
		}
		
		return null;
	}
	
	protected function _getControllerName($controllerFilePath)
	{
		$parserFilePath = explode('/', $controllerFilePath);
		$fileName = end($parserFilePath);
		if(!empty($fileName)){
			$fileName = str_replace('.php', '', $fileName);
			return ucwords($fileName);
		}
		
		return null;
	}
	
	/**
	 * This function generates a html template lists all of comments in each functions in a 
	 * model file.
	 * 
	 * @param String $filePath The path of the file
	 * @return Ambigous <NULL, string> The html template contains comments.
	 */
	public function getAppModelOverviews($filePath)
	{
		$html = NULL;
		$modelName = $this->_getModelName($filePath);
		if(!empty($modelName)){
			$this->_controller->load->model($modelName);
			$model = new ReflectionClass($modelName);
			$html = $this->getClassMethodComment($model);
		}
		return $html;
	}
	
	/**
	 * This function generates a html template lists all of comments in each functions in a 
	 * controller file.
	 * 
	 * @param String $filePath The path of the file
	 * @return Ambigous <NULL, string> The html template contains comments.
	 */
	public function getAppControllerOverviews($filePath)
	{
		$html = NULL;
		$controllerName = $this->_getControllerName($filePath);
		if(!empty($controllerName)){
			$module = $this->getModuleByPath($filePath,$controllerName);
			if($controllerName != get_class($this->_controller)){
				$this->_controller->load->controller($module.$controllerName);
			}
			$controller = new ReflectionClass($controllerName);
			$html = $this->getClassMethodComment($controller);
		}
		return $html;
	}
	
	protected function getModuleByPath($filePath,$name)
	{ 
		$module = NULL;
		$filePath = substr($filePath,24,-4);
		if($filePath != strtolower($name)){
			$module = str_replace(strtolower($name), '', $filePath);
		}
		return $module;
	}
	
	protected function getClassMethodComment($ReflectionClass)
	{
		$html = NULL;
		$methods = $ReflectionClass->getMethods();
		foreach($methods as $method)
		{
			$name = $method->name;
			$params = $method->getParameters();
			$p = array();
			foreach($params as $param ){
				$p[] = '$'.$param->name;
			}
			$p = implode(', ', $p);
			$comments = $method->getDocComment();
			$html .= <<<EOT
			<div class="panel panel-default">
  				<div class="panel-heading">
    				<h3 class="panel-title">Method: {$name}({$p})</h3>
  				</div>
  				<div class="panel-body">
    			{$comments}
				  </div>
			</div>
EOT;
		}
		return $html;
	}
	
	/**
	 * This function traversals directory files and puts these files'name into an array.
	 * 
	 * @param String $path
	 * @param array $filter
	 * @param number $deep
	 * @return multitype:multitype: string multitype:multitype: NULL string
	 */
	public static function traversalDirectoryFile($path, $filter = array(), $deep = 1)
	{
		$deep--;
		$rootList = array();
		$handle = opendir($path);
		while($file = readdir($handle)){
	  		if($file == '.' || $file == '..'){
	   			continue;
	  		}
	  		$newFilePath = $path . DIRECTORY_SEPARATOR . $file;
	  		$nodeArrTmp = $nodeArr = explode(DIRECTORY_SEPARATOR, $newFilePath);
	  		
	  		array_pop($nodeArrTmp);
	  		$parentNode = array_pop($nodeArrTmp);
	  		$node = $file = iconv('GB2312', 'UTF-8', end($nodeArr));
	  		
	  		if(!in_array($node, $filter)){
		  		if(is_dir($newFilePath)){
		  			$rootList[$node] = array();
		  			if($deep > 0){
			   			$rootList[$node] = self::traversalDirectoryFile($newFilePath, $filter, $deep);
		  			}
		  		}
		  		if(is_file($newFilePath)){
		  			$file = $node;
					$rootList[] = $file;
		  		}
	  		}
	 	}
	 	closedir($handle);
	 	
	 	return $rootList;
	}
	/**
	 * This function finds all files in the path and lists them. 
	 * 
	 * @param string $path The path of the folder
	 * @param string $module The path of the module
	 * @return string $html The html template about files.
	 */
	public function getRander($path=MODEL_PATH, $module='')
	{
		$html = '';
		if($module){
			$path = $path.'/'.$module;
		}
		
		$folders = $this->traversalDirectoryFile($path, array('.svn'));
		foreach($folders as $k => $file){
			if($file == 'index.html'){
				continue;
			}
			if(is_array($file)){
				$filepath = $path.'/'.$k;
				$html .= '<li class="folder">'.$k.'<ul>';
				$html .= $this->getRander($filepath);
				$html .= '</ul><li>';
			}else{
				$html .= '<li class="file" data="'.$path.'/'.$file.'">'.$file.'</li>';
			}
		}
		return $html;
		
	}
	
}
