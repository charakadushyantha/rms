<!DOCTYPE html>
<html>
<head>
    <title>Test Bot Endpoint</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        pre { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .btn { background: #667eea; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Bot Endpoint Test</h2>
    
    <button class="btn" onclick="testBot()">Test Bot Now</button>
    
    <div id="result"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function testBot() {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = '<p>Testing bot endpoint...</p>';
            
            $.ajax({
                url: 'index.php/bot/send_message',
                method: 'POST',
                data: {
                    message: 'Hello bot',
                    session_id: 'test_' + Date.now()
                },
                dataType: 'json',
                success: function(response) {
                    resultDiv.innerHTML = '<p class="success">✓ Bot responded successfully!</p>';
                    resultDiv.innerHTML += '<h3>Response:</h3>';
                    resultDiv.innerHTML += '<pre>' + JSON.stringify(response, null, 2) + '</pre>';
                    
                    if (response.success && response.message) {
                        resultDiv.innerHTML += '<h3>Bot Message:</h3>';
                        resultDiv.innerHTML += '<p>' + response.message + '</p>';
                    }
                },
                error: function(xhr, status, error) {
                    resultDiv.innerHTML = '<p class="error">✗ Bot endpoint failed!</p>';
                    resultDiv.innerHTML += '<p>Status: ' + status + '</p>';
                    resultDiv.innerHTML += '<p>Error: ' + error + '</p>';
                    resultDiv.innerHTML += '<h3>Response:</h3>';
                    resultDiv.innerHTML += '<pre>' + xhr.responseText + '</pre>';
                }
            });
        }
        
        // Auto-test on load
        window.onload = function() {
            setTimeout(testBot, 500);
        };
    </script>
</body>
</html>
