# Wildroot Dynamic Fallbacks

A custom WordPress plugin for **Wildroot Foragers** to manage hierarchical featured image fallbacks.

## Priority Logic
1. **Assigned Image**: Uses the post/product featured image if set.
2. **Category Default**: Uses the image assigned to the primary category.
3. **Global Default**: Uses the site-wide fallback image.

## Installation
1. Zip the `wildroot-dynamic-fallbacks` folder.
2. Go to **Plugins > Add New > Upload Plugin** in WordPress.
3. Activate the plugin.
4. Navigate to **Settings > Wildroot Fallbacks** to map your Image IDs.

## Developer Filter
To override the fallback via code:
```php
add_filter('wdf_custom_fallback_override', function($image_id, $post_id) {
    // Custom logic here
    return $image_id;
}, 10, 2);