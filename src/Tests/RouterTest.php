<?php
namespace Tests;
use Router\Router;
use Router\Route;
use Symfony\Component\Yaml\Yaml;
class RouterTest extends \PHPUnit_Framework_TestCase
{
	protected $router;
	protected $routeYML;
	protected $url;
	public function setUp()
	{
		$this->router = new Router;
		$this->routeYML = Yaml::parse(__DIR__ . '/Fixtures/routes.yml');
		$this->url = Yaml::parse(__DIR__.'/Fixtures/urls.yml');
	}
	public function assertPreConditions()
	{
		$this->assertEquals(0, count($this->router));
	}
	public function testAddRoute()
	{
		foreach($this->routeYML as $route){
			$this->router->addRoute(new Route($route));
		}
		$this->assertEquals(count($this->routeYML), count($this->router));
	}
	public function testGetAction(){
		foreach($this->routeYML as $route){
			$this->router->addRoute(new Route($route));
		}
		foreach($this->router as $route){
				$tests=['index','show'];
				$this->assertTrue(in_array($route->getAction(),$tests));
		}
	}
	public function testGetController(){
		foreach($this->routeYML as $route){
			$this->router->addRoute(new Route($route));
		}
		foreach($this->router as $route){
			$this->assertEquals('Controllers\BlogController',$route->getController());
		}
	}
	public function testUrlBlogControllerShowId()
	{
		foreach($this->routeYML as $route){
			$this->router->addRoute(new Route($route));
		}
		$id = 0;
		foreach ($this->url['BlogController_show'] as $url) {
				$this->assertEquals(json_encode([
				'controller' => 'Controllers\BlogController',
				'action' => 'show',
				'params' => [
					'id' => (string) ++$id
				]
			]), json_encode($this->router->getRoute($url)));
 		}
	}
}