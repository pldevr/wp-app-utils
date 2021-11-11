<?php

namespace Devr\Utils;

final class Image
{
    /**
     * @param $value
     * @return bool
     */
    public static function isValid($value): bool
    {
        return is_array($value) && !empty($value['url']) && array_key_exists('alt', $value);
    }

    /**
     * @param int $id
     * @param string|int[] $size
     * @return string|null
     */
    public static function getAttachmentSrc(int $id, $size = ''): ?string
    {
        $image = wp_get_attachment_image_src($id, $size);

        return $image ? $image[0] : null;
    }

    /**
     * @param int $id
     * @return string
     */
    public static function getAttachmentAlt(int $id): string
    {
        return get_post_meta($id, '_wp_attachment_image_alt', true);
    }

    /**
     * @param int $id
     * @param string|int[] $size
     * @return array|null
     */
    public static function getAttachment(int $id, $size = ''): ?array
    {
        $attachment = [
            'url' => self::getAttachmentSrc($id),
            'alt' => self::getAttachmentAlt($id),
        ];

        return self::isValid($attachment) ? $attachment : null;
    }
}
