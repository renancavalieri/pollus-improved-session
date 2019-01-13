<?php

/**
 * Improved Session
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\ImprovedSession;

use Pollus\SessionWrapper\SessionInterface;
use Pollus\SessionWrapper\Session;

/**
 * This class extends the default PHP Session and improves its methods by
 * handling cookies and provides a better session constructor.
 * 
 * Based on SlimSession by bryanjhv
 * 
 * {@see https://github.com/bryanjhv/slim-session} 
 */
class ImprovedSession extends Session implements SessionInterface
{
    /**  
     * lifetime: How much should the session last in minutes without user activity? Defaults to 24 minutes.
     * path, domain, secure, httponly: Options for the session cookie.
     * name: Name for the session cookie. Defaults to PHPSESSID.
     * autorefresh: true if you want session to be refresh when user activity is made.
     * ini_settings: Associative array of custom session configuration.
     * 
     * @param array $settings
     */
    public function __construct(array $settings = [])
    {
        $defaults = 
        [
            'lifetime'     => 60 * 24,
            'path'         => '/',
            'domain'       => null,
            'secure'       => false,
            'httponly'     => true,
            'name'         => "PHPSESSION",
            'autorefresh'  => true,
            'ini_settings' => [],
        ];
        $this->settings = array_merge($defaults, $settings);
        $this->iniSet($this->settings['ini_settings']);
    }
    
    /**
     * This implementation changes the default behaviour of start() method by
     * setting cookie params, session name, gc_maxlifetime and auto refreshing
     * the session cookie.
     * 
     * @param array $options
     * @return bool
     */
    public function start(array $options = array()): bool
    {
        $this->setCookieParams
        (
            $this->settings['lifetime'],
            $this->settings['path'],
            $this->settings['domain'],
            $this->settings['secure'],
            $this->settings['httponly']
        );
        
        ini_set('session.gc_maxlifetime', $this->settings["lifetime"]);
        
        // Refresh session cookie when "inactive",
        // else PHP won't know we want this to refresh
        if ($this->settings['autorefresh'] && isset($_COOKIE[$this->settings["name"]])) 
        {
            setcookie
            (
                $this->settings["name"],
                $_COOKIE[$this->settings["name"]],
                time() + $this->settings['lifetime'],
                $this->settings['path'],
                $this->settings['domain'],
                $this->settings['secure'],
                $this->settings['httponly']
            );
        }
        $this->name($this->settings["name"]);
        return parent::start($options);
    }

    /**
     * This implementation invalidates the session cookie
     * 
     * {@inheritDoc}
     */
    public function destroy(): bool
    {
        $this->unset();
        parent::destroy();
        $this->commit();
        if (ini_get('session.use_cookies')) 
        {
            $this->invalidateCookies();
        }
        return true;
    }
    
    /**
     * Invalidates a session cookie
     */
    protected function invalidateCookies()
    {
        $params = session_get_cookie_params();
        setcookie
        (
            $this->name(),
            '',
            time() - 4200,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    
    /**
     * Sets INI settings
     * 
     * @param array $settings
     */
    protected function iniSet(array $settings)
    {
        foreach ($settings as $key => $val) 
        {
            if (strpos($key, 'session.') === 0) 
            {
                ini_set($key, $val);
            }
        }
    }
}
