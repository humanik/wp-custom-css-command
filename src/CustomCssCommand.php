<?php

namespace Humanik\WP_CLI;

use WP_CLI;
use WP_Post;

class CustomCssCommand
{
    public function update(array $args): void
    {
        $content = $args[0];
        $result = wp_update_custom_css_post($content);

        if (is_wp_error($result)) {
            WP_CLI::error($result);
        } else {
            WP_CLI::success('Update success!');
        }
    }

    public function edit(): void
    {
        $post = wp_get_custom_css_post();
        if (!$post) {
            $post = wp_update_custom_css_post('');
        }
        if (!$post instanceof WP_Post) {
            WP_CLI::error("'Can't find css post");
        }

        $result = $this->editContent($post->post_content, "WP-CLI post {$post->ID}");

        if (false === $result) {
            WP_CLI::warning('No change made to css content.', 'Aborted');
        } else {
            $this->update([$result]);
        }
    }

    /**
     * @param string $content
     * @param string $title
     * @return string|false
     */
    protected function editContent(string $content, string $title)
    {
        $content = apply_filters('the_editor_content', $content);
        $result = WP_CLI\Utils\launch_editor_for_input($content, $title);

        return is_string($result) ? apply_filters('content_save_pre', $result) : $result;
    }
}
