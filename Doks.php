<?php

class Doks {

    protected $email;
    protected $password;
    protected $jwt;

    const HOST = "https://data.doks.fi/api";
    const VERSION = "v1.3";

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function authenticate() {

        if(!$this->email || !$this->password) {
            return false;
        }

        if(!$data = $this->request("/user/auth", "POST", array("email" => $this->email, "password" => $this->password), false)) {
            return false;
        }

        if(!$data = self::GetDataFromResponse($data)) {
            return false;
        }

        if(!array_key_exists("jwt", $data)) {
            return false;
        }

        $this->jwt = $data["jwt"];

        return true;
    }

    public function request($url, $method="GET", $data=array(), $authenticate=true) {

        if(!$url || !$method) {
            return false;
        }

        if($authenticate) {
            if(!$this->jwt) {
                if(!$this->authenticate()) {
                    return false;
                }
            }
        }

        $url = self::HOST."/".self::VERSION.$url;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        switch($method) {

            case "PATCH":
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
            break;

            case "GET":
            break;

            case "POST":
            curl_setopt($ch, CURLOPT_POST, 1);
            break;

            case "PUT":
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            break;

            case "DELETE":
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;

            default:
            return false;
            break;
        }

        $headers = array("Content-Type: application/json", "Accept: application/json");

        if($this->jwt) {
            array_push($headers, "Authorization: Bearer " . $this->jwt);
            array_push($headers, "X-Authorization: Bearer " . $this->jwt);
        }
                
        if($data) {
            
            if(!$json_data = json_encode($data)) {
                return false;
            }

            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

            array_push($headers, "Content-Length: " . strlen($json_data));
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if($httpcode != 200) {
            return false;
        }

        if($error) {
            return false;
        }

        if(!$json = json_decode($response, true)) {
            return false;
        }

        if(!is_array($json)) {
            return false;
        }

        return $json;

    }

    public function getCustomers() {
        return self::GetDataFromResponse($this->request("/user/customers"));
    }

    public function getOwners($id) {

        if(!$id) {
            return false;
        }
    
        return self::GetDataFromResponse($this->request("/user/customers/".$id."/owners")); 
    }

    public function getIdentifications($id) {
        
        if(!$id) { 
            return false;
        }
        
        return self::GetDataFromResponse($this->request("/user/customers/".$id."/identifications"));
    }

    public function getRequests($id) {

        if(!$id) {
            return false;
        }

        return self::GetDataFromResponse($this->request("/user/customers/".$id."/requests"));
    }

    public function getSignatures($id) {

        if(!$id) {
            return false;
        }

        return self::GetDataFromResponse($this->request("/user/customers/".$id."/signatures"));
    }

    public function getLetters($id) {

        if(!$id) {
            return false;
        }

        return self::GetDataFromResponse($this->request("/user/customers/".$id."/letters"));
    }

    public function getWarnings($id=null) {

        if(!$id) {
            return self::GetDataFromResponse($this->request("/user/warnings"));
        }

        return self::GetDataFromResponse($this->request("/user/customers/".$id."/warnings"));
    }

    public function getDocuments($id) {

        if(!$id) {
            return false;
        }

        return self::GetDataFromResponse($this->request("/user/customers/".$id."/documents"));
    }

    public function saveFile($files_id, $destination) {

        if(!$files_id || !$destination) {
            return false;
        }

        if(!$this->jwt) {
            if(!$this->authenticate()) {
                return false;
            }
        }

        if(!$data = @file_get_contents(self::HOST."/".self::VERSION."/user/files/".$files_id."?jwt=".$this->jwt)) {
            return false;
        }

        if(!@file_put_contents($destination, $data)) {
            return false;
        }

        return true;

    }

    public static function GetDataFromResponse($response) {

        if(!is_array($response)) {
            return false;
        }

        if(!array_key_exists("data", $response)) {
            return false;
        }

        return $response["data"];        
    }

}
