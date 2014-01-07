<?php

namespace Feed;

class Token
{
    public static function cacheAccessToken()
    {
        if (isset($_SESSION['instagram_access_token'])) {
            $instagram = new \Instagram\Instagram;
            $instagram->setAccessToken($_SESSION['instagram_access_token']);
            $current_user = $instagram->getCurrentUser();
            $user = [
                'username' => $current_user->getUsername(),
                'user_id' => $current_user->getId(),
                'access_token' => $_SESSION['instagram_access_token']
            ];
            file_put_contents(INSTAGRAM_USER_TOKEN, json_encode($user));
        }
    }

    public static function getAccessToken() {
        $access_token = false;

        try {
            $cached_token = json_decode(file_get_contents(INSTAGRAM_USER_TOKEN));
            $access_token = $cached_token->access_token;
        } catch (\Exception $e) {
            $access_token = null;
        }

        if (isset($_SESSION['instagram_access_token'])) {
            $access_token = $_SESSION['instagram_access_token'];
        }

        return $access_token;
    }

}
