<?php

namespace EasyMS\Http;

use EasyMS\Constants\Services;
use EasyMS\Exception\ErrorCode;
use EasyMS\Exception\RuntimeException;

class Response extends \Phalcon\Http\Response
{
    /**
     * @param \Throwable $t
     * @param bool $developerInfo
     */
    public function setErrorContent(\Throwable $t, $developerInfo = false)
    {

        /** @var  $errorHelper ErrorHelper */
        $errorHelper = $this->getDI()->has(Services::ERROR_HELPER) ? $this->getDI()->get(Services::ERROR_HELPER) : null;
        $errorCode = $t->getCode();
        $statusCode = 500;
        $message = $t->getMessage();
        if($message == "Matched route doesn't have an associated handler"){
            $errorCode = ErrorCode::GENERAL_NOT_FOUND;
            $message = "";
        }
        if ($errorHelper && $errorHelper->has($errorCode)) {
            $defaultMessage = $errorHelper->get($errorCode);
            $statusCode = $defaultMessage['statusCode'];
            if (!$message) {
                $message = $defaultMessage['message'];
            }
        }
        $error = [
            'code' => $errorCode,
            'message' => $message ?: 'Unspecified error',
        ];

        if ($t instanceof RuntimeException && $t->getUserInfo() != null) {
            $error['info'] = $t->getUserInfo();
        }
        if($developerInfo){
            /** @var Request $request */
            $request = $this->getDI()->get(Services::REQUEST);
            if($errorCode !==ErrorCode::DATA_NOT_FOUND ){
                $context = [
                    'file' => $t->getFile(),
                    'line' => $t->getLine(),
                    'request'=>$request->getMethod() . ' ' . $request->getURI(),
                    'ip'=>$request->getClientAddress()
                ];
            }
        }
        $this->setJsonContent(['error' => $error]);
        $this->setStatusCode($statusCode);
        $this->setHeader('Access-Control-Allow-Headers',"Content-Type,X-Requested-With,Authorization");
        $this->setHeader('Access-Control-Allow-Methods',"GET,POST,PUT,DELETE,HEAD,OPTIONS,PATCH");
        $this->setHeader('Access-Control-Allow-Origin','*');
    }

    public function setJsonContent($content, $jsonOptions = 0, $depth = 512)
    {
        parent::setJsonContent($content, $jsonOptions, $depth);
        $this->setContentType('application/json', 'UTF-8');
        $this->setEtag(md5($this->getContent()));
    }
}