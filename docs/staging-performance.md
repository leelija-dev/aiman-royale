# Staging loading improvements

Changes based on staging commit 07e87f9:

- Keep the first dynamic hero image eager and high-priority; lazy-load later slides. The existing desktop/mobile picture sources and carousel settings are preserved.
- Discover Plus Jakarta Sans directly in the shared document head, instead of waiting for custom.css to load and discover an @import. Preserve all font weights, styles and display=swap.
- Remove the unused canvas-confetti dependency from the homepage. The wishlist page still loads its own dependency where it is used.
- Resolve global view data once per request/job through a scoped container binding. Previously, every view/partial performed the unread-notifications query and repeated cached collection retrieval/deserialization. Preserve the existing queries and user-specific cache keys. Scoped data is not shared across request lifecycles.

Validation completed: whitespace/diff checks and source assertions for image loading priorities, font relocation, homepage dependency removal, and unchanged query bodies. No PHP executable, Composer dependencies, application database or running staging environment was available in the editor, so PHP/Blade compilation, browser and application integration checks have not been run. No Lighthouse improvement is claimed.

Before staging deployment, run the project's PHP tests and view compilation (`php artisan view:cache`) in its normal environment. Clear/rebuild view caches after deployment, and invalidate the changed static CSS asset through the existing cache/versioning process.

Verify desktop/mobile hero layout and slide transitions, icons/fonts, logged-out and logged-in menus, wishlist updates, cart, checkout and admin notifications. Compare repeated homepage requests using the same Lighthouse settings and record LCP, CLS, transferred bytes and server response time. Shared data remains fixed within one render/request; any code that intentionally changes that data and renders a second view in the same request should be checked.

This change does not deploy the site or modify another branch. Production caching, image compression/resizing and database index changes need measurements from the server before further tuning.
