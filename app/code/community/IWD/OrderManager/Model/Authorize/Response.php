<?php

class IWD_OrderManager_Model_Authorize_Response
{
    public $xml;

    public function __construct($response)
    {
        $this->response = $response;
        if ($response) {
            $this->xml = @simplexml_load_string($this->removeResponseXMLNS($response));
        }
    }

    public function getElementContents($elementName)
    {
        $start = "<$elementName>";
        $end = "</$elementName>";
        if (strpos($this->response, $start) === false || strpos($this->response, $end) === false) {
            return false;
        } else {
            $start_position = strpos($this->response, $start) + strlen($start);
            $end_position = strpos($this->response, $end);
            return substr($this->response, $start_position, $end_position - $start_position);
        }
    }

    private function removeResponseXMLNS($input)
    {
        $input = str_replace(' xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd"', '', $input);
        $input = str_replace(' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"', '', $input);
        return str_replace(' xmlns:xsd="http://www.w3.org/2001/XMLSchema"', '', $input);
    }
}
