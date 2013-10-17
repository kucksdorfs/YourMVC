<?php
include 'Models/Reflection.php';
use YourMVC\Reflection;

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


echo YourMVC\YourReflection::HasStaticMethod(new HelloWorld(), "StaticHelloWorld") == true ? "true" : "false";
echo '</br>';
echo YourMVC\YourReflection::HasInstanceMethod ( new HelloWorld (), "sayHelloTo" ) == true ? "true" : "false";
echo '</br>';
echo YourMVC\YourReflection::HasInstanceMethod ( new HelloWorld (), "reflectNotGoingToFindMe" ) == true ? "true" : "false";

