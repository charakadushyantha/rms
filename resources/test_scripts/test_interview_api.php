<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview API Tester</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 { color: #667eea; margin-bottom: 30px; }
        .test-section {
            background: #f5f6fa;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        .test-section h3 { color: #333; margin-bottom: 15px; }
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }
        button:hover { opacity: 0.9; }
        .result {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            max-height: 400px;
            overflow-y: auto;
        }
        .success { color: #2ecc71; }
        .error { color: #e74c3c; }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        label { font-weight: 600; color: #333; display: block; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎯 Interview API Tester</h1>
        <p>Test all Interview API endpoints</p>

        <!-- Test 1: Create Interview Flow -->
        <div class="test-section">
            <h3>1. Create Interview Flow</h3>
            <p>POST /api/interview_api/create_flow</p>
            
            <label>Job Title:</label>
            <input type="text" id="job_title" value="Software Engineer" placeholder="Job Title">
            
            <label>Job Description:</label>
            <textarea id="job_description" rows="3" placeholder="Job Description">We are looking for a talented software engineer to join our team.</textarea>
            
            <label>Interview Type:</label>
            <select id="interview_type" style="width:100%;padding:10px;margin:10px 0;">
                <option value="video">Video</option>
                <option value="audio">Audio</option>
                <option value="text">Text</option>
            </select>
            
            <button onclick="createFlow()">Create Interview Flow</button>
            <div id="result1" class="result" style="display:none;"></div>
        </div>

        <!-- Test 2: Get Interview Flows -->
        <div class="test-section">
            <h3>2. Get Interview Flows</h3>
            <p>GET /api/interview_api/get_flows</p>
            <button onclick="getFlows()">Get All Flows</button>
            <div id="result2" class="result" style="display:none;"></div>
        </div>

        <!-- Test 3: Create Interview -->
        <div class="test-section">
            <h3>3. Create Interview & Generate Link</h3>
            <p>POST /api/interview_api/create_interview</p>
            
            <label>Flow ID:</label>
            <input type="number" id="flow_id" value="1" placeholder="Flow ID">
            
            <label>Candidate Name:</label>
            <input type="text" id="candidate_name" value="John Doe" placeholder="Candidate Name">
            
            <label>Candidate Email:</label>
            <input type="email" id="candidate_email" value="john@example.com" placeholder="Candidate Email">
            
            <button onclick="createInterview()">Create Interview</button>
            <div id="result3" class="result" style="display:none;"></div>
        </div>

        <!-- Test 4: Get Interviews -->
        <div class="test-section">
            <h3>4. Get All Interviews</h3>
            <p>GET /api/interview_api/get_interviews</p>
            <button onclick="getInterviews()">Get All Interviews</button>
            <button onclick="getInterviews('completed')">Get Completed</button>
            <button onclick="getInterviews('pending')">Get Pending</button>
            <div id="result4" class="result" style="display:none;"></div>
        </div>

        <!-- Test 5: Get Single Interview -->
        <div class="test-section">
            <h3>5. Get Single Interview with Transcript</h3>
            <p>GET /api/interview_api/get_interview/:id</p>
            
            <label>Interview ID:</label>
            <input type="number" id="interview_id" value="1" placeholder="Interview ID">
            
            <button onclick="getInterview()">Get Interview Details</button>
            <div id="result5" class="result" style="display:none;"></div>
        </div>

        <!-- Test 6: Update Status -->
        <div class="test-section">
            <h3>6. Update Interview Status</h3>
            <p>PUT /api/interview_api/update_status/:id</p>
            
            <label>Interview ID:</label>
            <input type="number" id="status_interview_id" value="1" placeholder="Interview ID">
            
            <label>New Status:</label>
            <select id="new_status" style="width:100%;padding:10px;margin:10px 0;">
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
                <option value="expired">Expired</option>
            </select>
            
            <button onclick="updateStatus()">Update Status</button>
            <div id="result6" class="result" style="display:none;"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const API_KEY = 'test_key_123';
        const BASE_URL = 'index.php/api/interview_api';

        function showResult(elementId, data, isError = false) {
            const element = document.getElementById(elementId);
            element.style.display = 'block';
            element.innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
            element.className = 'result ' + (isError ? 'error' : 'success');
        }

        function createFlow() {
            const data = {
                job_title: document.getElementById('job_title').value,
                job_description: document.getElementById('job_description').value,
                questions: [
                    {
                        id: 1,
                        question: "Tell us about yourself and your background.",
                        type: "open",
                        duration: 120
                    },
                    {
                        id: 2,
                        question: "Why are you interested in this position?",
                        type: "open",
                        duration: 90
                    },
                    {
                        id: 3,
                        question: "Describe a challenging project you worked on.",
                        type: "open",
                        duration: 120
                    }
                ],
                interview_type: document.getElementById('interview_type').value,
                enable_video_capture: true,
                duration_minutes: 30
            };

            $.ajax({
                url: BASE_URL + '/create_flow?api_key=' + API_KEY,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    showResult('result1', response);
                },
                error: function(xhr) {
                    showResult('result1', JSON.parse(xhr.responseText), true);
                }
            });
        }

        function getFlows() {
            $.ajax({
                url: BASE_URL + '/get_flows?api_key=' + API_KEY,
                method: 'GET',
                success: function(response) {
                    showResult('result2', response);
                },
                error: function(xhr) {
                    showResult('result2', JSON.parse(xhr.responseText), true);
                }
            });
        }

        function createInterview() {
            const data = {
                flow_id: parseInt(document.getElementById('flow_id').value),
                candidate_name: document.getElementById('candidate_name').value,
                candidate_email: document.getElementById('candidate_email').value,
                send_email: false
            };

            $.ajax({
                url: BASE_URL + '/create_interview?api_key=' + API_KEY,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    showResult('result3', response);
                },
                error: function(xhr) {
                    showResult('result3', JSON.parse(xhr.responseText), true);
                }
            });
        }

        function getInterviews(status = null) {
            let url = BASE_URL + '/get_interviews?api_key=' + API_KEY;
            if (status) {
                url += '&status=' + status;
            }

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    showResult('result4', response);
                },
                error: function(xhr) {
                    showResult('result4', JSON.parse(xhr.responseText), true);
                }
            });
        }

        function getInterview() {
            const id = document.getElementById('interview_id').value;

            $.ajax({
                url: BASE_URL + '/get_interview/' + id + '?api_key=' + API_KEY,
                method: 'GET',
                success: function(response) {
                    showResult('result5', response);
                },
                error: function(xhr) {
                    showResult('result5', JSON.parse(xhr.responseText), true);
                }
            });
        }

        function updateStatus() {
            const id = document.getElementById('status_interview_id').value;
            const status = document.getElementById('new_status').value;

            $.ajax({
                url: BASE_URL + '/update_status/' + id + '?api_key=' + API_KEY,
                method: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify({ status: status }),
                success: function(response) {
                    showResult('result6', response);
                },
                error: function(xhr) {
                    showResult('result6', JSON.parse(xhr.responseText), true);
                }
            });
        }
    </script>
</body>
</html>
