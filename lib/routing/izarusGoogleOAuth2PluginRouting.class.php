<?php

class izarusGoogleOAuth2PluginRouting
{
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $event->getSubject()->prependRoute('izarus_googleoauth2_signin', new sfRoute('/google/login', array('module' => 'sfIzarusGoogleOAuth2Auth', 'action' => 'signin')));
  }
}

