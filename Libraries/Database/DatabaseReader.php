<?php
namespace YourMVC\Libraries\Database
{

    final class DatabaseReader
    {

        protected $currentRow;

        protected $result;

        final public function __construct($queryResult)
        {
            $result = array();
            for ($i = 0; $i < count($queryResult); ++ $i) {
                $result[] = array_change_key_case($queryResult[$i], CASE_UPPER);
            }
            
            $this->result = $result;
            $currentRow = null;
        }

        final public function Read()
        {
            if (is_null($this->currentRow)) {
                $this->currentRow = 0;
            } else {
                $this->currentRow ++;
            }
            return ($this->currentRow < count($this->result));
        }

        private function GetObjectFromValue($column)
        {
            if (is_null($this->currentRow))
                throw new \Exception("Verify the read function is executed prior to attempting to get data from the DataReader.");
            $currentRow = $this->result[$this->currentRow];
            
            if (is_int($column)) {
                $column = strtoupper($this->GetColumnNameFromIndex($column, $currentRow));
            } else {
                $column = strtoupper($column);
                if (! array_key_exists($column, $currentRow)) {
                    throw new \Exception("The key $column does not exist in the query result.");
                }
            }
            
            return $currentRow[$column];
        }

        private function RemoveInvalidElements($aryObj, $validObjects)
        {
            $retAry = array();
            foreach ($validObjects as $key) {
                if (in_array($key, $aryObj)) {
                    if ($aryObj[$key] != false) {
                        $retAry[$key] = $aryObj[$key];
                    }
                }
            }
            
            return $retAry;
        }

        private function GetColumnNameFromIndex($index, $currentRow)
        {
            $aryKeys = array_keys($currentRow);
            return $aryKeys[$index];
        }

        final public function GetIntValue($column)
        {
            $objValue = $this->GetObjectFromValue($column);
            $retValue = intval($objValue);
            
            if (is_null($retValue))
                return null;
            elseif (! is_int($retValue) && $retValue != $objValue) {
                throw new \Exception("The value of the column $column is not an integer.");
            }
            return $retValue;
        }

        final public function GetFloatValue($column)
        {
            $objValue = $this->GetObjectFromValue($column);
            $retValue = floatval($objValue);
            if (is_null($retValue))
                return null;
            elseif (! is_float($retValue) && $retValue != $objValue) {
                throw new \Exception("The value of the column $column is not a float.");
            }
            return $retValue;
        }

        final public function GetStringValue($column)
        {
            $retValue = $this->GetObjectFromValue($column);
            if (is_null($retValue))
                return null;
            if (! is_string($retValue)) {
                throw new \Exception("The value of the column $column is not a string.");
            }
            return $retValue;
        }

        final public function GetBooleanValue($column)
        {
            $objValue = $this->GetObjectFromValue($column);
            $retValue = boolval($objValue);
            if (is_null($retValue))
                return null;
            elseif (! is_bool($retValue))
                throw new \Exception("The value of the column $column is not a boolean.");
            return $retValue;
        }

        final public function GetDateValue($column)
        {
            $retValue = $this->GetObjectFromValue($column);
            if (is_null($retValue))
                return null;
            
            $validElements = array(
                "day",
                "month",
                "year"
            );
            $retValue = $this->RemoveInvalidElements(date_parse($retValue), $validElements);
            if (count($retValue) == 0)
                throw new \Exception("The value of the column $column is not a valid Date.");
            
            return $retValue;
        }

        final public function GetTimeValue($column)
        {
            $retValue = $this->GetObjectFromValue($column);
            if (is_null($retValue))
                return null;
            
            $validElements = array(
                "hour",
                "minute",
                "second",
                "fraction"
            );
            $retValue = $this->RemoveInvalidElements(date_parse($retValue), $validElements);
            if (count($retValue) == 0)
                throw new \Exception("The value of the column $column is not a valid Time.");
            
            return $retValue;
        }

        final public function GetDateTimeValue($column)
        {
            $retValue = $this->GetObjectFromValue($column);
            if (is_null($retValue))
                return null;
            
            $validElements = array(
                "day",
                "month",
                "year",
                "hour",
                "minute",
                "second",
                "fraction"
            );
            $retValue = $this->RemoveInvalidElements(date_parse($retValue), $validElements);
            if (count($retValue) == 0)
                throw new \Exception("The value of the column $column is not a valid Date/Time.");
            
            return $retValue;
        }
    }
}