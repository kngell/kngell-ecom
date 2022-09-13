<?php

declare(strict_types=1);
class View extends AbstractView
{
    private object $ressources;
    private string $_head;
    private string $_body;
    private string $_footer;
    private string $_html;
    private string $_outputBuffer;
    private Token $token;
    private ResponseHandler $response;
    private RequestHandler $request;
    private array $properties = [];

    public function __construct(array $viewAry, FilesSystemInterface $fileSyst)
    {
        $this->ressources = json_decode(file_get_contents(APP . 'assets.json'));
        if (!empty($viewAry)) {
            foreach ($viewAry as $key => $value) {
                if ($key != '' && property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
        $this->fileSyst = $fileSyst;
    }

    public function route(string $route)
    {
        $route = $route == DS ? 'home' : $route;

        return HOST . DS . $route;
    }

    public function addProperties(array $args = []) : void
    {
        if (!empty($args)) {
            foreach ($args as $prop => $value) {
                $this->properties[$prop] = $value;
            }
        }
    }

    public function getProperty(string $name) : mixed
    {
        return isset($this->properties[$name]) ? $this->properties[$name] : null;
    }

    /**
     * Render View.
     * --------------------------------------------------------------.
     * @param string $viewname
     * @param array $params
     * @return ?string
     */
    public function render(string $viewname = '', array $params = []) : ?string
    {
        if (!empty($viewname)) {
            $this->view_file = preg_replace("/\s+/", '', $viewname);
            if (is_readable(VIEW . strtolower($this->file_path) . $this->view_file . '.php')) {
                return $this->renderViewContent(VIEW . strtolower($this->file_path) . $this->view_file . '.php', $params);
            }
            if ($file = $this->viewFile($this->view_file)) {
                $file = array_pop($file);
                if (is_readable($file)) {
                    return $this->renderViewContent($file, $params);
                }
            }
        }
        throw new BaseException("Cette vue n'existe pas", 1);
    }

    /** @inheritDoc */
    public function start(string $type) : void
    {
        $this->_outputBuffer = $type;
        ob_start();
    }

    /** @inheritDoc */
    public function content(string $type) : bool|string
    {
        return match ($type) {
            'head' => $this->_head ?? '',
            'body' => $this->_body ?? '',
            'footer' => $this->_footer ?? '',
            'html' => $this->_html ?? '',
            default => false
        };
    }

    /** @inheritDoc */
    public function end() : void
    {
        isset($this->_outputBuffer) ? $this->{'_' . $this->_outputBuffer} = ob_get_clean() : '';
    }

    /** @inheritDoc */
    public function asset(string $asset = '', string $ext = '') : string
    {
        $root = isset($asset) ? explode('/', $asset) : [];
        if ($root) {
            $path = '';
            $check = array_shift($root);
            $i = 0;
            foreach ($root as $value) {
                $separator = ($i == count($root) - 1) ? '' : US;
                $path .= $value . $separator;
                $i++;
            }

            return $this->getAsset($check, $path, $asset, $ext);
        }

        return '';
    }

    private function getAsset(string $check, string $path, string $asset, string $ext) : string
    {
        return match (true) {
            $check == 'img' => HOST ? HOST . US . IMG . $path : IMG . $asset,
            $check == 'fonts' => HOST ? HOST . US . FONT . $path : FONT . $asset,
            isset($this->ressources->$asset->$ext) => HOST ? HOST . $this->ressources->$asset->$ext ?? '' : $this->ressources->$asset->$ext ?? '',
            default => ''
        };
    }

    private function renderViewContent($view, array $params = []) : ?string
    {
        extract($params, EXTR_SKIP);
        require_once $view;
        $this->start('html');
        $layout = $this->viewFile('layouts' . DS . $this->_layout);
        if ($layout) {
            require_once array_pop($layout); //VIEW . strtolower(explode(DS, $this->file_path)[0]) . DS . 'layouts' . DS . $this->_layout . '.php';
        }
        $this->end();
        if ($this->webView) {
            // $this->response->handler()->setContent($this->content('html'))->prepare($this->request->handler())->send();
            $this->response->setContent($this->content('html'))->prepare($this->request)->send();

            return null;
        } else {
            return html_entity_decode($this->content('html'));
        }
    }
}