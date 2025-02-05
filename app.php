<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover minimal-ui standalone">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <title>Sublimity</title>
        <style>
            body, html {
                margin: 0;
                padding: 0;
                background-color: #000;
                color: #f2f2f2;
                font-family: Helvetica, Arial, sans-serif;
            }

            .hide {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .title {
                font-size: 30px;
                margin: 70px 0 0 17px;
                display: inline-block;
            }

            .sub {
                font-size: 20px;
                margin-top: 78px;
                position: absolute;
                opacity: 0.7;
                display:inline-block;
            }

            .cell-small {
                width: 85%;
                max-width: 400px;
                height: 50px;
                margin: 5px 0;
                background-color: #141312;
                color: #fff;
                padding: 10px;
                border-radius: 15px;
                display: inline-block;
            }

            .cell-small img {
                width: 50px;
                height: 50px;
                border-radius: 30%;
                float: left;
                margin-right: 5px;
            }

            .getbtn {
                font-size: 15px;
                font-weight: 700;
                color: #fff;
                width: 60px;
                text-align: center;
                border-radius: 30px;
                border: 2px solid #131111;
                padding: 5px;
                background-color: #131111;
                float: right;
                text-decoration: none;
            }

            .cell-small h1 {
                font-size: 17px;
                font-weight: 600;
                color: #fff;
                margin: 0;
                text-align: justify;
                text-shadow: 1px 2px 4px #000;
            }

            .cell-small p {
                font-size: 14px;
                color: #fff;
                margin: 0;
                text-align: justify;
            }

            #popupOverlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                display: none;
                z-index: 1000;
            }

            #popupContent {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 300px;
                padding: 20px;
                border-radius: 20px;
                text-align: center;
                background: rgba(0, 71, 255, 0.1);
                backdrop-filter: blur(15px) saturate(180%);
                -webkit-backdrop-filter: blur(15px) saturate(180%);
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
                border: 1px solid rgba(255, 255, 255, 0.2);
                z-index: 1001;
            }

            #popupClose {
                display: inline-block;
                margin-top: 10px;
                padding: 10px 20px;
                background: linear-gradient(135deg, #0066ff, #0033cc);
                color: #fff;
                font-weight: bold;
                border: none;
                border-radius: 12px;
                cursor: pointer;
                text-transform: uppercase;
                transition: background 0.3s ease;
            }

            #popupClose:hover {
                background: linear-gradient(135deg, #004bcc, #002a99);
            }

            #popupMessage {
                font-size: 18px;
                margin-bottom: 10px;
                color: #e6e6e6;
                font-weight: 600;
            }
            .navbar {
                width: 100%;
                padding: 15px 20px;
                position: fixed;
                top: 0;
                left: 0;
                backdrop-filter: blur(12px);
                background: rgba(0, 0, 0, 0.6);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <nav class="navbar">
            <div class="logo">
                <h1 class="title">Eonn</h1>
                <h3 class="sub">Beta</h3>
            </div>
         </nav>
         
        <div style="margin-top:140px;"></div>

        <center>
            <?php
                $url = "https://api.casp.dev/apis/enhancedgames.json";
                $contextOptions = [
                    "ssl" => [
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ],
                ];
                $context = stream_context_create($contextOptions);
                $jsonData = file_get_contents($url, false, $context);

                if ($jsonData === false) {
                    echo "<p>Failed to load data.</p>";
                } else {
                    $apps = json_decode($jsonData, true);

                    foreach ($apps as $app) {
                        $downloadUrl = "https://casp.dev/download.php?url=" . urlencode(
                            "https://api.casp.dev/sign/sign-16.php?ipa=" . urlencode($app['file']) .
                            "&img=" . urlencode($app['icon']) .
                            "&name=" . urlencode($app['appname']) .
                            "&action=click&api=all&cert=cert&pass=EonHubApp.com"
                        );
            ?>
                        <div class="cell-small">
                            <a class="getbtn" href="<?php echo $downloadUrl; ?>">GET</a>
                            <img alt="icon" src="<?php echo htmlspecialchars($app['icon']); ?>" onerror="this.src='https://casp.dev/placeholder-app-icon.png'">
                            <h1 class="hide"><?php echo htmlspecialchars($app['appname']); ?></h1>
                            <p>
                                <span>Modded Game</span><br>
                                <span class="hide"><?php echo htmlspecialchars($app['file']); ?></span>
                            </p>
                        </div>
            <?php
                    }
                }
            ?>
        </center>

        <div id="popupOverlay">
            <div id="popupContent">
                <p id="popupMessage">Welcome to our beta! Here is a preview of our apps powered by EonHub. We are waiting for EonHub to get a cert to make our store work.</p>
                <button id="popupClose">Close</button>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $('#popupOverlay').fadeIn();

                $('#popupClose').on('click', function () {
                    $('#popupOverlay').fadeOut();
                });
            });
        </script>
    </body>
</html>
