<?php

declare(strict_types=1);

abstract class AbstractNavigation
{
    use DisplayTraits;

    protected CollectionInterface $paths;
    protected ?object $settings;
    protected ?DisplaySearchBox $searchBox;
    protected ?array $cartItem;
    protected ?View $view;
    protected ?CollectionInterface $menu = null;

    public function __construct(NavigationPath $paths, ?object $settings = null, ?DisplaySearchBox $searchBox = null, ?array $cartItem = [], ?View $view = null)
    {
        $this->paths = $paths->Paths();
        $this->settings = $settings;
        $this->searchBox = $searchBox;
        $this->cartItem = $cartItem;
        $this->view = $view;
        $this->menu = GrantAccess::getInstance()->getMenu('menu_acl');
    }

    protected function settings() : string
    {
        $settings = $this->getTemplate('settingsPath');
        if (isset($this->settings) && !empty($this->settings)) {
            $settings = str_replace('{{address}}', $this->settings->site_address, $settings);
            $settings = str_replace('{{phone}}', $this->settings->site_phone, $settings);
            return $settings;
        }
        return '';
    }

    protected function connexion() : string
    {
        if (!AuthManager::isUserLoggedIn()) {
            $connexion = $this->btnConnexion();
        } else {
            $connexion = $this->userDropDownMenu();
        }
        return str_replace('{{connectedUser}}', $connexion, $this->getTemplate('conectPath'));
    }

    protected function navBrand() : string
    {
        return str_replace('{{brandRoute}}', $this->view->route('/'), $this->getTemplate('navBrandPath'));
    }

    protected function menu() : string
    {
        $menu = array_filter($this->menu->all(), function ($item) {
            return $item != 'log_reg_menu';
        }, ARRAY_FILTER_USE_KEY);
        if (is_array($menu) && count($menu) > 0) {
            $menu_html = '';
            foreach ($menu as $name => $link) {
                $active = '';
                if ($name === array_key_first($menu)) {
                    $active = 'active';
                }
                $menu_html .= $this->menuItem($name, $link, $active);
            }
        }
        return $menu_html;
    }

    protected function getTemplate(string $path) : string
    {
        $this->isFileexists($this->paths->offsetGet($path));
        return file_get_contents($this->paths->offsetGet($path));
    }

    private function menuItem(string $name, string $link, string $active)
    {
        return '<li class="nav-item">
        <a class="nav-link ' . $active . '" aria-current="page" href="' . $link . '">' . $name . '</a></li>';
    }

    private function userDropDownMenu() : string
    {
        $menu = $this->getTemplate('menuConnexionPath');
        $menu = str_replace('{{user}}', AuthManager::user(), $menu);
        $drop = $this->menu->offsetGet('log_reg_menu');
        $menu_html = '';
        if (is_array($drop) && count($drop) > 0) {
            foreach ($drop as $key => $value) {
                $active = ($value == H::currentPage()) ? 'active' : '';
                if ($key == 'separator') {
                    $menu_html .= ' <li role="separator" class="dropdown-divider"></li>';
                } elseif ($key == 'Confirmez votre compte') {
                    $menu_html .= $this->dropdown($active, $key, $value);
                } else {
                    $menu_html .= $this->dropdownActive($active, $key, $value);
                }
            }
        }
        return str_replace('{{dropdownMenu}}', $menu_html, $menu);
    }

    private function dropdownActive(string $active, string $key, string $value)
    {
        $href = $key != 'Logout' ? $value : 'javascript:void(0)';
        return '<li class="dropdown-item nav-item ' . $active . '">
   <a class="nav-link" href="' . $href . '">' . $key . '</a>
</li>';
    }

    private function dropdown(string $active, string $key, string $value) : string
    {
        $href = $key != 'Logout' ? $value : 'javascript:void(0)';
        return '<li class="dropdown-item nav-item' . $active . ' alert alert-warning">
   <a class="nav-link text-danger" href="' . $href . '"> ' . $key . ' </a>
</li>';
    }

    private function btnConnexion() : string
    {
        return '<button type="button" class="px-3 border-right border-left text-dark connexion text-decoration-none"
   data-bs-toggle="modal" data-bs-target="#login-box" id="login_btn">
   <span class="icon login"></span>&nbsp;&nbsp;Login</button>';
    }
}