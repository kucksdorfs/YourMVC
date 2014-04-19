<?php
namespace YourMVC\Libraries\Logging
{

    interface iLogging
    {

        function WriteInformation($message);

        function WriteWarning($message);

        function WriteError($message);
    }
}