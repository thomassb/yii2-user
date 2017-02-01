<?php

namespace common\helpers;

class jsonResponse {

    public $status;
    public $errors ;
    public $data;
    public $encodedData;

    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    public function encode() {

        $this->encodedData = json_encode(['status' => $this->status, 'errors' => $this->errors, 'data' => $this->data]);
    }

    public function sendResponse($status = 200, $body = '', $content_type = 'text/html') {

        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->getStatusCodeMessage($status);
        header($status_header);
        // and the content type
        header('Content-type: ' . $content_type);

        // pages with body are easy
        if ($body != '') {
            // send the body
            echo $body;
            exit;
        }
        // we need to create the body if none is passed
        else {
            // create some body messages
            $message = '';

            switch ($status) {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            // servers don't always have a signature turned on 
            // (this is an apache directive "ServerSignature On")
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

            // this should be templated in a real-world solution
            $body = '';

            echo $body;
            Yii::app()->end();
        }
    }

    private function getStatusCodeMessage($status) {
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    public function errorsToString($errors) {
        if (is_array($errors)) {
            $_s = '';
           // $this->validate();
            foreach ($errors as $_error) {
                foreach ($_error as $error) {
                    $_s = $error . '<br>';
                }
            }
            return $_s;
        }
        return $errors;
    }

}
