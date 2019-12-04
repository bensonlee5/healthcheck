checkup.config = {
	// How much history to show on the status page. Long durations and
	// frequent checks make for slow loading, so be conservative.
	// This value is in NANOSECONDS to mirror Go's time package.
	"timeframe": 1 * time.Day,

	// How often, in seconds, to pull new checks and update the page.
	"refresh_interval": 10,

	// Configure read-only access to stored checks. This configuration
	// depends on your storage provider. Any credentials and other values
	// here will be visible to everyone, so use keys with ONLY read access!
	"storage": {
		// Local file system (Caddy recommended: https://caddyserver.com)
		"url": "https://healthcheck.accumedintel.net/check_files"
	},

	// The text to display along the top bar depending on overall status.
	"status_text": {
		"healthy": "Services are operating normally <div class='spinner-grow text-success' role='status'>
  <span class='sr-only'>Loading...</span>
</div>",
		"degraded": "Some services are degraded",
		"down": "Some services are not operating"
	}
};
