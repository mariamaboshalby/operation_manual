<?php

/**
 * Extract a YouTube video ID from any supported YouTube URL format.
 *
 * Supported formats:
 *   https://www.youtube.com/watch?v=VIDEO_ID
 *   https://youtu.be/VIDEO_ID
 *   https://www.youtube.com/embed/VIDEO_ID
 *   https://www.youtube.com/shorts/VIDEO_ID
 *
 * Returns the 11-character video ID, or null if the URL is not a
 * recognised YouTube URL or contains no valid video ID.
 *
 * SECURITY: never trust the raw URL for iframe src — only the extracted
 * ID is used to build the embed URL.
 */
if (!function_exists('extractYoutubeId')) {
    function extractYoutubeId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // Must be http(s) and a recognised YouTube domain
        if (!preg_match('/^https?:\/\/(www\.)?(youtube\.com|youtu\.be)\//i', $url)) {
            return null;
        }

        // Match the 11-char video ID from any known path pattern
        $pattern = '/(?:youtube\.com\/(?:watch\?(?:.*&)?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}

/**
 * Convert a YouTube URL into a safe YouTube embed URL.
 *
 * Returns only a hardcoded https://www.youtube.com/embed/VIDEO_ID URL.
 * Returns null (not the raw URL) when the input is not a valid YouTube URL.
 * This prevents arbitrary iframe sources from reaching the template.
 */
if (!function_exists('getYoutubeEmbed')) {
    function getYoutubeEmbed(?string $url): ?string
    {
        $id = extractYoutubeId($url);
        if ($id === null) {
            return null;
        }
        return 'https://www.youtube.com/embed/' . $id;
    }
}

/**
 * Check whether a string is a valid YouTube URL (any supported format).
 * Used by validation rules and form logic.
 */
if (!function_exists('isValidYoutubeUrl')) {
    function isValidYoutubeUrl(?string $url): bool
    {
        return extractYoutubeId($url) !== null;
    }
}
