<?php
namespace Router;
use Interfaces\iRoutable;
use Symfony\Component\Yaml\Exception\RuntimeException;

Class Route implements iRoutable{
	private $route=[];
	private $arrayConnect;
	public function __construct($route){
		$this->route=$route;
		$this->setConnect();
	}
	public function setConnect(){
		$this->arrayConnect=explode(':',$this->route['connect']);
		if(count($this->arrayConnect)!=2){
			throw new RuntimeException('not enough connection parameters');
		}
	}
	public function getController(){
		return $this->arrayConnect[0];
	}
	public function getAction(){
		return $this->arrayConnect[1];
	}
	public function getParams($matches){
		$params=[];
		$arrayParams=explode(',',$this->route['params']);
		foreach($arrayParams as $v){
			$params[$v]=$matches[$v];
		}
		return $params;
	}
	public function isMatch($url){
		$pattern='/^'.$this->route['pattern'].'$/';
		$check=preg_match($pattern,$url,$matches);
		if(!$check){
			return false;
		}
		return $matches;
	}
}