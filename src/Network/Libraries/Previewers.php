<?php

declare(strict_types=1);

namespace Midnite81\Core\Network\Libraries;

use Illuminate\Support\Collection;
use Midnite81\Core\Contracts\Network\Libraries\LibraryInterface;

class Previewers implements LibraryInterface
{
    /**
     * {@inheritDoc}
     */
    public function dictionary(): Collection
    {
        return collect([
            'Slack' => 'Slackbot-LinkExpanding 1.0 (+https://api.slack.com/robots)',
            'Slack.Name' => 'Slackbot-LinkExpanding',
            'Slack.URL' => 'https://api.slack.com/robots',

            'Twitter' => 'Twitterbot/1.0',
            'Twitter.Name' => 'Twitterbot',

            'Facebook' => 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)',
            'Facebook.Name' => 'facebookexternalhit',
            'Facebook.URL' => 'http://www.facebook.com/externalhit_uatext.php',

            'LinkedIn' => 'LinkedInBot/1.0 (compatible; Mozilla/5.0; Jakarta Commons-HttpClient/3.1 +http://www.linkedin.com)',
            'LinkedIn.Name' => 'LinkedInBot',
            'LinkedIn.URL' => 'http://www.linkedin.com',

            'Google' => 'Googlebot/2.1 (+http://www.google.com/bot.html)',
            'Google.Name' => 'Googlebot',
            'Google.URL' => 'http://www.google.com/bot.html',

            'Google Ads' => 'AdsBot-Google (+http://www.google.com/adsbot.html)',
            'Google Ads.Name' => 'AdsBot-Google',
            'Google Ads.URL' => 'http://www.google.com/adsbot.html',

            'Google Ads Mobile' => 'AdsBot-Google-Mobile-Apps',
            'Google Ads Mobile.Name' => 'AdsBot-Google-Mobile-Apps',

            'Google Ads Partners' => 'Mediapartners-Google',
            'Google Ads Partners.Name' => 'Mediapartners-Google',

            'Google Ads Images' => 'Googlebot-Image/1.0',
            'Google Ads Images.Name' => 'Googlebot-Image',

            'Google Ads News' => 'Googlebot-News',
            'Google Ads News.Name' => 'Googlebot-News',

            'Google Ads Video' => 'Googlebot-Video/1.0',
            'Google Ads Video.Name' => 'Googlebot-Video',

            'BingBot' => 'Bingbot',
            'BingBot.Name' => 'Bingbot',
            'BingBot.URL' => 'https://www.bing.com/webmaster/help/which-crawlers-does-bing-use-8c184ec0',

            'Pinterest' => 'Pinterestbot',
            'Pinterest.Name' => 'Pinterestbot',
            'Pinterest.URL' => 'https://developers.pinterest.com/docs/redoc/',

            'Discord' => 'Discordbot',
            'Discord.Name' => 'Discordbot',
            'Discord.URL' => 'https://discord.com',

            'Telegram' => 'TelegramBot',
            'Telegram.URL' => 'https://core.telegram.org/bots',

            'WhatsApp' => 'WhatsApp',
            'WhatsApp.URL' => 'https://www.whatsapp.com/',

            'Reddit' => 'Redditbot',
            'Reddit.URL' => 'https://www.reddit.com',

            'Yahoo! Slurp' => 'Yahoo! Slurp',
            'Yahoo! Slurp.URL' => 'https://help.yahoo.com/kb/SLN22600.html',

            'DuckDuckGo' => 'DuckDuckBot',
            'DuckDuckGo.URL' => 'https://duckduckgo.com',

            'Slack.Short' => 'Slackbot',
            'Twitter.Short' => 'Twitterbot',
            'Facebook.Short' => 'facebookexternalhit',
            'LinkedIn.Short' => 'LinkedInBot',
            'Google.Short' => 'Googlebot',
            'AppleBot.Short' => 'Applebot',
        ]);
    }
}
