<?php

declare(strict_types=1);

/**
 * @todo delete cookie from browser if database cookie token is not vaild or missing
 */
class Authorized
{
    use SessionTrait;

    /** @var string */
    protected const TOKEN_COOKIE_NAME = 'remember_me';
    protected const FIELD_SESSIONS = [
        'id',
        'email',
        'firstname',
        'lastname',
        'password_hash',
        'gravatar',
        'status',

    ];

    /**
     * Login the user.
     *
     * @param object $userModel Get the data from the user model from security controller
     * @param bool $rememberMe Remember the login if true
     * @return void
     * @throws GlobalManagerException
     * @throws Exception
     */
    public static function login(Object $userModel, $rememberMe)
    {
        /* Set userID Session here */
        session_regenerate_id(true);
        SessionTrait::registerUserSession($userModel->id ?? false);
        if ($rememberMe) {
            $rememberLogin = new RememberedLogin();
            list($token, $timestampExpiry) = $rememberLogin->rememberedLogin($userModel->id);
            if ($token != null) {
                $cookie = (new CookieFacade(['name' => self::TOKEN_COOKIE_NAME, 'expires' => $timestampExpiry]))->initialize();
                $cookie->set($token);
            }
        }
    }

    /**
     * Register the current logged in user to the Session so there info can
     * be accessible globally.
     *
     * @return object|null
     * @throws BaseUnexpectedValueException
     */
    public static function grantedUser()
    {
        $userSessionID = self::getCurrentSessionID();
        if (isset($userSessionID)) {
            return self::userModel()->getRepo()->findObjectBy(['id' => $userSessionID], self::FIELD_SESSIONS);
        } else {
            $user = self::loginFromRemembermeCookie();
            if ($user) {
                return $user;
            }
        }
    }

    /**
     * Logout the user and kill the user session and also delete the cookie
     * created for user login.
     *
     * @return void
     * @throws GlobalManagerException
     * @throws Throwable
     */
    public static function logout() : void
    {
        if (self::getCurrentSessionID() != null) {
            SessionTrait::SessionFromGlobal()->invalidate();
            self::forgetLogin();
        }
    }

    /**
     * Remember the originally-requested page in the session.
     *
     * @return void
     * @throws GlobalManagerException
     */
    public static function rememberRequestedPage() : void
    {
        SessionTrait::sessionFromGlobal()->set('return_to', $_SERVER['REQUEST_URI']);
    }

    /**
     * Get the originally-requested page to return to after requiring login,
     * or default to the homepage.
     *
     * @return string
     * @throws GlobalManagerException
     */
    public static function getReturnToPage() : string
    {
        $page = SessionTrait::sessionFromGlobal()->get('return_to');

        return $page ?? '/';
    }

    /**
     * Helper function for getting the current user ID from the active session.
     *
     * @return int
     * @throws GlobalManagerException
     */
    protected static function getCurrentSessionID(): int
    {
        return intval(SessionTrait::sessionFromGlobal()->get('user_id'));
    }

    /**
     * Login the user from a remembered login cookie.
     *
     * @return null|object
     * @throws GlobalManagerException
     * @throws Throwable
     */
    protected static function loginFromRemembermeCookie() : object|null
    {
        $cookie = $_COOKIE[self::TOKEN_COOKIE_NAME] ?? false;
        if ($cookie) {
            $rememberLogin = new RememberedLogin();
            $cookieToken = $rememberLogin->findByToken($cookie);
            if ($cookieToken && !$rememberLogin->hasExpired($cookieToken->expires_at)) {
                $user = $rememberLogin->getUser($cookieToken->id);
                if ($user) {
                    self::login($user, false);

                    return $user;
                }
            }
        }

        return null;
    }

    /**
     * Forget the remembered login, if present.
     *
     * @return bool
     * @throws Throwable
     */
    protected static function forgetLogin() : bool
    {
        $cookie = $_COOKIE[self::TOKEN_COOKIE_NAME] ?? false;
        if ($cookie) {
            $rememberLogin = new RememberedLogin();
            $rememberCookie = $rememberLogin->findByToken($cookie);
            if ($rememberCookie) {
                $rememberLogin->destroy($rememberCookie->token_hash);
            }
            /* expire cookie here */
            $cookie = (new CookieFacade(['name' => self::TOKEN_COOKIE_NAME]))->initialize();
            $cookie->delete();

            return true;
        }

        return false;
    }

    /**
     * Return the user model class if it exists. Which it should as this is part of the core
     * framework.
     *
     * @return UserModel
     */
    private static function userModel(): UsersManager
    {
        if (!class_exists($userModel = UserModel::class)) {
            throw new BaseNoClassFoundExeption(sprintf('%s class is missing. In order to utalize the Authorized script within MagmaCore. Then a user model is required.', UserModel::class));
        }

        return new $userModel();
    }
}
