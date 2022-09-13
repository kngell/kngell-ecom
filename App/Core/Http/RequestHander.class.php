<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\Request;

class RequestHandler extends GlobalVariables
{
    use HttpTraits;

    private HttpMethod $method;
    private ?string $protocol;
    private string $requestUri;
    private float $requestStartTime;
    private ?string $rawContent = null;
    private CollectionInterface $query;
    private CollectionInterface $post;
    private CollectionInterface $cookies;
    private CollectionInterface $server;
    private CollectionInterface $headers;
    private CollectionInterface $httpFiles;

    public function __construct(private Sanitizer $sanitizer)
    {
        $this->requestStartTime = $this->getServer('request_time_float');
        $this->method = HttpMethod::fromString($this->getServer('request_method'));
        $this->post = new Collection($this->getPost());
        $this->query = new Collection($this->getGet());
        $this->server = new Collection($this->getServer());
        $this->protocol = $this->getServer('server_protocol');
        $this->requestUri = $this->getServer('request_uri');

        $this->initHeaders();
        $this->initFiles();
        $this->emptyGlobals();
    }

    public function handler() : Request
    {
        if (!isset($request)) {
            $request = new Request();
            if ($request) {
                $create = $request->createFromGlobals();
                if ($create) {
                    return $create;
                }
            }
        }

        return false;
    }

    /**
     * Get Path from blobals
     * ==================================================================================.
     * @return string
     */
    public function getPath() : string
    {
        $path = $this->removeQueryString($this->getGet('url'));
        if (empty($path)) {
            return '';
        }
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function pageUrl()
    {
        $request_uri = explode('/', trim($this->getServer('REQUEST_URI'), '/'));
        $script_name = explode('/', trim($this->getServer('SCRIPT_NAME'), '/'));
        $parts = array_diff_assoc($request_uri, $script_name);
        if (empty($parts)) {
            return '/';
        }
        $path = implode('/', $parts);
        if (($position = strpos($path, '?')) !== false) {
            $path = substr($path, 0, $position);
        }

        return $path;
    }

    public function getPathReferer() : string
    {
        $path = $this->getServer('HTTP_REFERER') ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    /**
     * Get Http Method
     * ====================================================.
     * @return string
     */
    public function getMethod() : string
    {
        return strtolower($this->getServer('REQUEST_METHOD'));
    }

    public function exists($type)
    {
        $global = $this->getMethod();
        switch ($type) {
            case 'post':
                return ($global == 'post') ? true : false;
                break;
            case 'get':
                return ($global == 'get') ? true : false;
                break;
            case 'put':
                return ($global == 'put') ? true : false;
                break;
            case 'files':
                return ($global == 'file') ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

    public function postData(string $input = '', array $postData = []) : mixed
    {
        if (isset($postData[$input]) && is_array($postData[$input])) {
            $r = [];
            foreach ($postData[$input] as $val) {
                $r[] = $this->sanitizer::clean($val);
            }

            return $r;
        }
        if (!$input) {
            $data = [];
            foreach ($postData as $field => $value) {
                $data[$field] = $this->sanitizer::clean($value);
            }

            return $data;
        }

        return isset($postData[$input]) ? $this->sanitizer::clean($postData[$input]) : false;
    }

    public function getData(string $input = '', array $getData = []) : array
    {
        if (is_array($getData) && !empty($getData)) {
            $gData = isset($getData['url']) ? $getData['url'] : $getData;
            if (is_string($gData) && str_contains($gData, '/')) {
                $parts = explode('/', $gData);
                unset($parts[0]);
                $parts = array_values($parts);
                $r = [];
                foreach ($parts as $key => $part) {
                    if (str_contains($part, '=')) {
                        $args = explode('=', $part);
                        $r[$args[0]] = $this->sanitizer::clean($args[1]);
                    }
                }
            }

            return $r;
        }
    }

    /**
     * Get Data From user input
     * ==================================================.
     * @param string $input
     * @return mixed
     */
    public function get(string $input = '') : mixed
    {
        $method = $this->getMethod();
        $data = $this->{'get' . ucfirst($method)}();
        if ($data) {
            return match ($method) {
                'post' => $this->postData($input, $data),
                'get' => $this->getData($input, $data)
            };
        }
    }

    /**
     * Get Params
     * =====================================================.
     * @param array $source
     * @return array
     */
    public function getParams(array $source) : array
    {
        if (isset($source['by_user'])) {
            return json_decode($this->get('by_user'));
        } else {
            return [(int) $this->get('start'), (int) $this->get('max'), (int) $this->get('id')];
        }
    }

    public function getFiles() : array
    {
        return parent::getFiles();
    }

    /**
     * Check if Http is get request
     * =========================================================.
     * @return bool
     */
    public function isGet() : bool
    {
        return $this->getMethod() === 'get';
    }

    /**
     * Check if Http is post Request
     * =========================================================.
     * @return bool
     */
    public function isPost() : bool
    {
        return $this->getMethod() === 'post';
    }

    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        return !empty($this->getServer('HTTP_X_REQUESTED_WITH')) && strtolower($this->getServer('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest';
    }

    /**
     * Add slashes
     * ========================================================.
     * @param mixed $data
     * @return string
     */
    public function add_slashes(mixed $data) : string
    {
        return addslashes($data);
    }

    private function emptyGlobals() : void
    {
        $_GET = [];
        $_POST = [];
        $_REQUEST = [];
        $_COOKIE = [];
        $_FILES = [];
    }

    private function initFiles() : void
    {
        $this->httpFiles = new Collection();
        $files = $this->getFiles();
        if (empty($files)) {
            return;
        }
        foreach ($files as $key => $file) {
            $file = $this->sanitizer::cleanFiles($file);
            if (!ArrayUtil::isAssoc($file)) {
                $subFiles = [];
                foreach ($file as $subFile) {
                    $subFile[] = new FileRequest($subFile['tmp_name'], $subFile['name'], $subFile['type'], $subFile['error']);
                }
                $this->httpFiles->offsetGet($key, $subFile);
            } else {
                $this->httpFiles->offsetGet($key, new FileRequest($file['tmp_name'], $file['name'], $file['type'], $file['error']));
            }
        }
    }

    private function initHeaders() : void
    {
        $this->headers = new Collection();
        $server = $this->getServer();
        if (empty($server)) {
            return;
        }
        foreach ($server as $key => $value) {
            if (strtoupper(substr($key, 0, 5)) === 'HTTP_') {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                $this->headers->offsetSet($name, $value);
            }
        }
    }

    private function removeQueryString(string $url) : string
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }
}