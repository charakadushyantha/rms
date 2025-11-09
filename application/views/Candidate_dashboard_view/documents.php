<?php
$data['page_title'] = 'My Documents';
$this->load->view('templates/candidate_header', $data);
?>

<style>
.documents-container {
    padding: 2rem;
}

.documents-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.upload-section {
    background: #f9fafb;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    border: 2px dashed #14b8a6;
}

.document-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.document-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.document-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.btn-upload {
    background: #14b8a6;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}
</style>

<div class="documents-container">
    <div class="documents-card">
        <h1><i class="fas fa-file-alt me-2"></i>My Documents</h1>
        
        <div class="upload-section">
            <h3>Upload New Document</h3>
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="mb-3">
                    <select class="form-select" name="document_type" required>
                        <option value="">Select Type</option>
                        <option value="resume">Resume</option>
                        <option value="cover_letter">Cover Letter</option>
                        <option value="certificate">Certificate</option>
                        <option value="portfolio">Portfolio</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="file" class="form-control" name="document" required>
                </div>
                <button type="submit" class="btn-upload">
                    <i class="fas fa-upload me-2"></i>Upload Document
                </button>
            </form>
        </div>

        <h3>My Documents</h3>
        <?php if (!empty($documents)): ?>
            <?php foreach ($documents as $doc): ?>
                <div class="document-item">
                    <div class="document-info">
                        <div class="document-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <div class="fw-bold"><?php echo htmlspecialchars($doc['file_name']); ?></div>
                            <small class="text-muted">
                                <?php echo ucfirst($doc['document_type']); ?> • 
                                Uploaded <?php echo date('M d, Y', strtotime($doc['uploaded_at'])); ?>
                            </small>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-danger" onclick="deleteDocument(<?php echo $doc['id']; ?>)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">No documents uploaded yet</p>
        <?php endif; ?>
    </div>
</div>

<?php
$custom_script = "
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('" . base_url('C_dashboard/upload_document') . "', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Success!', data.message, 'success').then(() => location.reload());
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    });
});

function deleteDocument(id) {
    Swal.fire({
        title: 'Delete Document?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('" . base_url('C_dashboard/delete_document') . "', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'document_id=' + id
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', data.message, 'success').then(() => location.reload());
                }
            });
        }
    });
}
";

$data['custom_script'] = $custom_script;
$this->load->view('templates/candidate_footer', $data);
?>
