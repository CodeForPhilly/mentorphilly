<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class SlackBot extends Model
{
    //

     /**
     * Instance of GuzzleHttp Client with base_uri configured
     *
     * @var GuzzleHttp\Client
     */
    private $client;
    /**
     * Default channel to post messages
     *
     * @var string
     */
    private $defaultChannel;
    /**
     * Username to send messages under
     *
     * @var string
     */
    private $username;
    /**
     * Slack API token
     *
     * @var string
     */
    private $token;
    /**
     * Slack webhook
     *
     * @var string
     */
    private $webhook;
    /**
     * Emoji icon
     *
     * @var string
     */
    private $emoji;
    /**
     * Result of IpInfo lookup
     *
     * @var stdClass
     */
    private $ipResult;
    /**
     * Providers to blacklist
     *
     * @var Array
     */
    private $blacklistProviders;
    /**
     * Setup new instance with configuration
     *
     * @param Array $config
     */
    public function __construct()
    {
        $this->defaultChannel = config('services.slack.default_channel');
        $this->token = config('services.slack.token');
        $this->webhook = config('services.slack.webhook');
        $this->username = config('services.slack.username');
        // // append server IP to title if specified
        // if (config('services.slack.server_ip')') {
        //     $ipClient = new Client();
        //     $ip = trim($ipClient->request('GET', 'http://checkip.amazonaws.com/')->getBody());
        //     $this->username .= " [{$ip}]";
        // }
        $this->emoji = config('services.slack.emoji_icon');
      
            $this->client = new Client();
      
              $this->blacklistProviders = config('services.slack.blacklist_providers');
    }



    public function chatter($message, $channel)
    {
        try {
            $response = $this->client->post('https://slack.com/api/chat.postMessage',
            [
                'verify'        =>  false,
                'form_params'   =>  [
                    'token'     => $this->token,
                    'username'  => $this->username,
                    'icon_emoji'=> $this->emoji,
                    'channel'   => $channel,
                    // send all messages with >>> so it's indented (creates vertical
                    // separation between messages)
                    // 'text'      => ">>>{$message}"
                    'text'      => "$message"
                    // 'pretext' => $pretext, 
                    // 'attachment' => $attachment
                ]
            ]);
        } catch (RequestException $e) {
            throw new \Exception($e->getMessage());
        }
        $status = $response->getStatusCode();
        $body = json_decode($response->getBody());
        if ($body->ok) {
            return true;
        } else {
            // if bad authorization throw error
            if (property_exists($body, 'error') && $body->error == "invalid_auth") {
                throw new \Exception("Slack Bot credentials are invalid!");
            }
            if (property_exists($body, 'error') && $body->error == "account_inactive") {
                throw new \Exception("Slack Bot credentials are inactive!");
            }
            // if 429 status code, sleep for a minute (429 = speed limit hit)
            if ($status == 429) {
                set_time_limit(180);
                sleep(60);
                return false;
            }
        }
    }


}

