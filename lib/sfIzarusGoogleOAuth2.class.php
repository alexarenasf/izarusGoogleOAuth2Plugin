<?php
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/vendor/google-api-php-client/src/');

class sfIzarusGoogleOAuth2
{

  protected $client = null;
  protected $access_token = null;

  public function __construct(){
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));

    $client_id = sfConfig::get('app_googleoauth2_client_id');
    $client_secret = sfConfig::get('app_googleoauth2_client_secret');
    $hd = sfConfig::get('app_googleoauth2_hosted_domain');

    $this->client = new Google_Client();
    if(!empty($hd))
      $this->client->setHostedDomain($hd);
    $this->client->setClientId($client_id);
    $this->client->setClientSecret($client_secret);
    $this->client->setRedirectUri(url_for('@izarus_googleoauth2_signin',true));
    $this->client->addScope("https://www.googleapis.com/auth/userinfo.email");  
  }

  public function getUser() {
    if($this->client->getAccessToken()){
      $oauth2 = new apiOauth2Service($this->client);
      return $oauth2->userinfo->get();
    }
    return false;
  }

  public function getLoginUrl(){
    return $this->client->createAuthUrl();
  }
  
  public function getClient(){
    return $this->client;
  }

}