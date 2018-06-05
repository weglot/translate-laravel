<?php

namespace Weglot\Translate\Routing;

use Illuminate\Routing\UrlGenerator as IlluminateUrlGenerator;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use InvalidArgumentException;

/**
 * Class UrlGenerator
 * @package Weglot\Translate\Routing
 */
class UrlGenerator extends IlluminateUrlGenerator
{
    /**
     * {@inheritdoc}
     * @throws UrlGenerationException
     */
    public function route($name, $parameters = [], $absolute = true)
    {
        $url = weglotCurrentUrlInstance();
        $defaultLang = $url->getDefault();
        $currentLang = $url->detectCurrentLanguage();
        $baseRouteName = $name;
        $forced = false;

        // find correct $baseRouteName
        if ($defaultLang !== $currentLang) {
            $baseRouteName = str_replace($currentLang.'.', '', $baseRouteName);
        }

        // check if we wanna force route with the `_wg_lang` parameter
        if (isset($parameters['_wg_lang'])) {
            if ($defaultLang !== $parameters['_wg_lang']) {
                $name = $parameters['_wg_lang'].'.'.$baseRouteName;
            } else {
                $name = $baseRouteName;
            }
            unset($parameters['_wg_lang']);
            $forced = true;
        }

        if (!$forced &&
            $currentLang !== $url->getDefault() &&
            $route = $this->routes->getByName($currentLang.'.'.$baseRouteName)) {
            return $this->toRoute($route, $parameters, $absolute);
        }

        if (! is_null($route = $this->routes->getByName($name))) {
            return $this->toRoute($route, $parameters, $absolute);
        }

        throw new InvalidArgumentException("Route [{$name}] not defined.");
    }
}
