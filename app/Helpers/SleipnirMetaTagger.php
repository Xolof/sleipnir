<?php

namespace App\Helpers;

/**
 * Class for getting meta description depending on content type.
 */
class SleipnirMetaTagger
{
    /**
     * Function for adding meta tags.
     */
    public function add_meta_tags(): null
    {
        $meta_description = $this->get_meta_description();

        return $this->echo_meta_tag($meta_description);
    }

    /**
     * Clean up and escape a text string.
     */
    protected function cleanup_text(string $text): string
    {
        $text = strip_tags($text);
        $text = strip_shortcodes($text);
        $text = trim($text);
        $text = str_replace(["\n", "\t", "\r"], ' ', $text);

        return esc_attr($text);
    }

    /**
     * Print a description meta tag.
     */
    protected function echo_meta_tag(string $description): void
    {
        $description = $this->cleanup_text($description);
        echo '<meta name="description" content="'.$description.'">';
    }

    /**
     * Get meta description depending on content type.
     */
    protected function get_meta_description(): string
    {
        global $post;

        if (is_singular()) {
            $post_description = substr($post->post_content, 0, 500);

            return $post_description;
        }

        if (is_home()) {
            $blog_description = get_bloginfo('description');
            if ($blog_description) {
                return $blog_description;
            }
        }

        if (is_category()) {
            $category_description = category_description();
            if ($category_description) {
                return $category_description;
            }
        }

        if (is_archive()) {
            if (is_category() || is_tag() || is_tax()) {
                $meta_description = tag_description();

                return $meta_description;

                if (empty($meta_description)) {
                    $meta_description = get_bloginfo('description');

                    return $meta_description;
                }
            }

            if (is_author()) {
                $meta_description = get_the_author_meta('description');

                return $meta_description;
            }

            if (is_date()) {
                $meta_description = 'Posts from '.get_the_date('F Y');

                return $meta_description;
            }
        }

        $meta_description = get_bloginfo('description');

        return $meta_description;
    }
}
