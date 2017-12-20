<?php

namespace Helper;

/**
 * helper class to remove the trailing slash, which sometimes get typed by accident
 * eg.: url.de/projects/id/ => url.de/projects/id
 */
class RedirectingController extends Controller 
{

  public function removeTrailingSlash($request)
  {
    $pathInfo = $request->getPathInfo();
    $requestUri = $request->getRequestUri();

    $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);

    return $this->redirect($url, 301);
  }

}