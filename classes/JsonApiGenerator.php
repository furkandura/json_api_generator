<?php



class JsonApiGenerator
{

    const JSONFILENOTFOUND = "Json dosyası bulunamadı.";
    const RECORDNOTFOUND = "Aradığınız kayıt bulunamadı.";
    public $requestArr;
    public $errors = [];

    public function __construct()
    {
        $this->requestArr = $this->parseURI($_SERVER['REQUEST_URI']);
    }

    public function run()
    {
        $jsonFileName = $this->requestArr[0];
        $jsonSearchKey = $this->requestArr[1] ?? null;
        $jsonSearchVal = $this->requestArr[2] ?? null;

        $jsonData = $this->readJsonFile($jsonFileName);

        if (!is_null($jsonSearchKey) && !is_null($jsonSearchVal)) {
            $jsonData = $this->search($jsonData, $jsonSearchKey, $jsonSearchVal);

            if (count($jsonData) == 0) $this->setError(self::RECORDNOTFOUND);
        }


        if (!is_null($this->getErrors())) {
            return $this->getErrors();
        } 

        return json_encode($jsonData);
    }


    public function readJsonFile(string $jsonFileName)
    {
        $jsonFileDir = sprintf("jsons/%s.json", $jsonFileName);

        if (!file_exists($jsonFileDir)) {
            return $this->setError(self::JSONFİLENOTFOUND);
        }

        $jsonContent = file_get_contents($jsonFileDir);

        return json_decode($jsonContent, true);
    }



    public function search($array, $key, $value)
    {
        $results = [];

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->search($subarray, $key, $value));
            }
        }

        return (array)$results;
    }


    public function parseURI($uri)
    {
        $uriArr = explode("/", urldecode($uri));
        array_shift($uriArr);
        return $uriArr;
    }

    public function setError(string $errorMsg)
    {
        $this->errors[] = $errorMsg;
    }

    public function getErrors()
    {
        if (count($this->errors) == 0) return null;

        return json_encode([
            "status" => "error",
            "message" => implode(', ', $this->errors)
        ]);
    }
}
