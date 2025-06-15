<?php

namespace App\Helpers;

/**
 * Class for converting images and their metadata to WebP format.
 */
class SleipnirWebpConverter
{
    /**
     * Convert jpeg and png images to webp on upload.
     *
     * @param array $upload
     * @return void
     */
    public function convert_to_webp_on_upload(array $upload): array {
        $image_types = ['image/jpeg', 'image/png'];
        if (in_array($upload['type'], $image_types)) {
            $file_path = $upload['file'];

            switch ($upload['type']) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($file_path);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($file_path);
                    break;
                default:
                    return $upload;
            }

            $webp_path = str_replace(['.jpg', '.jpeg', '.png'], '.webp', $file_path);

            if (imagewebp($image, $webp_path, 80)) {
                $upload['file'] = $webp_path;
                $upload['url'] = str_replace(wp_basename($file_path), wp_basename($webp_path), $upload['url']);
                $upload['type'] = 'image/webp';

                unlink($file_path);
            }

            imagedestroy($image);
        }

        return $upload;
    }

    /**
     * Generate metadata for WebP files.
     *
     * @param array $metadata
     * @param integer $attachment_id
     * @return array
     */
    public function update_webp_metadata(array $metadata, int $attachment_id): array {
        $file = get_attached_file($attachment_id);
        if (pathinfo($file, PATHINFO_EXTENSION) === 'webp') {
            $metadata['file'] = str_replace(wp_upload_dir()['basedir'] . '/', '', $file);
            $metadata['mime-type'] = 'image/webp';
        }
        return $metadata;
    }
}
