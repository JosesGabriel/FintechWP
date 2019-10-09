<?php

require_once ABSPATH . 'vendor/autoload.php';

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

class JWTBuilder
{
    private $key;
    private $signer;
    private $time;
    private $validator;
    protected $token;
    protected $entities = [
        'arbitrage' => 'https://arbitrage.ph',
        'vyndue' => 'https://vyndue.com',
    ];

    public function __construct()
    {
        $this->key = '864v2wg542s6s62t6qrcwxsdx9d2z6qq';
        $this->signer = new Sha256();
        $this->time = time();
        $this->token = new Builder();
        $this->validator = new ValidationData();
    }

    //region Getters

    public function getEntity($entity)
    {
        return $this->entities[$entity];
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getToken()
    {
        return $this->token;
    }

    //endregion Getters

    //region Setters

    /**
     * Wrapper for withClaim method
     * 
     * @param String $key
     * @param String $value
     * @return JWTBuilder
     */
    public function setTokenClaim($key, $value)
    {
        $this->token->withClaim($key, $value);
        return $this;
    }

    /**
     * Sets specific params for login token to arbitrage that will ask arbitrage for the current logged in user
     * 
     * @param String $for url
     * @return JWTBuilder
     */
    public function setLoginToken($for)
    {
        $this->token
            ->permittedFor($this->entities[$for]);
        return $this;
    }

    /**
     * Set the token
     *
     * @param String $token JWT token
     * @return JWTBuilder
     */
    public function setToken($token)
    {
        $this->token = (new Parser())->parse((string) $token);
        return $this;
    }

    //endregion Setters

    /**
     * Generates a generic token
     */
    public function generateToken()
    {
        $time = $this->time;
        return $this->token
                    ->issuedBy($this->entities['arbitrage'])
                    ->canOnlyBeUsedAfter($time + 60)
                    ->expiresAt($time + 3600)
                    ->getToken($this->signer, new Key($this->key));
    }

    public function validateLoginToken($issuer)
    {
        $this->validator->setIssuer($this->entities[$issuer]);
        return $this->validateToken();
    }

    protected function validateToken()
    {
        $time = $this->time;
        $this->validator->setCurrentTime($time + 61);
        $this->validator->setAudience($this->entities['arbitrage']);
        return $this->token->validate($this->validator) && $this->token->verify($this->signer, $this->key);
    }
}

$jwt = new JWTBuilder();

//region Shortcodes
function sso_login($data, $jwt) {
    $sso_login = $data['sso_login'] ?? false;
    $sso_token = $data['sso_token'] ?? false;

    // echo 'test';

    if ($sso_login !== false && $sso_token !== false) {
        // check if user is logged in
        if (is_user_logged_in()) {
            $sso_valid = false;

            // get current user
            $user = wp_get_current_user();

            // check type of sso

            $sso_valid = $jwt->setToken($sso_token)->validateLoginToken($sso_login);

            // sso is valid
            if (!$sso_valid) {
                return;
            }

            $login_token = new JWTBuilder();

            $first_name = get_user_meta($user->ID, 'first_name', true);
            $last_name = get_user_meta($user->ID, 'last_name', true);

            $token = $login_token->setLoginToken($sso_login)
                        ->setTokenClaim('user_secret', $user->user_secret)
                        ->setTokenClaim('first_name', $first_name)
                        ->setTokenClaim('last_name', $last_name)
                        ->setTokenClaim('email', $user->user_email)
                        ->generateToken();
            
            $url = $jwt->getEntity($sso_login);
            
            // echo "Token is valid: $sso_valid \n";
            // echo "Redirects to $url/api/auth/login?sso_token=$token";
            wp_redirect( "$url/api/auth/login?sso_token=$token" );
        } else {
            $home = home_url();
            
            // TODO create url map for different modules like vyndue, game, charts, etc
            $url = "https%3A%2F%2Farbitrage.ph%2Fvyndue%2F";
            // echo "Redirects to $home/login?sso_login=$sso_login&sso_token=$sso_token";
            wp_safe_redirect( "$home/login?redirect_to=$url");
        }
    }
}
//endregion Shortcodes
