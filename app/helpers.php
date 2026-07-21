<?php

if (!function_exists('getYoutubeEmbed')) {
    function getYoutubeEmbed(string $url): string
    {
        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([\w-]{11})/', $url, $m);
        return isset($m[1]) ? 'https://www.youtube.com/embed/' . $m[1] : $url;
    }
}
