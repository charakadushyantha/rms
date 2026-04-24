<?php
/**
 * Quick admin lookup — run once then delete.
 * Visit: http://localhost/rms/check_admin.php
 */
require_once __DIR__ . '/application/config/environment.php';

$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die('<p style="color:red">DB connection failed: ' . $conn->connect_error . '</p>');
}

$result = $conn->query(
    "SELECT u_id, u_username, u_email, u_role, u_status FROM users ORDER BY u_id ASC"
);
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Lookup</title>
<style>
  body { font-family: Arial, sans-serif; max-width: 900px; margin: 40px auto; padding: 20px; }
  table { width: 100%; border-collapse: collapse; }
  th { background: #667eea; color: white; padding: 10px 14px; text-align: left; }
  td { padding: 9px 14px; border-bottom: 1px solid #eee; }
  tr:hover td { background: #f5f5ff; }
  .admin { background: #fff3e0; font-weight: bold; }
  .active { color: #2e7d32; }
  .inactive { color: #c33; }
  .note { margin-top: 20px; padding: 12px; background: #fff3cd; border-radius: 6px; font-size: 13px; }
</style>
</head>
<body>
<h2>All Users in Database</h2>
<table>
  <tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th></tr>
  <?php while ($row = $result->fetch_assoc()): ?>
  <tr class="<?= $row['u_role'] === 'Admin' ? 'admin' : '' ?>">
    <td><?= $row['u_id'] ?></td>
    <td><?= htmlspecialchars($row['u_username']) ?></td>
    <td><?= htmlspecialchars($row['u_email']) ?></td>
    <td><?= htmlspecialchars($row['u_role']) ?></td>
    <td class="<?= $row['u_status'] === 'Active' || $row['u_status'] === '1' ? 'active' : 'inactive' ?>">
      <?= htmlspecialchars($row['u_status']) ?>
    </td>
  </tr>
  <?php endwhile; ?>
</table>
<div class="note">⚠️ Delete this file after use: <code>check_admin.php</code></div>
</body>
</html>
<?php $conn->close(); ?>
