<?php

use Cake\Routing\Router;

$baseUrl = Router::url('/', true);

$BotDetect = \CaptchaConfiguration::GetSettings();

$BotDetect->HandlerUrl = $baseUrl . '/captcha-handler';

// use Laravel session to store persist Captcha codes and other Captcha data
$BotDetect->SaveFunctionName = 'CAKE_Session_Save';
$BotDetect->LoadFunctionName = 'CAKE_Session_Load';
$BotDetect->ClearFunctionName = 'CAKE_Session_Clear';

\CaptchaConfiguration::SaveSettings($BotDetect);

global $session;
$session = $includeData;

// re-define custom session handler functions
function CAKE_Session_Save($key, $value)
{
    global $session;
    // save the given value with the given string key
    $session->write($key, serialize($value));
}

function CAKE_Session_Load($key)
{
    global $session;
    // load persisted value for the given string key
    if ($session->check($key)) {
        return unserialize($session->read($key)); // NOTE: returns false in case of failure
    }
}

function CAKE_Session_Clear($key)
{
    global $session;
    // clear persisted value for the given string key
    if ($session->check($key)) {
        $session->delete($key);
    }
}
