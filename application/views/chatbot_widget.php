<!-- AI Chatbot Widget Include -->
<?php
// Load chatbot configuration
$this->config->load('chatbot', TRUE);
$chatbot_config = $this->config->item('chatbot');

// Get base URL
$base_url = isset($this->config) ? $this->config->item('base_url') : 'http://localhost/rms/';
?>

<script>
// Chatbot configuration
const chatbotConfig = {
    baseUrl: '<?php echo $base_url; ?>',
    position: '<?php echo isset($chatbot_config['widget_position']) ? $chatbot_config['widget_position'] : 'bottom-right'; ?>',
    color: '<?php echo isset($chatbot_config['widget_color']) ? $chatbot_config['widget_color'] : '#007bff'; ?>',
    title: '<?php echo isset($chatbot_config['widget_title']) ? $chatbot_config['widget_title'] : 'Recruitment Assistant'; ?>',
    welcomeMessage: '<?php echo addslashes(isset($chatbot_config['welcome_message']) ? $chatbot_config['welcome_message'] : 'Hi! How can I help you today?'); ?>'
};
</script>

<!-- Load chatbot script -->
<script src="<?php echo $base_url; ?>Assets/js/chatbot.js"></script>
