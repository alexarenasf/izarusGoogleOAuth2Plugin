<?php

class izarusGoogleOAuth2PluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
    $this->dispatcher->connect('routing.load_configuration', array('izarusGoogleOAuth2PluginRouting', 'listenToRoutingLoadConfigurationEvent'));
  }
}