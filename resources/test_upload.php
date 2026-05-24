<!DOCTYPE html>
<html>
<head>
    <title>Upload Test</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .result { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .info { background: #d1ecf1; color: #0c5460; }
    </style>
</head>
<body>
    <h1>Upload Test Page</h1>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_file'])) {
        echo '<div class="result info"><strong>Upload Attempt Detected</strong></div>';
        
        // Display file information
        echo '<div class="result info">';
        echo '<strong>File Information:</strong><br>';
        echo 'Name: ' . htmlspecialchars($_FILES['test_file']['name']) . '<br>';
        echo 'Type: ' . htmlspecialchars($_FILES['test_file']['type']) . '<br>';
        echo 'Size: ' . number_format($_FILES['test_file']['size'] / 1024, 2) . ' KB<br>';
        echo 'Temp: ' . htmlspecialchars($_FILES['test_file']['tmp_name']) . '<br>';
        echo 'Error: ' . $_FILES['test_file']['error'] . '<br>';
        echo '</div>';
        
        // Check upload directory
        $upload_dir = './uploads/candidate_documents/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
            echo '<div class="result success">Created upload directory: ' . $upload_dir . '</div>';
        } else {
            echo '<div class="result success">Upload directory exists: ' . $upload_dir . '</div>';
        }
        
        // Check if writable
        if (is_writable($upload_dir)) {
            echo '<div class="result success">Upload directory is writable</div>';
        } else {
            echo '<div class="result error">Upload directory is NOT writable</div>';
        }
        
        // Get file extension
        $file_ext = strtolower(pathinfo($_FILES['test_file']['name'], PATHINFO_EXTENSION));
        echo '<div class="result info">File extension: ' . $file_ext . '</div>';
        
        // Check if extension is allowed
        $allowed = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'txt');
        if (in_array($file_ext, $allowed)) {
            echo '<div class="result success">File extension is allowed</div>';
            
            // Try to move file
            $new_filename = 'test_' . time() . '.' . $file_ext;
            $destination = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['test_file']['tmp_name'], $destination)) {
                echo '<div class="result success"><strong>SUCCESS!</strong> File uploaded to: ' . $destination . '</div>';
                echo '<div class="result info">File size on disk: ' . number_format(filesize($destination) / 1024, 2) . ' KB</div>';
            } else {
                echo '<div class="result error"><strong>FAILED!</strong> Could not move uploaded file</div>';
            }
        } else {
            echo '<div class="result error">File extension NOT allowed. Allowed: ' . implode(', ', $allowed) . '</div>';
        }
    }
    ?>
    
    <h2>Test File Upload</h2>
    <form method="post" enctype="multipart/form-data">
        <p>
            <label>Select File (PDF, DOC, DOCX, JPG, PNG, TXT):</label><br>
            <input type="file" name="test_file" required>
        </p>
        <p>
            <button type="submit">Upload Test File</button>
        </p>
    </form>
    
    <hr>
    
    <h2>System Information</h2>
    <div class="result info">
        <strong>PHP Version:</strong> <?php echo phpversion(); ?><br>
        <strong>Upload Max Filesize:</strong> <?php echo ini_get('upload_max_filesize'); ?><br>
        <strong>Post Max Size:</strong> <?php echo ini_get('post_max_size'); ?><br>
        <strong>Max Execution Time:</strong> <?php echo ini_get('max_execution_time'); ?> seconds<br>
        <strong>File Uploads:</strong> <?php echo ini_get('file_uploads') ? 'Enabled' : 'Disabled'; ?><br>
    </div>
    
    <h2>Existing Files</h2>
    <div class="result info">
        <?php
        $upload_dir = './uploads/candidate_documents/';
        if (is_dir($upload_dir)) {
            $files = scandir($upload_dir);
            $files = array_diff($files, array('.', '..'));
            if (count($files) > 0) {
                echo '<strong>Files in upload directory:</strong><br>';
                foreach ($files as $file) {
                    $size = filesize($upload_dir . $file);
                    echo '- ' . htmlspecialchars($file) . ' (' . number_format($size / 1024, 2) . ' KB)<br>';
                }
            } else {
                echo 'No files in upload directory';
            }
        } else {
            echo 'Upload directory does not exist';
        }
        ?>
    </div>
    
    <p><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Refresh Page</a></p>
</body>
</html>
