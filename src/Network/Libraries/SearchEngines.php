<?php

declare(strict_types=1);

namespace Midnite81\Core\Network\Libraries;

use Illuminate\Support\Collection;
use Midnite81\Core\Contracts\Network\Libraries\LibraryInterface;

class SearchEngines implements LibraryInterface
{
    /**
     * {@inheritDoc}
     */
    public function dictionary(): Collection
    {
        return collect([
            'Googlebot' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
            'Googlebot.Name' => 'Googlebot',
            'Googlebot.Url' => 'http://www.google.com/bot.html',

            'Bingbot' => 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)',
            'Bingbot.Name' => 'Bingbot',
            'Bingbot.Url' => 'http://www.bing.com/bingbot.htm',

            'Yahoo! Slurp' => 'Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)',
            'Yahoo! Slurp.Name' => 'Yahoo! Slurp',
            'Yahoo! Slurp.Url' => 'http://help.yahoo.com/help/us/ysearch/slurp',

            'DuckDuckBot' => 'DuckDuckBot/1.0; (+http://duckduckgo.com/duckduckbot.html)',
            'DuckDuckBot.Name' => 'DuckDuckBot',
            'DuckDuckBot.Url' => 'http://duckduckgo.com/duckduckbot.html',

            'BaiduSpider' => 'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)',
            'BaiduSpider.Name' => 'BaiduSpider',
            'BaiduSpider.Url' => 'http://www.baidu.com/search/spider.html',

            'YandexBot' => 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)',
            'YandexBot.Name' => 'YandexBot',
            'YandexBot.Url' => 'http://yandex.com/bots',

            'Sogou Spider' => 'Mozilla/5.0 (compatible; Sogou web spider)',
            'Sogou Spider.Name' => 'Sogou web spider',
            'Sogou Spider.Url' => 'http://www.sogou.com/docs/help/webmasters.htm#07',

            'Exabot' => 'Mozilla/5.0 (compatible; Exabot; +http://www.exabot.com/go/robot)',
            'Exabot.Name' => 'Exabot',
            'Exabot.Url' => 'http://www.exabot.com/go/robot',

            'SeznamBot' => 'Mozilla/5.0 (compatible; SeznamBot/3.2; +http://napoveda.seznam.cz/en/seznambot-intro/)',
            'SeznamBot.Name' => 'SeznamBot',
            'SeznamBot.Url' => 'http://napoveda.seznam.cz/en/seznambot-intro/',
        ]);
    }
}
