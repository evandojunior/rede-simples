<?php
namespace Project\Core\Security;

use Project\Core\Entity\BbhUsuario;
use Project\Core\Exception;
use Project\Core\Helper;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class SecurityProvider
{
    const KEY_TOKEN = 'X-ST';
    const KEY_TYPE_ACCESS = 'X-WTC';
    const KEY_APP = 'X-APP';
    const KEY_LANG = 'LANG';
    const TOKEN_APP = '2[;7*6euutfk>56h1=-t7W)0u3/0)N';

    public static function auth(\Silex\Application $app, $request)
    {
        if (!self::isAuthenticate($app) || self::isPageNotRequiredAuth($request)) {
            self::setLanguageRequested($app, $request);
            return;
        }

        if (!self::isTokenHeader($request)) {
            Helper\ResponseHelper::response(Exception\Error::FORBIDDEN, Helper\HttpHelper::HTTP_STATUS_FORBIDDEN);
        }

        if (!self::isTokenValid($app, $request)) {
            Helper\ResponseHelper::response(Exception\Error::BAD_CREDENTIALS, Helper\HttpHelper::HTTP_STATUS_UNAUTHORIZED);
        }
    }

    private static function isAuthenticate($app)
    {
        return isset($app['auth']) && $app['auth'];
    }

    private static function isTokenHeader($request)
    {
        $token = $request->headers->get(self::KEY_TOKEN);
        return isset($token) && !empty($token);
    }

    private static function isPageNotRequiredAuth($request)
    {
        $notRequired = [
            'GET|/api/servicos/bbhive/rede-simples/form'
        ];

        return in_array(sprintf("%s|%s", $request->getMethod(), $request->getRequestUri()), $notRequired);
    }

    private static function setLanguageRequested(\Silex\Application $app, $request)
    {
        $language = $request->headers->get(self::KEY_LANG);
        $app['languageRequested'] = $language;
    }

    private static function isTokenValid(\Silex\Application $app, $request)
    {
        $token = $request->headers->get(self::KEY_TOKEN);
        $type = $request->headers->get(self::KEY_TYPE_ACCESS);
        $typeAPP = $request->headers->get(self::KEY_APP);

        if ($token == self::TOKEN_APP) {
            if (self::isPageNotRequiredAuth($request)) {
                self::setLanguageRequested($app, $request);
                return true;
            }
        }

        $user = $app['db.orm.em']->getRepository(BbhUsuario::class)->findOneByBbhUsuIdentificacao($token);
        if (empty($user)) {
            return false;
        }

        $app['user'] = $user;
        self::setLanguageRequested($app, $request);
        return true;
    }
}