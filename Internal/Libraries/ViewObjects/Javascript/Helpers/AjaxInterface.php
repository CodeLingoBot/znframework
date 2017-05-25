<?php namespace ZN\ViewObjects\Javascript\Helpers;

interface AjaxInterface
{
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Copyright  : (c) 2012-2016, znframework.com
    //
    //--------------------------------------------------------------------------------------------------------

    //--------------------------------------------------------------------------------------------------------
    // URL
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $url
    //
    //--------------------------------------------------------------------------------------------------------
    public function url(String $url = '') : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Data -> 4.2.8[edit]
    //--------------------------------------------------------------------------------------------------------
    //
    // @param mixed $data
    //
    // @send-form: #serialize, [json], 'classic'
    //
    //--------------------------------------------------------------------------------------------------------
    public function data($data) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Headers
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $url
    //
    //--------------------------------------------------------------------------------------------------------
    public function headers(String $headers) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // If Modified
    //--------------------------------------------------------------------------------------------------------
    //
    // @param bool $ifModified
    //
    //--------------------------------------------------------------------------------------------------------
    public function ifModified(String $ifModified) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Is Local
    //--------------------------------------------------------------------------------------------------------
    //
    // @param bool $isLocal
    //
    //--------------------------------------------------------------------------------------------------------
    public function isLocal(String $isLocal) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Mime Type
    //--------------------------------------------------------------------------------------------------------
    //
    // @param bool $isLocal
    //
    //--------------------------------------------------------------------------------------------------------
    public function mimeType(String $mimeType) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Jsonp
    //--------------------------------------------------------------------------------------------------------
    //
    // @param scalar $jsonp
    //
    //--------------------------------------------------------------------------------------------------------
    public function jsonp(String $jsonp) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Jsonp Callback
    //--------------------------------------------------------------------------------------------------------
    //
    // @param scalar $jsonpCallback
    //
    //--------------------------------------------------------------------------------------------------------
    public function jsonpCallback(String $jsonpCallback) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Data Type
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $type
    //
    //--------------------------------------------------------------------------------------------------------
    public function dataType(String $type) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Password
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $password
    //
    //--------------------------------------------------------------------------------------------------------
    public function password(String $password) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Username
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $
    //
    //--------------------------------------------------------------------------------------------------------
    public function username(String $username) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Method
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $method
    //
    //--------------------------------------------------------------------------------------------------------
    public function method(String $method = 'post') : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Type
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $method
    //
    //--------------------------------------------------------------------------------------------------------
    public function type(String $method = 'post') : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Script Charset
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $sr
    //
    //--------------------------------------------------------------------------------------------------------
    public function scriptCharset(String $scriptCharset = 'utf-8') : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Traditional
    //--------------------------------------------------------------------------------------------------------
    //
    // @param scalar $tratidional
    //
    //--------------------------------------------------------------------------------------------------------
    public function traditional(String $traditional) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Process Data
    //--------------------------------------------------------------------------------------------------------
    //
    // @param scalar $processData
    //
    //--------------------------------------------------------------------------------------------------------
    public function processData(String $processData) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Cache
    //--------------------------------------------------------------------------------------------------------
    //
    // @param scalar $cache
    //
    //--------------------------------------------------------------------------------------------------------
    public function cache(String $cache) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // XHR Fields
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $xhrFields
    //
    //--------------------------------------------------------------------------------------------------------
    public function xhrFields(String $xhrFields) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Context
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $context
    //
    //--------------------------------------------------------------------------------------------------------
    public function context(String $context) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Accepts
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $accepts
    //
    //--------------------------------------------------------------------------------------------------------
    public function accepts(String $accepts) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Contents
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $contents
    //
    //--------------------------------------------------------------------------------------------------------
    public function contents(String $contents) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Async
    //--------------------------------------------------------------------------------------------------------
    //
    // @param scalar $async
    //
    //--------------------------------------------------------------------------------------------------------
    public function async(String $async) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Cross Domain
    //--------------------------------------------------------------------------------------------------------
    //
    // @param scalar $crossDomain
    //
    //--------------------------------------------------------------------------------------------------------
    public function crossDomain(String $crossDomain) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Timeout
    //--------------------------------------------------------------------------------------------------------
    //
    // @param int $timeout
    //
    //--------------------------------------------------------------------------------------------------------
    public function timeout(Int $timeout) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Globals
    //--------------------------------------------------------------------------------------------------------
    //
    // @param scalar $globals
    //
    //--------------------------------------------------------------------------------------------------------
    public function globals(String $globals) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Content Type
    //--------------------------------------------------------------------------------------------------------
    //
    // @param scalar $contentType
    //
    //--------------------------------------------------------------------------------------------------------
    public function contentType(String $contentType = 'application/x-www-form-urlencoded; charset=UTF-8') : Ajax;



    //--------------------------------------------------------------------------------------------------------
    // Status Code
    //--------------------------------------------------------------------------------------------------------
    //
    // @param array $codes
    //
    //--------------------------------------------------------------------------------------------------------
    public function statusCode(Array $codes) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Converters
    //--------------------------------------------------------------------------------------------------------
    //
    // @param array $codes
    //
    //--------------------------------------------------------------------------------------------------------
    public function converters(Array $codes) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Success
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $params
    // @param string $success
    //
    //--------------------------------------------------------------------------------------------------------
    public function success(String $params, $success) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Error
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $params
    // @param string $error
    //
    //--------------------------------------------------------------------------------------------------------
    public function error(String $params, $error) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Show Error
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $params
    // @param string $error
    //
    //--------------------------------------------------------------------------------------------------------
    public function showError() : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Complete
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $params
    // @param string $complete
    //
    //--------------------------------------------------------------------------------------------------------
    public function complete(String $params, $complete) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Before Send
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $params
    // @param string $beforeSend
    //
    //--------------------------------------------------------------------------------------------------------
    public function beforeSend(String $params, $beforeSend) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Data Filter
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $params
    // @param string $dataFilter
    //
    //--------------------------------------------------------------------------------------------------------
    public function dataFilter(String $params, $dataFilter) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Done
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $params
    // @param string $done
    //
    //--------------------------------------------------------------------------------------------------------
    public function done(String $params = 'e', $done = NULL) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Fail
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $params
    // @param string $fail
    //
    //--------------------------------------------------------------------------------------------------------
    public function fail(String $params = 'e', $fail = NULL) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Always
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $params
    // @param string $always
    //
    //--------------------------------------------------------------------------------------------------------
    public function always(String $params = 'e', $always = NULL) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Then
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $params
    // @param string $then
    //
    //--------------------------------------------------------------------------------------------------------
    public function then(String $params = 'e', $then = NULL) : Ajax;

    //--------------------------------------------------------------------------------------------------------
    // Send
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $url
    // @param string $data
    //
    //--------------------------------------------------------------------------------------------------------
    public function send(String $url = '', $data = NULL) : String;

    //--------------------------------------------------------------------------------------------------------
    // Create
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $params
    // @param string $dataFilter
    //
    //--------------------------------------------------------------------------------------------------------
    public function create(String $url = '', String $data = NULL) : String;
}