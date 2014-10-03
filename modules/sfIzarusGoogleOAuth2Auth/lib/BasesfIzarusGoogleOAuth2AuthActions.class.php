<?php

class BasesfIzarusGoogleOAuth2AuthActions extends sfActions
{
  public function executeSignin(sfWebRequest $request)
  {
    if ($request->getParameter('redirect')) {
      $this->getUser()->setFlash('redirect',$request->getParameter('redirect'));
    }

    $google = new sfIzarusGoogleOAuth2();  
    
    if (!isset($_GET['code'])) {
      return $this->redirect($google->getLoginUrl());
    } else {

      $google->getClient()->authenticate($_GET['code']);
      $at = json_decode($google->getClient()->getAccessToken(),true);
      $tokeninfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$at['access_token']),true);
      
      if(isset($tokeninfo['email'])){
        $user = sfGuardUserTable::getInstance()->findOneBy('email_address',$tokeninfo['email']);

        if (!$user) {
          $this->getUser()->setFlash('error_login','No tienes permisos para utilizar este sistema.');
          return $this->redirect('@homepage');
        }

        $this->getUser()->signIn($user);

        if ($this->getUser()->hasFlash('redirect')) {
          return $this->redirect($this->getUser()->getFlash('redirect'));
        } else {
          return $this->redirect(sfConfig::get('app_izarusopenid_after_signin_url','@homepage'));
        }
      }else{
        $this->getUser()->setFlash('error_login','Ocurrió un problema al intentar autenticar con Google.');
        return $this->redirect('@homepage');
      }
    }
  }
}