<!DOCTYPE html>
<html>
<head>
    <title>Test API Routes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
        }
        .test-item {
            background: #f5f5f5;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid #667eea;
        }
        .success { border-left-color: #28a745; background: #d4edda; }
        .error { border-left-color: #dc3545; background: #f8d7da; }
        .btn {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .result {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-family: monospace;
            font-size: 12px;
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <h1>🧪 API Routes Test</h1>
    <p>Testing if Interview API routes are accessible</p>

    <div id="results"></div>

    <button class="btn" onclick="testAllRoutes()">Test All Routes</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const routes = [
            { name: 'Create Flow', url: 'index.php/api/interview_api/create_flow', method: 'POST' },
            { name: 'Get Flows', url: 'index.php/api/interview_api/get_flows', method: 'GET' },
            { name: 'Create Interview', url: 'index.php/api/interview_api/create_interview', method: 'POST' },
            { name: 'Get Interviews', url: 'index.php/api/interview_api/get_interviews', method: 'GET' }
        ];

        function testAllRoutes() {
            document.getElementById('results').innerHTML = '<p>Testing routes...</p>';
            
            routes.forEach((route, index) => {
                setTimeout(() => testRoute(route), index * 500);
            });
        }

        function testRoute(route) {
            const resultsDiv = document.getElementById('results');
            
            $.ajax({
                url: route.url + '?api_key=test_key_123',
                method: route.method,
                contentType: 'application/json',
                data: route.method === 'POST' ? JSON.stringify({}) : null,
                success: function(response) {
                    const html = `
                        <div class="test-item success">
                            <strong>✓ ${route.name}</strong><br>
                            <small>${route.method} ${route.url}</small>
                            <div class="result">${JSON.stringify(response, null, 2)}</div>
                        </div>
                    `;
                    resultsDiv.insertAdjacentHTML('beforeend', html);
                },
                error: function(xhr, status, error) {
                    const isNotFound = xhr.status === 404;
                    const html = `
                        <div class="test-item ${isNotFound ? 'error' : 'success'}">
                            <strong>${isNotFound ? '✗' : '⚠'} ${route.name}</strong><br>
                            <small>${route.method} ${route.url}</small><br>
                            <small>Status: ${xhr.status} - ${isNotFound ? 'Route Not Found (404)' : xhr.statusText}</small>
                            ${xhr.responseText ? '<div class="result">' + xhr.responseText + '</div>' : ''}
                        </div>
                    `;
                    resultsDiv.insertAdjacentHTML('beforeend', html);
                }
            });
        }

        // Auto-test on load
        window.onload = function() {
            setTimeout(testAllRoutes, 500);
        };
    </script>
</body>
</html>
