<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .interview-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .welcome-screen, .question-screen, .complete-screen {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        .welcome-screen h1 {
            color: #667eea;
            margin-bottom: 20px;
        }

        .interview-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .question-number {
            font-size: 14px;
            color: #666;
        }

        .timer {
            font-size: 18px;
            font-weight: 600;
            color: #667eea;
        }

        .question-text {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
        }

        .response-area {
            width: 100%;
            min-height: 200px;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            resize: vertical;
        }

        .response-area:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e9ecef;
            border-radius: 10px;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s;
        }

        .complete-screen {
            text-align: center;
        }

        .complete-screen i {
            font-size: 64px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="interview-container">
        <!-- Welcome Screen -->
        <div id="welcome-screen" class="welcome-screen">
            <h1>Welcome to Your Interview</h1>
            <h2><?= htmlspecialchars($interview['job_title']) ?></h2>
            
            <div class="interview-info">
                <p><strong>Candidate:</strong> <?= htmlspecialchars($interview['candidate_name']) ?></p>
                <p><strong>Duration:</strong> <?= $interview['duration_minutes'] ?> minutes</p>
                <p><strong>Questions:</strong> <?= is_array($interview['questions']) ? count($interview['questions']) : count(json_decode($interview['questions'], true)) ?></p>
                <p><strong>Type:</strong> <?= ucfirst($interview['interview_type']) ?> Interview</p>
            </div>

            <p style="margin: 20px 0; color: #666;">
                Please read each question carefully and provide thoughtful responses. 
                You can take your time, but keep track of the overall duration.
            </p>

            <button class="btn btn-primary" onclick="startInterview()">
                <i class="fas fa-play"></i> Start Interview
            </button>
        </div>

        <!-- Question Screen -->
        <div id="question-screen" class="question-screen hidden">
            <div class="progress-bar">
                <div id="progress-fill" class="progress-fill" style="width: 0%"></div>
            </div>

            <div class="question-header">
                <span class="question-number" id="question-number">Question 1 of X</span>
                <span class="timer" id="timer">00:00</span>
            </div>

            <div class="question-text" id="question-text"></div>

            <textarea id="response-area" class="response-area" placeholder="Type your answer here..."></textarea>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <button class="btn btn-primary" onclick="nextQuestion()">
                    Next Question <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Complete Screen -->
        <div id="complete-screen" class="complete-screen hidden">
            <i class="fas fa-check-circle"></i>
            <h1>Interview Completed!</h1>
            <p style="margin: 20px 0; color: #666;">
                Thank you for completing the interview. Your responses have been submitted successfully.
            </p>
            <p>We will review your answers and get back to you soon.</p>
        </div>
    </div>

    <script>
        const interview = <?= json_encode($interview) ?>;
        const questions = typeof interview.questions === 'string' ? JSON.parse(interview.questions) : interview.questions;
        let currentQuestion = 0;
        let startTime = Date.now();
        let questionStartTime = Date.now();

        function startInterview() {
            document.getElementById('welcome-screen').classList.add('hidden');
            document.getElementById('question-screen').classList.remove('hidden');
            loadQuestion();
            startTimer();
        }

        function loadQuestion() {
            if (currentQuestion >= questions.length) {
                completeInterview();
                return;
            }

            const question = questions[currentQuestion];
            document.getElementById('question-text').textContent = question.question;
            document.getElementById('question-number').textContent = 
                `Question ${currentQuestion + 1} of ${questions.length}`;
            document.getElementById('response-area').value = '';
            
            const progress = ((currentQuestion) / questions.length) * 100;
            document.getElementById('progress-fill').style.width = progress + '%';
            
            questionStartTime = Date.now();
        }

        function nextQuestion() {
            const response = document.getElementById('response-area').value;
            if (!response.trim()) {
                alert('Please provide an answer before continuing.');
                return;
            }

            saveResponse(response);
            currentQuestion++;
            loadQuestion();
        }

        function saveResponse(responseText) {
            const duration = Math.floor((Date.now() - questionStartTime) / 1000);
            
            fetch('<?= base_url('interview/submit_response') ?>', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({
                    interview_id: interview.id,
                    question_id: questions[currentQuestion].id,
                    response_text: responseText,
                    duration: duration
                })
            });
        }

        function completeInterview() {
            fetch('<?= base_url('interview/complete_interview') ?>', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({
                    interview_id: interview.id
                })
            });

            document.getElementById('question-screen').classList.add('hidden');
            document.getElementById('complete-screen').classList.remove('hidden');
        }

        function startTimer() {
            setInterval(() => {
                const elapsed = Math.floor((Date.now() - startTime) / 1000);
                const minutes = Math.floor(elapsed / 60);
                const seconds = elapsed % 60;
                document.getElementById('timer').textContent = 
                    `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            }, 1000);
        }
    </script>
</body>
</html>
