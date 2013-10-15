<?php
include 'Models/Reflection.php';
use MyMVC\Reflection;

class HelloWorld {
	public function sayHelloTo($name) {
		echo "Hello $name";
	}

	private function reflectNotGoingToFindMe() {
		echo "Hello World!";
	}

	public static function StaticHelloWorld() {
		echo "Hello World!";
	}
}
if(defined('STDIN') )
	echo("Running from CLI");
else
	echo("Not Running from CLI");
echo '<br/>';


echo MyMVC\MyReflection::HasStaticMethod(new HelloWorld(), "StaticHelloWorld") == true ? "true" : "false";
echo '</br>';
echo MyMVC\MyReflection::HasInstanceMethod ( new HelloWorld (), "sayHelloTo" ) == true ? "true" : "false";
echo '</br>';
echo MyMVC\MyReflection::HasInstanceMethod ( new HelloWorld (), "reflectNotGoingToFindMe" ) == true ? "true" : "false";

