<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Test Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .test-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #333; }
        .status { 
            padding: 15px; 
            border-radius: 5px; 
            margin: 20px 0;
        }
        .status.success { background: #d4edda; color: #155724; }
        .status.info { background: #d1ecf1; color: #0c5460; }
        .test-questions {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .test-questions h3 { margin-top: 0; }
        .test-questions ul { margin: 10px 0; }
        .test-questions li { margin: 8px 0; }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="test-card">
        <h1>🤖 AI Chatbot Test Page</h1>
        
        <div class="status success">
            ✅ Chatbot widget is loaded! Look for the chat button in the bottom-right corner.
        </div>

        <div class="status info">
            <strong>📋 Setup Checklist:</strong><br>
            1. Database tables created? (Run <code>Database/chatbot_schema.sql</code>)<br>
            2. API key configured? (Edit <code>application/config/chatbot.php</code>)<br>
            3. Chat button visible? (Check bottom-right corner)<br>
        </div>

        <div class="test-questions">
            <h3>💬 Test Questions to Try:</h3>
            <ul>
                <li>"What job openings do you have?"</li>
                <li>"How do I apply for a position?"</li>
                <li>"Tell me about the interview process"</li>
                <li>"What benefits does the company offer?"</li>
                <li>"How long does hiring take?"</li>
                <li>"What documents do I need?"</li>
            </ul>
        </div>

        <h3>🔧 Configuration</h3>
        <p>Current settings from <code>application/config/chatbot.php</code>:</p>
        <?php
        $this->config->load('chatbot', TRUE);
        $config = $this->config->item('chatbot');
        ?>
        <ul>
            <li><strong>Provider:</strong> <?php echo $config['provider'] ?? 'Not set'; ?></li>
            <li><strong>Model:</strong> <?php echo $config['model'] ?? 'Not set'; ?></li>
            <li><strong>API Key:</strong> <?php echo !empty($config['api_key']) && $config['api_key'] !== 'YOUR_API_KEY_HERE' ? '✅ Configured' : '❌ Not configured'; ?></li>
            <li><strong>Widget Position:</strong> <?php echo $config['widget_position'] ?? 'bottom-right'; ?></li>
            <li><strong>Widget Color:</strong> <span style="display:inline-block;width:20px;height:20px;background:<?php echo $config['widget_color'] ?? '#007bff'; ?>;border-radius:3px;vertical-align:middle;"></span> <?php echo $config['widget_color'] ?? '#007bff'; ?></li>
        </ul>

        <h3>📊 Quick Stats</h3>
        <?php
        $this->load->model('Chatbot_model');
        $this->db->select('COUNT(*) as total');
        $total_sessions = $this->db->get('chat_sessions')->row()->total ?? 0;
        $total_messages = $this->db->get('chat_messages')->row()->total ?? 0;
        ?>
        <ul>
            <li><strong>Total Chat Sessions:</strong> <?php echo $total_sessions; ?></li>
            <li><strong>Total Messages:</strong> <?php echo $total_messages; ?></li>
        </ul>

        <h3>🔗 Admin Panel</h3>
        <p>View all chat logs: <a href="<?php echo base_url('admin_chatbot'); ?>">Admin Chatbot Dashboard</a> (Admin login required)</p>

        <hr style="margin: 30px 0;">

        <h3>📖 Documentation</h3>
        <ul>
            <li><a href="<?php echo base_url('CHATBOT_SETUP_GUIDE.md'); ?>">Complete Setup Guide</a></li>
            <li><a href="<?php echo base_url('CHATBOT_INTEGRATION_EXAMPLE.md'); ?>">Integration Examples</a></li>
        </ul>

        <h3>🐛 Troubleshooting</h3>
        <p>If the chat button doesn't appear:</p>
        <ol>
            <li>Open browser console (F12) and check for errors</li>
            <li>Verify <code>Assets/js/chatbot.js</code> is loaded</li>
            <li>Clear browser cache and reload</li>
        </ol>

        <p>If you get API errors:</p>
        <ol>
            <li>Check your API key in <code>application/config/chatbot.php</code></li>
            <li>Verify the key is valid at <a href="https://platform.openai.com/api-keys" target="_blank">OpenAI Dashboard</a></li>
            <li>Check <code>application/logs/</code> for detailed error messages</li>
        </ol>
    </div>

    <!-- Load the chatbot widget -->
    <?php $this->load->view('chatbot_widget'); ?>
</body>
</html>
