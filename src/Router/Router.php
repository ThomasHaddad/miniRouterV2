<?php

namespace Router;
use Interfaces\iRoutable;
use Symfony\Component\Yaml\Exception\RuntimeException;

class Router extends \SplObjectStorage{

	public function countRoute(){
		return count($this);
	}

	public function addRoute(iRoutable $route){
		if($this->contains($route)){
			throw new RuntimeException('Route already exists');
		}
		$this->attach($route);
	}

	public function getRoute($url){
		foreach($this as $route){

			$matches=$route->isMatch($url);
			if(!$matches){
				continue;
			}

			$array= [
				'controller'=>$route->getController(),
				'action'=>$route->getAction()
			];
			$params=$route->getParams($matches);
			if($params){
				$array['params']=$params;
				$array['params']=$route->getParams($matches);
			}
			return $array;

		}
		throw new \RuntimeException('Pas de routes');
	}

}