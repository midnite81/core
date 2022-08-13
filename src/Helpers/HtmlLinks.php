<?php

declare(strict_types=1);

namespace Midnite81\Core\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HtmlLinks
{
    /**
     * @param  string  $text
     * @param  Request|null  $request
     * @return string
     */
    public static function targetBlank(string $text, ?Request $request = null): string
    {
        $request = $request ?? request();
        $appUrl = $request->server('HTTP_HOST');

        return preg_replace_callback('~<a.*?href="(.*?)".*?>.*?</a>~s', function ($matches) use ($appUrl) {
            if (Str::startsWith($matches[1], ['http', '://']) && !Str::contains($matches[1], $appUrl)) {
                return str_replace('<a', '<a target="_blank" rel="noopener noreferrer"', $matches[0]);
            }

            return $matches[0];
        }, $text);
    }

    /**
     * Add github package link to html
     *
     * @param  string  $html
     * @param  string  $packageUrl
     * @return string
     */
    public static function addPackageLink(string $html, string $packageUrl): string
    {
        return preg_replace_callback('~^(<h1>.*?</h1>)~', function ($matches) use ($packageUrl) {
            return
                sprintf(
                    '<div class="flex flex-wrap w-full"><div class="flex-1">%s</div><div class="flex-0 text-right">%s</div></div>',
                    $matches[1],
                    static::githubIconAndLink(
                        $packageUrl,
                        'View on github',
                        'h-6 w-6 inline mr-2',
                        'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium
                                rounded-md shadow-sm text-white bg-slate-800 hover:bg-slate-700 focus:outline-none focus:ring-2
                                focus:ring-offset-2 focus:ring-slate-500 no-underline')
                );
        }, $html);
    }

    public static function githubIconAndLink(string $url, ?string $text = null, string $svgClass = null, ?string $linkCss = null): string
    {
        $svg = <<<'SVG'
<svg class=":CLASSES:"" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
    <path fill-rule="evenodd"
          d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
          clip-rule="evenodd"/>
</svg>
SVG;

        $svg = str_replace(':CLASSES:', $svgClass, $svg);

        return "<a href=\"$url\" class=\"$linkCss\">$svg $text</a>";
    }
}
