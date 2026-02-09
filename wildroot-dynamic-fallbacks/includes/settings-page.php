<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', 'wdf_add_admin_menu');
add_action('admin_init', 'wdf_settings_init');

function wdf_add_admin_menu() {
    add_options_page('Wildroot Fallbacks', 'Wildroot Fallbacks', 'manage_options', 'wildroot_fallbacks', 'wdf_options_page');
}

function wdf_settings_init() {
    register_setting('wdf_plugin_page', 'wdf_settings');
}

function wdf_options_page() {
    $options = get_option('wdf_settings');
    $categories = get_categories(array('hide_empty' => false));
    $product_cats = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false));
    ?>
    <div class="wrap">
        <h1>Wildroot Fallback Configuration</h1>
        <form action='options.php' method='post'>
            <?php
            settings_fields('wdf_plugin_page');
            ?>
            
            <h2>Global Fallback</h2>
            <p>This image will show if no category-specific image is set.</p>
            <input type="number" name="wdf_settings[global_fallback]" value="<?php echo esc_attr($options['global_fallback'] ?? ''); ?>" placeholder="Image ID">
            <p class="description">Enter the Media Library ID (e.g., 125).</p>

            <hr>

            <h2>Category-Specific Mapping</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Taxonomy</th>
                        <th>Fallback Image ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $all_terms = array_merge(is_array($categories) ? $categories : [], is_array($product_cats) ? $product_cats : []);
                    foreach ($all_terms as $term) : ?>
                        <tr>
                            <td><strong><?php echo esc_html($term->name); ?></strong></td>
                            <td><?php echo esc_html($term->taxonomy); ?></td>
                            <td>
                                <input type="number" 
                                       name="wdf_settings[category_map][<?php echo $term->term_id; ?>]" 
                                       value="<?php echo esc_attr($options['category_map'][$term->term_id] ?? ''); ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}