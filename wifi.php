<?php
// WiFi Konfiguration
$wifiNetworks = [
    ['ssid' => 'KiJu', 'password' => '206ogoOvdw14uNxXE9wJ'],
    ['ssid' => 'MA-PRV', 'password' => 'D1MKiMaPvR23!']
];

// Betriebssystem Erkennung
function detectOS() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    if (stripos($userAgent, 'android') !== false) return 'android';
    if (stripos($userAgent, 'iphone') !== false || stripos($userAgent, 'ipad') !== false) return 'ios';
    if (stripos($userAgent, 'windows') !== false) return 'windows';
    if (stripos($userAgent, 'mac') !== false) return 'mac';
    if (stripos($userAgent, 'linux') !== false) return 'linux';
    
    return 'unknown';
}

$os = detectOS();
$primaryNetwork = $wifiNetworks[0];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Auto WiFi Connect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, sans-serif; 
            max-width: 500px; 
            margin: 0 auto; 
            padding: 20px; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            min-height: 100vh;
        }
        .status {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-top: 20px;
        }
        .network-card {
            margin: 12px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        .password {
            font-family: monospace;
            font-size: 18px;
            background: #e9ecef;
            padding: 8px 12px;
            border-radius: 6px;
            display: inline-block;
            margin: 5px 0;
        }
        .os-badge {
            display: inline-block;
            padding: 4px 12px;
            background: #667eea;
            color: white;
            border-radius: 20px;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1 style="color: white; text-align: center; margin-bottom: 10px;">🤖 Auto WiFi Connect</h1>
    <p style="color: white; text-align: center; opacity: 0.9;">Automatische Verbindung für dein Gerät</p>
    
    <div class="status">
        <div class="os-badge">Erkannt: <?php echo strtoupper($os); ?></div>
        
        <?php if ($os === 'android'): ?>
            <!-- Android Auto-Redirect -->
            <script>
                setTimeout(function() {
                    window.location.href = "intent://wifi/<?php echo $primaryNetwork['ssid']; ?>#Intent;scheme=android;end;";
                }, 1500);
            </script>
            <h3>📱 Android Verbindung</h3>
            <p>Du wirst automatisch mit dem WLAN verbunden...</p>
            
        <?php elseif ($os === 'ios'): ?>
            <!-- iOS Redirect zu WiFi Einstellungen -->
            <script>
                setTimeout(function() {
                    // Versuche verschiedene iOS Schemes
                    const schemes = [
                        'App-Prefs:root=WIFI',
                        'prefs:root=WIFI', 
                        'App-Prefs:WiFi'
                    ];
                    
                    let success = false;
                    schemes.forEach(scheme => {
                        if (!success) {
                            try {
                                window.location.href = scheme;
                                success = true;
                            } catch(e) {
                                console.log('Scheme failed:', scheme);
                            }
                        }
                    });
                }, 1500);
            </script>
            <h3>🍎 iOS Verbindung</h3>
            <p>Öffne die WiFi-Einstellungen und verbinde manuell:</p>
            
        <?php else: ?>
            <!-- Andere Betriebssysteme -->
            <h3>🌐 WiFi Verbindung</h3>
            <p>Verwende diese Daten für die manuelle Verbindung:</p>
        <?php endif; ?>

        <!-- Aktuelles Netzwerk anzeigen -->
        <div style="background: #fff3cd; padding: 15px; border-radius: 10px; margin: 15px 0;">
            <h4 style="margin-top: 0;">🎯 Empfohlenes Netzwerk</h4>
            <strong>SSID:</strong> <?php echo $primaryNetwork['ssid']; ?><br>
            <strong>Passwort:</strong> <span class="password"><?php echo $primaryNetwork['password']; ?></span>
        </div>

        <!-- Alle verfügbaren Netzwerke -->
        <h4>📶 Alle verfügbaren Netzwerke</h4>
        <?php foreach ($wifiNetworks as $network): ?>
            <div class="network-card">
                <strong><?php echo $network['ssid']; ?></strong><br>
                <span class="password"><?php echo $network['password']; ?></span>
            </div>
        <?php endforeach; ?>
        
        <!-- Fallback für fehlgeschlagenen Redirect -->
        <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #dee2e6;">
            <small style="color: #6c757d;">
                💡 <strong>Tipp:</strong> Falls keine automatische Verbindung erfolgt, verwende die oben angezeigten Daten für die manuelle Verbindung.
            </small>
        </div>
    </div>

    <!-- Zusätzliches JavaScript für bessere UX -->
    <script>
        // Zeige Countdown für Redirect
        <?php if (in_array($os, ['android', 'ios'])): ?>
            let countdown = 3;
            const countdownElement = document.createElement('p');
            countdownElement.innerHTML = `Weiterleitung in <strong>${countdown}</strong> Sekunden...`;
            document.querySelector('.status h3').parentNode.insertBefore(countdownElement, document.querySelector('.status h3').nextSibling);
            
            const countdownInterval = setInterval(() => {
                countdown--;
                countdownElement.innerHTML = `Weiterleitung in <strong>${countdown}</strong> Sekunden...`;
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);
        <?php endif; ?>
    </script>
</body>
</html>
