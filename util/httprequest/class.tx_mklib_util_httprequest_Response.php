<?php

/**
 * HttpRequest.
 *
 * @author Michael Wagner <michael.wagner@dmk-ebusiness.de>
 */
class tx_mklib_util_httprequest_Response
{
    /**
     * List of all known HTTP response codes - used by responseCodeAsText() to
     * translate numeric codes to messages.
     *
     * @var array
     */
    protected static $messages = array(
        // Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',

        // Success 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',

        // Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',  // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        // 306 is deprecated but reserved
        307 => 'Temporary Redirect',

        // Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',

        // Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded',
    );

    /**
     * The HTTP version (1.0, 1.1).
     *
     * @var string
     */
    protected $version;

    /**
     * The HTTP response code.
     *
     * @var int
     */
    protected $code;

    /**
     * The HTTP response code as string
     * (e.g. 'Not Found' for 404 or 'Internal Server Error' for 500).
     *
     * @var string
     */
    protected $message;

    /**
     * The HTTP response headers array.
     *
     * @var array
     */
    protected $headers = array();

    /**
     * The HTTP response body.
     *
     * @var string
     */
    protected $body;

    /**
     * HTTP response constructor.
     *
     * In most cases, you would use tx_mklib_util_httprequest_Response::fromString to parse an HTTP
     * response string and create a new tx_mklib_util_httprequest_Response object.
     *
     * NOTE: The constructor no longer accepts nulls or empty values for the code and
     * headers and will throw an exception if the passed values do not form a valid HTTP
     * responses.
     *
     * If no message is passed, the message will be guessed according to the response code.
     *
     * @param int    $code    Response code (200, 404, ...)
     * @param array  $headers Headers array
     * @param string $body    Response body
     * @param string $message Response code as text
     * @param string $version HTTP version
     */
    public function __construct($code, array $headers, $body = null, $message = null, $version = '1.1')
    {
        // Make sure the response code is valid and set it
        if (null === self::responseCodeAsText($code)) {
            throw new Exception($code.' is not a valid HTTP response code');
        }

        $this->code = $code;

        foreach ($headers as $name => $value) {
            if (is_int($name)) {
                $header = explode(':', $value, 2);
                if (2 != count($header)) {
                    throw new Exception('"'.$value.'" is not a valid HTTP header');
                }

                $name = trim($header[0]);
                $value = trim($header[1]);
            }

            $this->headers[ucwords(strtolower($name))] = $value;
        }

        // Set the body
        $this->body = $body;

        // Set the HTTP version
        if (!preg_match('|^\d\.\d$|', $version)) {
            throw new Exception('Invalid HTTP response version: '.$version);
        }

        $this->version = $version;

        // If we got the response message, set it. Else, set it according to
        // the response code
        if (is_string($message)) {
            $this->message = $message;
        } else {
            $this->message = self::responseCodeAsText($code);
        }
    }

    /**
     * Check whether the response is an error.
     *
     * @return bool
     */
    public function isError()
    {
        $restype = floor($this->code / 100);
        if (4 == $restype || 5 == $restype) {
            return true;
        }

        return false;
    }

    /**
     * Check whether the response in successful.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        $restype = floor($this->code / 100);
        if (2 == $restype || 1 == $restype) { // Shouldn't 3xx count as success as well ???
            return true;
        }

        return false;
    }

    /**
     * Check whether the response is a redirection.
     *
     * @return bool
     */
    public function isRedirect()
    {
        $restype = floor($this->code / 100);
        if (3 == $restype) {
            return true;
        }

        return false;
    }

    /**
     * Get the response body as string.
     *
     * This method returns the body of the HTTP response (the content), as it
     * should be in it's readable version - that is, after decoding it (if it
     * was decoded), deflating it (if it was gzip compressed), etc.
     *
     * If you want to get the raw body (as transfered on wire) use
     * $this->getRawBody() instead.
     *
     * @return string
     */
    public function getBody()
    {
        // Decode the body if it was transfer-encoded
        switch (strtolower($this->getHeader('transfer-encoding'))) {
            // Handle chunked body
            case 'chunked':
                $body = self::decodeChunkedBody($this->body);
                break;

                // No transfer encoding, or unknown encoding extension:
                // return body as is
            default:
                $body = $this->body;
                break;
        }

        // Decode any content-encoding (gzip or deflate) if needed
        switch (strtolower($this->getHeader('content-encoding'))) {
            // Handle gzip encoding
            case 'gzip':
                $body = self::decodeGzip($body);
                break;

                // Handle deflate encoding
            case 'deflate':
                $body = self::decodeDeflate($body);
                break;

            default:
                break;
        }

        return $body;
    }

    /**
     * Get the raw response body (as transfered "on wire") as string.
     *
     * If the body is encoded (with Transfer-Encoding, not content-encoding -
     * IE "chunked" body), gzip compressed, etc. it will not be decoded.
     *
     * @return string
     */
    public function getRawBody()
    {
        return $this->body;
    }

    /**
     * Get the HTTP version of the response.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the HTTP response status code.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->code;
    }

    /**
     * Return a message describing the HTTP response code
     * (Eg. "OK", "Not Found", "Moved Permanently").
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the response headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get a specific header as string, or null if it is not set.
     *
     * @param string$header
     *
     * @return string|array|null
     */
    public function getHeader($header)
    {
        $header = ucwords(strtolower($header));
        if (!is_string($header) || !isset($this->headers[$header])) {
            return null;
        }

        return $this->headers[$header];
    }

    /**
     * Get all headers as string.
     *
     * @param bool   $status_line Whether to return the first status line (IE "HTTP 200 OK")
     * @param string $br          Line breaks (eg. "\n", "\r\n", "<br />")
     *
     * @return string
     */
    public function getHeadersAsString($status_line = true, $br = "\n")
    {
        $str = '';

        if ($status_line) {
            $str = "HTTP/{$this->version} {$this->code} {$this->message}{$br}";
        }

        // Iterate over the headers and stringify them
        foreach ($this->headers as $name => $value) {
            if (is_string($value)) {
                $str .= "{$name}: {$value}{$br}";
            } elseif (is_array($value)) {
                foreach ($value as $subval) {
                    $str .= "{$name}: {$subval}{$br}";
                }
            }
        }

        return $str;
    }

    /**
     * Get the entire response as string.
     *
     * @param string $br Line breaks (eg. "\n", "\r\n", "<br />")
     *
     * @return string
     */
    public function asString($br = "\n")
    {
        return $this->getHeadersAsString(true, $br).$br.$this->getRawBody();
    }

    /**
     * Implements magic __toString().
     *
     * @return string
     */
    public function __toString()
    {
        return $this->asString();
    }

    /**
     * A convenience function that returns a text representation of
     * HTTP response codes. Returns 'Unknown' for unknown codes.
     * Returns array of all codes, if $code is not specified.
     *
     * Conforms to HTTP/1.1 as defined in RFC 2616 (except for 'Unknown')
     * See http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10 for reference
     *
     * @param int  $code   HTTP response code
     * @param bool $http11 Use HTTP version 1.1
     *
     * @return string
     */
    public static function responseCodeAsText($code = null, $http11 = true)
    {
        $messages = self::$messages;
        if (!$http11) {
            $messages[302] = 'Moved Temporarily';
        }

        if (null === $code) {
            return $messages;
        } elseif (isset($messages[$code])) {
            return $messages[$code];
        } else {
            return 'Unknown';
        }
    }

    /**
     * Extract the response code from a response string.
     *
     * @param string $response_str
     *
     * @return int
     */
    public static function extractCode($response_str)
    {
        preg_match('|^HTTP/[\d\.x]+ (\d+)|', $response_str, $m);

        if (isset($m[1])) {
            return (int) $m[1];
        } else {
            return false;
        }
    }

    /**
     * Extract the HTTP message from a response.
     *
     * @param string $response_str
     *
     * @return string
     */
    public static function extractMessage($response_str)
    {
        preg_match("|^HTTP/[\d\.x]+ \d+ ([^\r\n]+)|", $response_str, $m);

        if (isset($m[1])) {
            return $m[1];
        } else {
            return false;
        }
    }

    /**
     * Extract the HTTP version from a response.
     *
     * @param string $response_str
     *
     * @return string
     */
    public static function extractVersion($response_str)
    {
        preg_match('|^HTTP/([\d\.x]+) \d+|', $response_str, $m);

        if (isset($m[1])) {
            return $m[1];
        } else {
            return false;
        }
    }

    /**
     * Extract the headers from a response string.
     *
     * @param string $response_str
     *
     * @return array
     */
    public static function extractHeaders($response_str)
    {
        $headers = array();

        // First, split body and headers
        $parts = preg_split('|(?:\r?\n){2}|m', $response_str, 2);
        if (!$parts[0]) {
            return $headers;
        }

        // Split headers part to lines
        $lines = explode("\n", $parts[0]);
        unset($parts);
        $last_header = null;

        foreach ($lines as $line) {
            $line = trim($line, "\r\n");
            if ('' == $line) {
                break;
            }

            // Locate headers like 'Location: ...' and 'Location:...' (note the missing space)
            if (preg_match('|^([\w-]+):\s*(.+)|', $line, $m)) {
                unset($last_header);
                $h_name = strtolower($m[1]);
                $h_value = $m[2];

                if (isset($headers[$h_name])) {
                    if (!is_array($headers[$h_name])) {
                        $headers[$h_name] = array($headers[$h_name]);
                    }

                    $headers[$h_name][] = $h_value;
                } else {
                    $headers[$h_name] = $h_value;
                }
                $last_header = $h_name;
            } elseif (preg_match('|^\s+(.+)$|', $line, $m) && null !== $last_header) {
                if (is_array($headers[$last_header])) {
                    end($headers[$last_header]);
                    $last_header_key = key($headers[$last_header]);
                    $headers[$last_header][$last_header_key] .= $m[1];
                } else {
                    $headers[$last_header] .= $m[1];
                }
            }
        }

        return $headers;
    }

    /**
     * Extract the body from a response string.
     *
     * @param string $response_str
     *
     * @return string
     */
    public static function extractBody($response_str)
    {
        $parts = preg_split('|(?:\r?\n){2}|m', $response_str, 2);
        if (isset($parts[1])) {
            return $parts[1];
        }

        return '';
    }

    /**
     * Decode a "chunked" transfer-encoded body and return the decoded text.
     *
     * @param string $body
     *
     * @return string
     */
    public static function decodeChunkedBody($body)
    {
        $decBody = '';

        // If mbstring overloads substr and strlen functions, we have to
        // override it's internal encoding
        if (function_exists('mb_internal_encoding') &&
                ((int) ini_get('mbstring.func_overload')) & 2) {
            $mbIntEnc = mb_internal_encoding();
            mb_internal_encoding('ASCII');
        }

        while (trim($body)) {
            if (!preg_match("/^([\da-fA-F]+)[^\r\n]*\r\n/sm", $body, $m)) {
                throw new Exception("Error parsing body - doesn't seem to be a chunked message");
            }

            $length = hexdec(trim($m[1]));
            $cut = strlen($m[0]);
            $decBody .= substr($body, $cut, $length);
            $body = substr($body, $cut + $length + 2);
        }

        if (isset($mbIntEnc)) {
            mb_internal_encoding($mbIntEnc);
        }

        return $decBody;
    }

    /**
     * Decode a gzip encoded message (when Content-encoding = gzip).
     *
     * Currently requires PHP with zlib support
     *
     * @param string $body
     *
     * @return string
     */
    public static function decodeGzip($body)
    {
        if (!function_exists('gzinflate')) {
            throw new Exception(
                'zlib extension is required in order to decode "gzip" encoding'
            );
        }

        return gzinflate(substr($body, 10));
    }

    /**
     * Decode a zlib deflated message (when Content-encoding = deflate).
     *
     * Currently requires PHP with zlib support
     *
     * @param string $body
     *
     * @return string
     */
    public static function decodeDeflate($body)
    {
        if (!function_exists('gzuncompress')) {
            throw new Exception(
                'zlib extension is required in order to decode "deflate" encoding'
            );
        }

        /**
         * Some servers (IIS ?) send a broken deflate response, without the
         * RFC-required zlib header.
         *
         * We try to detect the zlib header, and if it does not exsit we
         * teat the body is plain DEFLATE content.
         *
         * This method was adapted from PEAR HTTP_Request2 by (c) Alexey Borzov
         *
         * @see http://framework.zend.com/issues/browse/ZF-6040
         */
        $zlibHeader = unpack('n', substr($body, 0, 2));
        if ($zlibHeader[1] % 31 == 0) {
            return gzuncompress($body);
        } else {
            return gzinflate($body);
        }
    }

    /**
     * Create a new tx_mklib_util_httprequest_Response object from a string.
     *
     * @param string $response_str
     *
     * @return tx_mklib_util_httprequest_Response
     */
    public static function fromString($response_str)
    {
        $code = self::extractCode($response_str);
        $headers = self::extractHeaders($response_str);
        $body = self::extractBody($response_str);
        $version = self::extractVersion($response_str);
        $message = self::extractMessage($response_str);

        return new tx_mklib_util_httprequest_Response($code, $headers, $body, $message, $version);
    }
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mklib/util/class.tx_mklib_util_httprequest_Response.php']) {
    include_once $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mklib/util/class.tx_mklib_util_httprequest_Response.php'];
}
