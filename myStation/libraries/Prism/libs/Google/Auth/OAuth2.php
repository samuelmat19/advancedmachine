<?php
/*
 * Copyright 2015 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Auth;

use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * OAuth2 supports authentication by OAuth2 2-legged flows.
 *
 * It primary supports
 * - service account authorization
 * - authorization where a user already has an access token
 */
class OAuth2 implements FetchAuthTokenInterface
{
  const DEFAULT_EXPIRY_SECONDS = 3600; // 1 hour
  const DEFAULT_SKEW_SECONDS = 60; // 1 minute
  const JWT_URN = 'urn:ietf:params:oauth:grant-type:jwt-bearer';

  /**
   * TODO: determine known methods from the keys of JWT::methods
   */
  public static $knownSigningAlgorithms = array('HS256', 'HS512', 'HS384',
                                                'RS256');

  /**
   * The well known grant types.
   */
  public static $knownGrantTypes = array('authorization_code',
                                         'refresh_token',
                                         'password',
                                         'client_credentials');

  /**
   * - authorizationUri
   *   The authorization server's HTTP endpoint capable of
   *   authenticating the end-user and obtaining authorization.
   */
  private $authorizationUri;

  /**
   * - tokenCredentialUri
   *   The authorization server's HTTP endpoint capable of issuing
   *   tokens and refreshing expired tokens.
   */
  private $tokenCredentialUri;

  /**
   * The redirection URI used in the initial request.
   */
  private $redirectUri;

  /**
   * A unique identifier issued to the client to identify itself to the
   * authorization server.
   */
  private $clientId;

  /**
   * A shared symmetric secret issued by the authorization server, which is
   * used to authenticate the client.
   */
  private $clientSecret;

  /**
   * The resource owner's username.
   */
  private $username;

  /**
   * The resource owner's password.
   */
  private $password;

  /**
   * The scope of the access request, expressed either as an Array or as a
   * space-delimited string.
   */
  private $scope;

  /**
   * An arbitrary string designed to allow the client to maintain state.
   */
  private $state;

  /**
   * The authorization code issued to this client.
   *
   * Only used by the authorization code access grant type.
   */
  private $code;

  /**
   * The issuer ID when using assertion profile.
   */
  private $issuer;

  /**
   * The target audience for assertions.
   */
  private $audience;

  /**
   * The target sub when issuing assertions.
   */
  private $sub;

  /**
   * The number of seconds assertions are valid for.
   */
  private $expiry;

  /**
   * The signing key when using assertion profile.
   */
  private $signingKey;

  /**
   * The signing algorithm when using an assertion profile.
   */
  private $signingAlgorithm;

  /**
   * The refresh token associated with the access token to be refreshed.
   */
  private $refreshToken;

  /**
   * The current access token.
   */
  private $accessToken;

  /**
   * The current ID token.
   */
  private $idToken;

  /**
   * The lifetime in seconds of the current access token.
   */
  private $expiresIn;

  /**
   * The expiration time of the access token as a number of seconds since the
   * unix epoch.
   */
  private $expiresAt;

  /**
   * The issue time of the access token as a number of seconds since the unix
   * epoch.
   */
  private $issuedAt;

  /**
   * The current grant type.
   */
  private $grantType;

  /**
   * When using an extension grant type, this is the set of parameters used by
   * that extension.
   */
  private $extensionParams;

  /**
   * Create a new OAuthCredentials.
   *
   * The configuration array accepts various options
   *
   * - authorizationUri
   *   The authorization server's HTTP endpoint capable of
   *   authenticating the end-user and obtaining authorization.
   *
   * - tokenCredentialUri
   *   The authorization server's HTTP endpoint capable of issuing
   *   tokens and refreshing expired tokens.
   *
   * - clientId
   *   A unique identifier issued to the client to identify itself to the
   *   authorization server.
   *
   * - clientSecret
   *   A shared symmetric secret issued by the authorization server,
   *   which is used to authenticate the client.
   *
   * - scope
   *   The scope of the access request, expressed either as an Array
   *   or as a space-delimited String.
   *
   * - state
   *   An arbitrary string designed to allow the client to maintain state.
   *
   * - redirectUri
   *   The redirection URI used in the initial request.
   *
   * - username
   *   The resource owner's username.
   *
   * - password
   *   The resource owner's password.
   *
   * - issuer
   *   Issuer ID when using assertion profile
   *
   * - audience
   *   Target audience for assertions
   *
   * - expiry
   *   Number of seconds assertions are valid for
   *
   * - signingKey
   *   Signing key when using assertion profile
   *
   * - refreshToken
   *   The refresh token associated with the access token
   *   to be refreshed.
   *
   * - accessToken
   *   The current access token for this client.
   *
   * - idToken
   *   The current ID token for this client.
   *
   * - extensionParams
   *   When using an extension grant type, this is the set of parameters used
   *   by that extension.
   *
   * @param array $config Configuration array
   */
  public function __construct(array $config)
  {
    $opts = array_merge([
      'expiry' => self::DEFAULT_EXPIRY_SECONDS,
      'extensionParams' => [],
      'authorizationUri' => null,
      'redirectUri' => null,
      'tokenCredentialUri' => null,
      'state' => null,
      'username' => null,
      'password' => null,
      'clientId' => null,
      'clientSecret' => null,
      'issuer' => null,
      'sub' => null,
      'audience' => null,
      'signingKey' => null,
      'signingAlgorithm' => null,
      'scope' => null
    ], $config);

    $this->setAuthorizationUri($opts['authorizationUri']);
    $this->setRedirectUri($opts['redirectUri']);
    $this->setTokenCredentialUri($opts['tokenCredentialUri']);
    $this->setState($opts['state']);
    $this->setUsername($opts['username']);
    $this->setPassword($opts['password']);
    $this->setClientId($opts['clientId']);
    $this->setClientSecret($opts['clientSecret']);
    $this->setIssuer($opts['issuer']);
    $this->setSub($opts['sub']);
    $this->setExpiry($opts['expiry']);
    $this->setAudience($opts['audience']);
    $this->setSigningKey($opts['signingKey']);
    $this->setSigningAlgorithm($opts['signingAlgorithm']);
    $this->setScope($opts['scope']);
    $this->setExtensionParams($opts['extensionParams']);
    $this->updateToken($opts);
  }

 /**
  * Verifies the idToken if present.
  *
  * - if none is present, return null
  * - if present, but invalid, raises DomainException.
  * - otherwise returns the payload in the idtoken as a PHP object.
  *
  * if $publicKey is null, the key is decoded without being verified.
  *
  * @param $publicKey the publicKey to use to authenticate the token
  * @param Array $allowed_algs List of supported verification algorithms
  */
  public function verifyIdToken($publicKey = null, $allowed_algs = array())
  {
    $idToken = $this->getIdToken();
    if (is_null($idToken)) {
      return null;
    }

    $resp = $this->jwtDecode($idToken, $publicKey, $allowed_algs);
    if (!property_exists($resp, 'aud')) {
      throw new \DomainException('No audience found the id token');
    }
    if ($resp->aud != $this->getAudience()) {
      throw new \DomainException('Wrong audience present in the id token');
    }
    return $resp;
  }

 /**
  * Obtains the encoded jwt from the instance data.
  *
  * @param $config array optional configuration parameters
  */
  public function toJwt(array $config = [])
  {
    if (is_null($this->getSigningKey())) {
      throw new \DomainException('No signing key available');
    }
    if (is_null($this->getSigningAlgorithm())) {
      throw new \DomainException('No signing algorithm specified');
    }
    $now = time();

    $opts = array_merge([
      'skew' => self::DEFAULT_SKEW_SECONDS
    ], $config);

    $assertion = [
        'iss' => $this->getIssuer(),
        'aud' => $this->getAudience(),
        'exp' => ($now + $this->getExpiry()),
        'iat' => ($now - $opts['skew'])
    ];
    foreach ($assertion as $k => $v) {
      if (is_null($v)) {
        throw new \DomainException($k . ' should not be null');
      }
    }
    if (!(is_null($this->getScope()))) {
      $assertion['scope'] = $this->getScope();
    }
    if (!(is_null($this->getSub()))) {
      $assertion['sub'] = $this->getSub();
    }
    return $this->jwtEncode($assertion, $this->getSigningKey(),
                       $this->getSigningAlgorithm());
  }

 /**
  * Generates a request for token credentials.
  *
  * @return RequestInterface the authorization Url.
  */
  public function generateCredentialsRequest()
  {
    $uri = $this->getTokenCredentialUri();
    if (is_null($uri)) {
      throw new \DomainException('No token credential URI was set.');
    }

    $grantType = $this->getGrantType();
    $params = array('grant_type' => $grantType);
    switch($grantType) {
      case 'authorization_code':
        $params['code'] = $this->getCode();
        $params['redirect_uri'] = $this->getRedirectUri();
        $this->addClientCredentials($params);
        break;
      case 'password':
        $params['username'] = $this->getUsername();
        $params['password'] = $this->getPassword();
        $this->addClientCredentials($params);
        break;
      case 'refresh_token':
        $params['refresh_token'] = $this->getRefreshToken();
        $this->addClientCredentials($params);
        break;
      case self::JWT_URN:
        $params['assertion'] = $this->toJwt();
        break;
      default:
        if (!is_null($this->getRedirectUri())) {
          # Grant type was supposed to be 'authorization_code', as there
          # is a redirect URI.
          throw new \DomainException('Missing authorization code');
        }
        unset($params['grant_type']);
        if (!is_null($grantType)) {
          $params['grant_type'] = $grantType;
        }
        $params = array_merge($params, $this->getExtensionParams());
    }

    $headers = [
      'Cache-Control' => 'no-store',
      'Content-Type' => 'application/x-www-form-urlencoded'
    ];

    return new Request(
      'POST',
      $uri,
      $headers,
      Psr7\build_query($params)
    );
  }

 /**
  * Fetchs the auth tokens based on the current state.
  *
  * @param callable $httpHandler callback which delivers psr7 request
  * @return array the response
  */
  public function fetchAuthToken(callable $httpHandler = null)
  {
    if (is_null($httpHandler)) {
      $httpHandler = HttpHandlerFactory::build();
    }

    $response = $httpHandler($this->generateCredentialsRequest());
    $creds = $this->parseTokenResponse($response);
    $this->updateToken($creds);
    return $creds;
  }

 /**
  * Obtains a key that can used to cache the results of #fetchAuthToken.
  *
  * The key is derived from the scopes.
  *
  * @return string a key that may be used to cache the auth token.
  */
  public function getCacheKey() {
    if (is_string($this->scope)) {
      return $this->scope;
    } else if (is_array($this->scope)) {
      return implode(":", $this->scope);
    }

    // If scope has not set, return null to indicate no caching.
    return null;
  }

 /**
  * Parses the fetched tokens.
  *
  * @param $resp ReponseInterface the response.
  * @return array the tokens parsed from the response body.
  */
  public function parseTokenResponse(ResponseInterface $resp)
  {
    $body = (string) $resp->getBody();
    if ($resp->hasHeader('Content-Type') &&
        $resp->getHeaderLine('Content-Type') == 'application/x-www-form-urlencoded') {
      $res = array();
      parse_str($body, $res);
      return $res;
    } else {
      // Assume it's JSON; if it's not throw an exception
      if (null === $res = json_decode($body, true)) {
        throw new \Exception('Invalid JSON response');
      }

      return $res;
    }
  }

 /**
  * Updates an OAuth 2.0 client.
  *
  * @example
  *   client.updateToken([
  *     'refresh_token' => 'n4E9O119d',
  *     'access_token' => 'FJQbwq9',
  *     'expires_in' => 3600
  *   ])
  *
  * @param array options
  *  The configuration parameters related to the token.
  *
  *  - refresh_token
  *    The refresh token associated with the access token
  *    to be refreshed.
  *
  *  - access_token
  *    The current access token for this client.
  *
  *  - id_token
  *    The current ID token for this client.
  *
  *  - expires_in
  *    The time in seconds until access token expiration.
  *
  *  - expires_at
  *    The time as an integer number of seconds since the Epoch
  *
  *  - issued_at
  *    The timestamp that the token was issued at.
  */
  public function updateToken(array $config)
  {
    $opts = array_merge([
      'extensionParams' => [],
      'refresh_token' => null,
      'access_token' => null,
      'id_token' => null,
      'expires' => null,
      'expires_in' => null,
      'expires_at' => null,
      'issued_at' => null
    ], $config);

    $this->setExpiresAt($opts['expires']);
    $this->setExpiresAt($opts['expires_at']);
    $this->setExpiresIn($opts['expires_in']);
    // By default, the token is issued at `Time.now` when `expiresIn` is set,
    // but this can be used to supply a more precise time.
    if (!is_null($opts['issued_at'])) {
      $this->setIssuedAt($opts['issued_at']);
    }

    $this->setAccessToken($opts['access_token']);
    $this->setIdToken($opts['id_token']);
    $this->setRefreshToken($opts['refresh_token']);
  }

  /**
   * Builds the authorization Uri that the user should be redirected to.
   *
   * @param $config configuration options that customize the return url
   * @return UriInterface the authorization Url.
   * @throws InvalidArgumentException
   */
  public function buildFullAuthorizationUri(array $config = [])
  {
    if (is_null($this->getAuthorizationUri())) {
      throw new \InvalidArgumentException(
          'requires an authorizationUri to have been set');
    }

    $params = array_merge([
        'response_type' => 'code',
        'access_type' => 'offline',
        'client_id' => $this->clientId,
        'redirect_uri' => $this->redirectUri,
        'state' => $this->state,
        'scope' => $this->getScope(),
    ], $config);

    // Validate the auth_params
    if (is_null($params['client_id'])) {
      throw new \InvalidArgumentException(
          'missing the required client identifier');
    }
    if (is_null($params['redirect_uri'])) {
      throw new \InvalidArgumentException('missing the required redirect URI');
    }
    if (!empty($params['prompt']) && !empty($params['approval_prompt'])) {
      throw new \InvalidArgumentException(
          'prompt and approval_prompt are mutually exclusive');
    }

    // Construct the uri object; return it if it is valid.
    $result = clone $this->authorizationUri;
    $existingParams = Psr7\parse_query($result->getQuery());

    $result = $result->withQuery(
      Psr7\build_query(array_merge($existingParams, $params))
    );

    if ($result->getScheme() != 'https') {
      throw new \InvalidArgumentException(
          'Authorization endpoint must be protected by TLS');
    }
    return $result;
  }

  /**
   * Sets the authorization server's HTTP endpoint capable of authenticating
   * the end-user and obtaining authorization.
   */
  public function setAuthorizationUri($uri)
  {
    $this->authorizationUri = $this->coerceUri($uri);
  }

  /**
   * Gets the authorization server's HTTP endpoint capable of authenticating
   * the end-user and obtaining authorization.
   */
  public function getAuthorizationUri()
  {
    return $this->authorizationUri;
  }

  /**
   * Gets the authorization server's HTTP endpoint capable of issuing tokens
   * and refreshing expired tokens.
   */
  public function getTokenCredentialUri()
  {
    return $this->tokenCredentialUri;
  }

  /**
   * Sets the authorization server's HTTP endpoint capable of issuing tokens
   * and refreshing expired tokens.
   */
  public function setTokenCredentialUri($uri)
  {
    $this->tokenCredentialUri = $this->coerceUri($uri);
  }

  /**
   * Gets the redirection URI used in the initial request.
   */
  public function getRedirectUri()
  {
    return $this->redirectUri;
  }

  /**
   * Sets the redirection URI used in the initial request.
   */
  public function setRedirectUri($uri)
  {
    if (is_null($uri)) {
      $this->redirectUri = null;
      return;
    }
    // redirect URI must be absolute
    if (!$this->isAbsoluteUri($uri)) {
      // "postmessage" is a reserved URI string in Google-land
      // @see https://developers.google.com/identity/sign-in/web/server-side-flow
      if ('postmessage' !== (string) $uri) {
        throw new \InvalidArgumentException(
          'Redirect URI must be absolute');
      }
    }
    $this->redirectUri = (string) $uri;
  }

  /**
   * Gets the scope of the access requests as a space-delimited String.
   */
  public function getScope()
  {
    if (is_null($this->scope)) {
      return $this->scope;
    }
    return implode(' ', $this->scope);
  }

  /**
   * Sets the scope of the access request, expressed either as an Array or as
   * a space-delimited String.
   */
  public function setScope($scope)
  {
    if (is_null($scope)) {
      $this->scope = null;
    } else if (is_string($scope)) {
      $this->scope = explode(' ', $scope);
    } else if (is_array($scope)) {
      foreach ($scope as $s) {
        $pos = strpos($s, ' ');
        if ($pos !== false) {
          throw new \InvalidArgumentException(
              'array scope values should not contain spaces');
        }
      }
      $this->scope = $scope;
    } else {
      throw new \InvalidArgumentException(
          'scopes should be a string or array of strings');
    }
  }

  /**
   * Gets the current grant type.
   */
  public function getGrantType()
  {
    if (!is_null($this->grantType)) {
      return $this->grantType;
    }

    // Returns the inferred grant type, based on the current object instance
    // state.
    if (!is_null($this->code)) {
      return 'authorization_code';
    } else if (!is_null($this->refreshToken)) {
      return 'refresh_token';
    } else if (!is_null($this->username) && !is_null($this->password)) {
      return 'password';
    } else if (!is_null($this->issuer) && !is_null($this->signingKey)) {
      return self::JWT_URN;
    } else {
      return null;
    }
  }

  /**
   * Sets the current grant type.
   */
  public function setGrantType($gt)
  {
    if (in_array($gt, self::$knownGrantTypes)) {
      $this->grantType = $gt;
    } else {
      // validate URI
      if (!$this->isAbsoluteUri($gt)) {
        throw new \InvalidArgumentException(
          'invalid grant type');
      }
      $this->grantType = (string) $gt;
    }
  }

  /**
   * Gets an arbitrary string designed to allow the client to maintain state.
   */
  public function getState()
  {
    return $this->state;
  }

  /**
   * Sets an arbitrary string designed to allow the client to maintain state.
   */
  public function setState($state)
  {
    $this->state = $state;
  }

  /**
   * Gets the authorization code issued to this client.
   */
  public function getCode()
  {
    return $this->code;
  }

  /**
   * Sets the authorization code issued to this client.
   */
  public function setCode($code)
  {
    $this->code = $code;
  }

  /**
   * Gets the resource owner's username.
   */
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * Sets the resource owner's username.
   */
  public function setUsername($username)
  {
    $this->username = $username;
  }

  /**
   * Gets the resource owner's password.
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Sets the resource owner's password.
   */
  public function setPassword($password)
  {
    $this->password = $password;
  }

  /**
   * Sets a unique identifier issued to the client to identify itself to the
   * authorization server.
   */
  public function getClientId()
  {
    return $this->clientId;
  }

  /**
   * Sets a unique identifier issued to the client to identify itself to the
   * authorization server.
   */
  public function setClientId($clientId)
  {
    $this->clientId = $clientId;
  }

  /**
   * Gets a shared symmetric secret issued by the authorization server, which
   * is used to authenticate the client.
   */
  public function getClientSecret()
  {
    return $this->clientSecret;
  }

  /**
   * Sets a shared symmetric secret issued by the authorization server, which
   * is used to authenticate the client.
   */
  public function setClientSecret($clientSecret)
  {
    $this->clientSecret = $clientSecret;
  }

  /**
   * Gets the Issuer ID when using assertion profile.
   */
  public function getIssuer()
  {
    return $this->issuer;
  }

  /**
   * Sets the Issuer ID when using assertion profile.
   */
  public function setIssuer($issuer)
  {
    $this->issuer = $issuer;
  }

  /**
   * Gets the target sub when issuing assertions.
   */
  public function getSub()
  {
    return $this->sub;
  }

  /**
   * Sets the target sub when issuing assertions.
   */
  public function setSub($sub)
  {
    $this->sub = $sub;
  }

  /**
   * Gets the target audience when issuing assertions.
   */
  public function getAudience()
  {
    return $this->audience;
  }

  /**
   * Sets the target audience when issuing assertions.
   */
  public function setAudience($audience)
  {
    $this->audience = $audience;
  }

  /**
   * Gets the signing key when using an assertion profile.
   */
  public function getSigningKey()
  {
    return $this->signingKey;
  }

  /**
   * Sets the signing key when using an assertion profile.
   */
  public function setSigningKey($signingKey)
  {
    $this->signingKey = $signingKey;
  }

  /**
   * Gets the signing algorithm when using an assertion profile.
   */
  public function getSigningAlgorithm()
  {
    return $this->signingAlgorithm;
  }

  /**
   * Sets the signing algorithm when using an assertion profile.
   */
  public function setSigningAlgorithm($sa)
  {
    if (is_null($sa)) {
      $this->signingAlgorithm = null;
    } else if (!in_array($sa, self::$knownSigningAlgorithms)) {
      throw new \InvalidArgumentException('unknown signing algorithm');
    } else {
      $this->signingAlgorithm = $sa;
    }
  }

  /**
   * Gets the set of parameters used by extension when using an extension
   * grant type.
   */
  public function getExtensionParams()
  {
    return $this->extensionParams;
  }

  /**
   * Sets the set of parameters used by extension when using an extension
   * grant type.
   */
  public function setExtensionParams($extensionParams)
  {
    $this->extensionParams = $extensionParams;
  }

  /**
   * Gets the number of seconds assertions are valid for.
   */
  public function getExpiry()
  {
    return $this->expiry;
  }

  /**
   * Sets the number of seconds assertions are valid for.
   */
  public function setExpiry($expiry)
  {
    $this->expiry = $expiry;
  }

  /**
   * Gets the lifetime of the access token in seconds.
   */
  public function getExpiresIn()
  {
    return $this->expiresIn;
  }

  /**
   * Sets the lifetime of the access token in seconds.
   */
  public function setExpiresIn($expiresIn)
  {
    if (is_null($expiresIn)) {
      $this->expiresIn = null;
      $this->issuedAt = null;
    } else {
      $this->issuedAt = time();
      $this->expiresIn = (int) $expiresIn;
    }
  }

  /**
   * Gets the time the current access token expires at.
   */
  public function getExpiresAt()
  {
    if (!is_null($this->expiresAt)) {
      return $this->expiresAt;
    } else if (!is_null($this->issuedAt) && !is_null($this->expiresIn)) {
      return $this->issuedAt + $this->expiresIn;
    }
    return null;
  }

  /**
   * Returns true if the acccess token has expired.
   */
  public function isExpired()
  {
    $expiration = $this->getExpiresAt();
    $now = time();
    return (!is_null($expiration) && $now >= $expiration);
  }

  /**
   * Sets the time the current access token expires at.
   */
  public function setExpiresAt($expiresAt)
  {
    $this->expiresAt = $expiresAt;
  }

  /**
   * Gets the time the current access token was issued at.
   */
  public function getIssuedAt()
  {
    return $this->issuedAt;
  }

  /**
   * Sets the time the current access token was issued at.
   */
  public function setIssuedAt($issuedAt)
  {
    $this->issuedAt = $issuedAt;
  }

  /**
   * Gets the current access token.
   */
  public function getAccessToken()
  {
    return $this->accessToken;
  }

  /**
   * Sets the current access token.
   */
  public function setAccessToken($accessToken)
  {
    $this->accessToken = $accessToken;
  }

  /**
   * Gets the current ID token.
   */
  public function getIdToken()
  {
    return $this->idToken;
  }

  /**
   * Sets the current ID token.
   */
  public function setIdToken($idToken)
  {
    $this->idToken = $idToken;
  }

  /**
   * Gets the refresh token associated with the current access token.
   */
  public function getRefreshToken()
  {
    return $this->refreshToken;
  }

  /**
   * Sets the refresh token associated with the current access token.
   */
  public function setRefreshToken($refreshToken)
  {
    $this->refreshToken = $refreshToken;
  }

  /**
   * The expiration of the last received token
   */
  public function getLastReceivedToken()
  {
    if ($token = $this->getAccessToken()) {
      return [
        'access_token' => $token,
        'expires_at' => $this->getExpiresAt(),
      ];
    }

    return null;
  }

  /**
   * @todo handle uri as array
   * @param string $uri
   * @return null|UriInterface
   */
  private function coerceUri($uri)
  {
    if (is_null($uri)) {
      return null;
    }

    return Psr7\uri_for($uri);
  }

  private function jwtDecode($idToken, $publicKey, $allowedAlgs)
  {
    if (class_exists('Firebase\JWT\JWT')) {
      return \Firebase\JWT\JWT::decode($idToken, $publicKey, $allowedAlgs);
    }

    return \JWT::decode($idToken, $publicKey, $allowedAlgs);
  }

  private function jwtEncode($assertion, $signingKey, $signingAlgorithm)
  {
    if (class_exists('Firebase\JWT\JWT')) {
      return \Firebase\JWT\JWT::encode($assertion, $signingKey,
                       $signingAlgorithm);
    }

    return \JWT::encode($assertion, $signingKey, $signingAlgorithm);
  }

  /**
   * Determines if the URI is absolute based on its scheme and host or path
   * (RFC 3986)
   *
   * @param string $uri
   * @return bool
   */
  private function isAbsoluteUri($uri)
  {
    $u = $this->coerceUri($uri);

    return $u->getScheme() && ($u->getHost() || $u->getPath());
  }

  private function addClientCredentials(&$params)
  {
    $clientId = $this->getClientId();
    $clientSecret = $this->getClientSecret();

    if ($clientId && $clientSecret) {
      $params['client_id'] = $clientId;
      $params['client_secret'] = $clientSecret;
    }

    return $params;
  }
}
