<?php
namespace YourMVC\Libraries
{

    /**
     * Allows for a simplified use of Reflection in the YourMVC framework.
     *
     * @author stephen
     */
    class YourReflection
    {
        // Inquery methods
        /**
         * Determine if an object has a method.
         *
         * @param unknown $object
         *            - The object to find the method.
         * @param unknown $methodName
         *            - The name of the method to find.
         * @return boolean - True if the method is found, false otherwise.
         */
        public static function HasInstanceMethod($object, $methodName)
        {
            $reflect = new \ReflectionClass($object);
            if (! $reflect->hasMethod($methodName))
                return false;
            $method = new \ReflectionMethod($object, $methodName);
            return ! $method->isStatic() && ! $method->isPrivate();
        }

        /**
         * Determine if a class has a static method.
         *
         * @param string $className
         *            - The name of the class.
         * @param string $methodName
         *            - The name of the static method.
         * @return boolean True if the static method exists, false otherwise.
         */
        public static function HasStaticMethod($className, $methodName)
        {
            $reflect = new \ReflectionClass($className);
            if (! $reflect->hasMethod($methodName))
                return false;
            $method = new \ReflectionMethod($className, $methodName);
            return $method->isStatic() && ! $method->isPrivate();
        }

        public static function HasInstanceMember($className, $memberName)
        {
            $reflect = new \ReflectionClass($className);
            if (! $reflect->hasProperty($memberName))
                return false;
            $reflectMember = new \ReflectionProperty($className, $memberName);
            return ! $reflectMember->isStatic() && ! $reflectMember->isPrivate();
        }

        public static function HasStaticMember($className, $memberName)
        {
            $reflect = new \ReflectionClass($className);
            if (! $reflect->hasProperty($memberName))
                return false;
            $reflectMember = new \ReflectionProperty($className, $memberName);
            return $reflectMember->isStatic() && ! $reflectMember->isPrivate();
        }
        // Invoke Methods
        /**
         * Call the method in the object.
         *
         * @param object $object
         *            - The object the method should be called on
         * @param string $methodName
         *            - The name of the method to be called.
         * @param array $parameters
         *            - Parameters that should be passed to the method.
         * @param object $retValue
         *            - The return value of the object (should be null when passed in).
         * @return boolean - true of the method executed successfully, otherwise false.
         */
        public static function InvokeInstanceMethod($object, $methodName, $parameters, &$retValue)
        {
            $reflect = new \ReflectionClass($object);
            if (! $reflect->hasMethod($methodName))
                return false;
            $method = new \ReflectionMethod($object, $methodName);
            if ($method->isStatic() || $method->isPrivate()) {
                return false;
            }
            if ($method->getNumberOfRequiredParameters() > count($parameters) || $method->getNumberOfParameters() < count($parameters)) {
                return false;
            }
            $retValue = null;
            if (is_null($parameters)) {
                $retValue = $method->invoke($object);
            } else {
                $retValue = $method->invokeArgs($object, $parameters);
            }
            return true;
        }

        /**
         * Call a static method of a class.
         *
         * @param string $className
         *            - The name of the class the static method belongs to.
         * @param string $methodName
         *            - The name of the static method to be called.
         * @param array $parameters
         *            - Parameters that should be passed to the static method.
         * @param object $retValue
         *            - The return value of the object (should be null when passed in).
         * @return boolean - true of the method executed successfully, otherwise false.
         */
        public static function InvokeStaticMethod($className, $methodName, $parameters, &$retValue)
        {
            $reflect = new \ReflectionClass($className);
            if (! $reflect->hasMethod($methodName))
                return false;
            $method = new \ReflectionMethod($className, $methodName);
            if (! $method->isStatic() || $method->isPrivate()) {
                return false;
            }
            $retValue = null;
            if (is_null($parameters)) {
                $retValue = $method->invoke(null);
            } else {
                $retValue = $method->invoke(null, $parameters);
            }
            return true;
        }
        // Member Values
        public static function GetInstanceMemberValue($object, $memberName)
        {
            $reflectMember = new \ReflectionProperty($object, $memberName);
            if ($reflectMember->isStatic() || $reflectMember->isPrivate())
                throw new \Exception("The member is not accessible.");
            return $reflectMember->getValue($object);
        }

        public static function GetStaticMemberValue($className, $memberName)
        {
            $reflect = new \ReflectionClass($className);
            if (! $reflect->hasProperty($memberName))
                throw new \Exception("The member does not exist.");
            $reflectMember = new \ReflectionProperty($className, $memberName);
            if (! $reflectMember->isStatic() || $reflectMember->isPrivate())
                throw new \Exception("The member is not accessible.");
            return $reflectMember->getValue(null);
        }

        /**
         * Creates a new instance of of the $className passed in.
         *
         * @param string $className
         *            - The full name of the class (namespace and classname)
         * @param array $args
         *            - Arguments to be passed into the constructor.
         * @return NULL object Returns null if the class is not there, otherwise the initialized object.
         */
        public static function CreateNewInstance($className, $args = null)
        {
            __autoload($className);
            try {
                $instance = new \ReflectionClass($className);
            } catch (\Exception $ex) {
                return null;
            }
            if (! is_null($args)) {
                return $instance->newInstance($args);
            }
            return $instance->newInstance();
        }
    }
}