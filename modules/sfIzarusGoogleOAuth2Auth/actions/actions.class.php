<?php

require_once(dirname(__FILE__).'/../lib/BasesfIzarusGoogleOAuth2AuthActions.class.php');

class sfIzarusGoogleOAuth2AuthActions extends BasesfIzarusGoogleOAuth2AuthActions
{
  public function executeCustomLogin(sfWebRequest $request)
  {
    $user = sfGuardUserTable::getInstance()->findOneBy('email_address',$request->getParameter('e'));

    if (!$user) {
      return $this->renderText('error');
    }

    $this->getUser()->signIn($user);
    return $this->renderText('OK');
  }

}

