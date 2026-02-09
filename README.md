# Wildroot Dynamic Fallbacks

A lightweight WordPress plugin designed for Wildroot Foragers to maintain visual consistency across blog archives and the WooCommerce shop. This plugin ensures that posts and products never appear with a missing featured image by implementing an automated hierarchical fallback system.

## Priority Logic

The plugin uses a hierarchical "top-down" approach to determine which image to display. It intercepts the featured image call using WordPress hooks to ensure optimal performance.

1.  **Assigned Featured Image**: If a post or product has an image manually assigned, it will always be displayed first.
2.  **Category-Specific Default**: If no image is assigned, the plugin checks if the primary category (or product category) has a specific default image mapped in the settings.
3.  **Global Fallback**: If no category-specific image is found, the plugin displays the site-wide global default image.

## Installation Instructions

1.  **Download the Plugin**: Obtain the `wildroot-dynamic-fallbacks.zip` file.
2.  **Upload to WordPress**: 
    * Log in to your WordPress Admin Dashboard.
    * Navigate to **Plugins > Add New**.
    * Click **Upload Plugin** at the top of the page.
    * Select the ZIP file and click **Install Now**.
3.  **Activate**: Click the **Activate Plugin** button once the upload is complete.
4.  **Configure Settings**:
    * Go to **Settings > Wildroot Fallbacks**.
    * **Global Fallback**: Enter the Image ID from your Media Library to serve as the site-wide default.
    * **Category Mapping**: Enter specific Image IDs next to the desired Post or Product categories to create tailored overrides.
5.  **Save Changes**: Click **Save Changes** to apply the logic across your site.

## Developer Hooks

Developers can programmatically override the fallback logic for specific templates using the provided filter:

```php
apply_filters('wdf_custom_fallback_override', $fallback_id, $object_id);
