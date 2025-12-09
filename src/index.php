<!DOCTYPE html>
<html>
    <head>
        <title>SWAAGGR Web Analytics</title>
        <script>
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
                if (document.readyState === 'complete') {
                    swag();
                } else {
                    window.addEventListener('load', swag);
                }
                // Optional: Track History changes (for Single Page Apps like React/Vue)
                let pushState = history.pushState;
                history.pushState = function() {
                    pushState.apply(history, arguments);
                    swag();
                };
            })();
        </script>
    </head>
    <body>
        <h1>SWAAGGR : Self-Hosted Web Analytics Aggregator</h1>
        <ul>
            <li><b>Current Status:</b> Active</li>
            <li><b>Server Time:</b> <?php echo date('Y-m-d H:i:s'); ?>
        </ul>
    </body>
</html>
