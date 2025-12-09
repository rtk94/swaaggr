<script>
// This snippet should be added to the HTML header of each webpage you wish to track analytics for.
(function() {
    const ENDPOINT = 'https://analytics.rknepp.com/track.php';

    function swag() {
        const data = {
            url: window.location.href,
            path: window.location.pathname,
            referrer: document.referrer || 'direct',
            timestamp: new Date().toISOString(),
            width: window.screen.width,
            ua: navigator.userAgent
        };

        // Use sendBeacon for background reliability
        if (navigator.sendBeacon) {
            navigator.sendBeacon(ENDPOINT, new Blob([JSON.stringify(data)], {type: 'application/json'}));
        } else {
            fetch(ENDPOINT, {method: 'POST', body: JSON.stringify(data), keepalive: true});
        }
    }

    // Fire on load
    if (document.readyState === 'complete') swag();
    else window.addEventListener('load', swag);

    // Optional: Track History changes (for Single Page Apps like React/Vue)
    let pushState = history.pushState;
    history.pushState = function() {
        pushState.apply(history, arguments);
        swag();
    };
})();
</script>
