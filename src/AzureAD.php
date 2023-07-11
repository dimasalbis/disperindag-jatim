<?php

/**
 * Azure AD provider for Hybridauth
 * Copyright (c) e.World Technology Limited. All rights reserved.
*/

namespace PHPMaker2023\pembuatan_mesin;

use Hybridauth\Adapter\OAuth2;
use Hybridauth\Exception\UnexpectedApiResponseException;
use Hybridauth\Data;
use Hybridauth\User;

class AzureAD extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    public $scope = "openid profile email offline_access https://graph.microsoft.com/User.Read";

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = "https://login.microsoftonline.com/common/oauth2/v2.0/authorize";

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = "https://login.microsoftonline.com/common/oauth2/v2.0/token";

    /**
     * {@inheritdoc}
     */
    protected function initialize()
    {
        parent::initialize();
        $this->AuthorizeUrlParameters += [
            "access_type" => "offline"
        ];
        $this->tokenRefreshParameters = ($this->tokenRefreshParameters ?? []) + [
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function validateAccessTokenExchange($response)
    {
        $collection = parent::validateAccessTokenExchange($response);
        if ($collection->exists("id_token")) {
            $idToken = $collection->get("id_token");
            $parts = explode(".", $idToken);
            list($headb64, $payload) = $parts;
            $data = Tea::base64DecodeUrl($payload); // JWT token is base64 url-encoded
            $this->storeData("user_data", $data);
        } else {
            throw new \Exception("No id_token was found.");
        }
        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserProfile()
    {
        $userData = $this->getStoredData("user_data");
        $user = json_decode($userData);
        $data = new Data\Collection($user);
        $userProfile = new User\Profile();
        $userProfile->identifier = $data->get("sub");
        $userProfile->displayName = $data->get("name") ?? $data->get("preferred_username");
        $userProfile->photoURL = $data->get("picture");
        $userProfile->email = $data->get("preferred_username");
        $userProfile->data = $data->toArray();
        $userInfoUrl = "https://graph.microsoft.com/oidc/userinfo";
        if (
            !empty($userInfoUrl) &&
            !isset(
                $userProfile->displayName,
                $userProfile->photoURL,
                $userProfile->email,
                $userProfile->data["groups"]
            )
        ) {
            $profile = new Data\Collection($this->apiRequest($userInfoUrl));
            if (empty($userProfile->displayName)) {
                $userProfile->displayName = $profile->get("name") ?? $profile->get("nickname");
            }
            if (empty($userProfile->photoURL)) {
                $userProfile->photoURL = $profile->get("picture") ?? $profile->get("avatar");
                if (preg_match('/<img.+src=["\'](.+?)["\']/i', $userProfile->photoURL, $m)) {
                    $userProfile->photoURL = $m[1];
                }
            }
            if (empty($userProfile->email)) {
                $userProfile->email = $profile->get("preferred_username");
            }
            $userProfile->data += $profile->toArray();
        }
        return $userProfile;
    }
}
