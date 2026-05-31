=== Product Variant Dropdown or Radio Button for WooCommerce ===
Contributors: sentiplug2026, zamanetl, rakeybul84
Tags: woocommerce, variations, product variations, radio buttons, dropdown
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Switch WooCommerce variation dropdowns to clean radio buttons or improved dropdowns for clearer, faster product option selection.

== Description ==

**Product Variant Dropdown or Radio Button for WooCommerce** gives you control over how WooCommerce variation attributes are displayed on product pages.

By default, WooCommerce shows variable product options (like size or color) as dropdowns. This plugin lets you decide, per attribute or per product, whether those options should appear as:

* A standard (but cleaned-up) drop-down.
* A clear, one-click **radio button** group.

Use it when you want customers to see all choices at once (radio) or keep things compact (drop-down), without writing custom code or editing templates.

### What this plugin does

* Replace variation dropdowns with radio buttons for easier selection.
* Keep dropdowns, but make them clearer and more consistent.
* Mix dropdowns and radio buttons on the same product when it makes sense.
* Keep using WooCommerce's built-in variation logic for price, stock, and images.

### Key features

* **Per-attribute display control**
  Choose whether an attribute like Size or Color should render as a drop-down or as a radio button group.

* **Per-product overrides**
  Override the default behavior on individual products if they need a different UI.

* **Improved dropdown UX**
  Optionally refine labels / placeholders so dropdowns are easier to understand (e.g. "Choose a size" instead of a blank first option).

* **Clear radio button groups**
  Show all options at once with radio buttons, so customers can pick the right variant with a single click.

* **WooCommerce-native**
  Works with standard WooCommerce attributes, terms, and variable products. No custom product types or data structures.

* **Theme-friendly and extensible**
  Uses established WooCommerce hooks and markup patterns, making it easier to style and extend in your theme or child theme.

### How it works

1. Set up attributes in **Products → Attributes** (for example: Size, Color).
2. In the product edit screen, pick a display type for each attribute:
   * **Drop-down**
   * **Radio buttons**
3. Optionally, override the display type on specific products in the product edit screen.
4. On the front end, the plugin replaces (or enhances) WooCommerce's default dropdown markup based on your choices.
5. WooCommerce still handles variation selection, pricing, stock status, and gallery images.

### Typical use cases

* Show sizes (S, M, L, XL) as radio buttons instead of a dropdown.
* Keep Color as a dropdown, but improve the first "Choose…" label.
* Use dropdowns for long lists (e.g. 20+ options) and radio buttons for short, important attributes.
* Make variant selection more obvious and reduce user confusion.

### Who is it for?

* **Store owners** who want a clearer, more direct variant selection UI.
* **Marketers** who want to reduce friction at the "choose options" step in the funnel.
* **Developers and agencies** who prefer a configurable, hook-based solution instead of hand-coded templates on every project.

== Installation ==

1. Make sure WooCommerce is installed and active.
2. Upload the plugin folder to `/wp-content/plugins/product-variant-dropdown-radio-button/`
   or install it via **Plugins → Add New**.
3. Activate **Product Variant Dropdown or Radio Button for WooCommerce** through the **Plugins** menu in WordPress.
4. Edit any variable product and set the Display Mode for each attribute under the **Attributes** tab.

== Frequently Asked Questions ==

= Does this change how my products or variations are stored? =

No. The plugin uses existing WooCommerce attributes, terms, and variable products. It only changes the way options are displayed, not how they are stored.

= Will it work with my theme? =

It's designed for WooCommerce-compatible themes that support variable products. Most themes will work out of the box; you may add a small amount of CSS for perfect styling.

= Can I mix dropdowns and radio buttons on the same product? =

Yes. You can configure some attributes to use dropdowns and others to use radio buttons, even on the same product.

= Does it affect stock management or pricing? =

No. WooCommerce still handles variation selection, stock, and pricing. The plugin only changes the UI for selecting attributes.

= Is it compatible with caching and optimization plugins? =

Yes. It follows standard WooCommerce and WordPress practices. As always, test configuration changes on a staging environment before deploying to production.

== Screenshots ==

1. Product page showing attributes as radio buttons instead of dropdowns.
2. Plugin settings screen for choosing drop-down or radio per attribute.
3. Per-product override options in the product edit screen.

== Changelog ==

= 1.0.0 =
* Initial release.
* Per-attribute and per-product display type (drop-down or radio).
* Radio button rendering for WooCommerce variation attributes.
* Improved dropdown labels and placeholders.