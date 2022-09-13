<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\Response;

class ResponseHandler
{
    use HttpTraits;

    private RequestHandler $request;
    private CollectionInterface $headers;
    private CollectionInterface $cookies;
    private string $content;
    private ?string $protocol;
    private HttpStatus $status;
    private bool $prepared = false;

    public function __construct(string $status = 'HTTP_OK', string $content = '', array $headers = [])
    {
        $this->status = HttpStatus::getStatus($status);
        $this->headers = new Collection($headers);
        $this->content = $content;
    }

    public function addHeader(string $name, string $value) : self
    {
        $this->headers->offsetGet($name, $value);

        return $this;
    }

    public function addHeaders(array $headers) : self
    {
        $this->headers->addAll($headers);

        return $this;
    }

    public function handler() : Response
    {
        if (!isset($response)) {
            $response = Container::getInstance()->make(Response::class);
            if ($response) {
                return $response;
            }
        }

        return false;
    }

    public function content(string $content) : void
    {
        $this->content = $content;
    }

    public function getContent() : string
    {
        return $this->content;
    }

    public function setStatusCode(int $code) : self
    {
        http_response_code($code);

        return $this;
    }

    public function redirect(string $url, ?string $refreshtime = null) : string
    {
        if (headers_sent()) {
            echo "<script>document.location.href='" . $url . "'</script>";
        } elseif (isset($refreshtime)) {
            header('refresh:' . $refreshtime . ';url=' . $url);
        } else {
            header('Location:' . $url);
        }

        return $url;
        die();
    }

    public function is_image(string $file)
    {
        if (@is_array(getimagesize($file))) {
            $image = true;
        } else {
            $image = false;
        }
    }

    /**
     * Transform Key -> transform source key from old to new key when present on $item
     * ==================================================================================.
     * @param array $source
     * @param array $item
     * @return array
     */
    public function transform_keys(array $source = [], array | null $newKeys = []) : array
    {
        $S = $source;
        if (isset($newKeys) && !empty($newKeys)) {
            foreach ($source as $key => $val) {
                if (isset($newKeys[$key])) {
                    $S = $this->_rename_arr_key($key, $newKeys[$key], $S);
                }
            }
        }

        return $S;
    }

    public function jsonResponse(array $resp) : void
    {
        $this->setJsonHeader()->setResponseCode(200);
        echo json_encode($resp);
        exit;
    }

    public function setJsonHeader() : self
    {
        header('Content-Type: application/json;charset=utf-8');

        return $this;
    }

    public function setResponseCode(int $code) : self
    {
        http_response_code($code);

        return $this;
    }

    /**
     * Get Html Decode texte
     * ========================================================.
     * @param string $str
     * @return string
     */
    public function htmlDecode(string $str) : string
    {
        return !empty($str) ? htmlspecialchars_decode(html_entity_decode($str), ENT_QUOTES) : '';
    }

    public function htmlDecodeArray(array $array = []) : array
    {
        $r = [];
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                if (is_string($value)) {
                    $value = $this->htmlDecode($value);
                }
                $r[$key] = $value;
            }
        }

        return empty($r) ? $array : $r;
    }

    public function send() : void
    {
        if (!$this->prepared) {
            throw new ResponseException('Response need to be prepared');
        }
        $this->addAllCookies();
        $this->sendAllHeaders();
        echo $this->content;
    }

    public function prepare(RequestHandler $request) : self
    {
        $this->request = $request;
        $this->protocol = $this->request->getProtocol();
        if (!$this->headers->has('Content-Type')) {
            $this->headers->offsetSet('Content-Type', 'text/html');
        }
        if (!$this->headers->has('Content-Length')) {
            $this->headers->offsetSet('Content-Length', strlen($this->content));
        }
        $this->prepared = true;

        return $this;
    }

    private function addAllCookies() : void
    {
    }

    private function sendAllHeaders() : void
    {
        if (headers_sent()) {
            return;
        }
        header(sprintf('%s %s %s', $this->protocol, $this->status->value, $this->status->getStatusText()), true, $this->status->value);
        foreach ($this->headers as $name => $value) {
            header(sprintf('%s: %s', $name, $value), false, $this->status->value);
        }
        header('X-Response-Time: ' . (microtime(true) - $this->request->getRequestStartTime()), );
    }

    /**
     * Rename keys
     * ==================================================================================.
     * @param string $oldkey
     * @param string $newkey
     * @param array $arr
     * @return array|bool
     */
    private function _rename_arr_key(string $oldkey, string $newkey, array $arr = []) : bool|array
    {
        if (array_key_exists($oldkey, $arr)) {
            $arr[$newkey] = $arr[$oldkey];
            unset($arr[$oldkey]);

            return $arr;
        } else {
            return false;
        }
    }
}
