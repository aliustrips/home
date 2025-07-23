<?php
session_start();
require_once 'includes/db.php';
// Only allow admin
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}
$user_stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
$user_stmt->execute([$_SESSION['user_id']]);
$current_user = $user_stmt->fetch();
if (!$current_user || $current_user['role'] !== 'admin') {
    header('Location: home.php');
    exit;
}
$success = '';
$error = '';
// CREATE
if (isset($_POST['add_driver'])) {
    $user_id = trim($_POST['user_id']);
    $license_number = trim($_POST['license_number']);
    $license_expiry = trim($_POST['license_expiry']);
    $total_rides = trim($_POST['total_rides']);
    $rating = trim($_POST['rating']);
    $is_approved = isset($_POST['is_approved']) ? 1 : 0;
    // Validate user_id exists and is driver
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ? AND role = "driver"');
    $stmt->execute([$user_id]);
    if (!$stmt->fetch()) {
        $error = 'User ID must exist and be a driver.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO drivers (user_id, license_number, license_expiry, total_rides, rating, is_approved) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$user_id, $license_number, $license_expiry, $total_rides, $rating, $is_approved]);
        $success = 'Driver added successfully!';
    }
}
// UPDATE
if (isset($_POST['edit_driver'])) {
    $edit_id = $_POST['edit_id'];
    $user_id = trim($_POST['user_id']);
    $license_number = trim($_POST['license_number']);
    $license_expiry = trim($_POST['license_expiry']);
    $total_rides = trim($_POST['total_rides']);
    $rating = trim($_POST['rating']);
    $is_approved = isset($_POST['is_approved']) ? 1 : 0;
    // Validate user_id exists and is driver
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ? AND role = "driver"');
    $stmt->execute([$user_id]);
    if (!$stmt->fetch()) {
        $error = 'User ID must exist and be a driver.';
    } else {
        $stmt = $pdo->prepare('UPDATE drivers SET user_id=?, license_number=?, license_expiry=?, total_rides=?, rating=?, is_approved=? WHERE driver_id=?');
        $stmt->execute([$user_id, $license_number, $license_expiry, $total_rides, $rating, $is_approved, $edit_id]);
        $success = 'Driver updated successfully!';
    }
}
// DELETE
if (isset($_POST['delete_driver'])) {
    $delete_id = $_POST['delete_id'];
    $stmt = $pdo->prepare('DELETE FROM drivers WHERE driver_id = ?');
    $stmt->execute([$delete_id]);
    $success = 'Driver deleted successfully!';
}
// READ
$drivers = $pdo->query('SELECT * FROM drivers ORDER BY driver_id DESC')->fetchAll();
?>
<?php include 'header.php'; ?>
<div class="container" style="padding-top:120px;">
    <h2>Drivers Management (Full CRUD)</h2>
    <?php if ($success): ?><div style="color:green;"><?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div style="color:red;"><?php echo $error; ?></div><?php endif; ?>
    <h3>Add Driver</h3>
    <form method="post" style="margin-bottom:30px;">
        <input type="number" name="user_id" placeholder="User ID (driver)" required>
        <input type="text" name="license_number" placeholder="License Number">
        <input type="date" name="license_expiry" placeholder="License Expiry">
        <input type="number" name="total_rides" placeholder="Total Rides" value="0">
        <input type="number" step="0.01" name="rating" placeholder="Rating">
        <label><input type="checkbox" name="is_approved"> Approved</label>
        <button type="submit" name="add_driver">Add Driver</button>
    </form>
    <h3>All Drivers</h3>
    <table border="1" cellpadding="6" style="width:100%;background:#fff;">
        <tr>
            <th>ID</th><th>User ID</th><th>License #</th><th>Expiry</th><th>Total Rides</th><th>Rating</th><th>Approved</th><th>Actions</th>
        </tr>
        <?php foreach ($drivers as $d): ?>
        <tr>
            <td><?php echo $d['driver_id']; ?></td>
            <td><?php echo $d['user_id']; ?></td>
            <td><?php echo htmlspecialchars($d['license_number']); ?></td>
            <td><?php echo htmlspecialchars($d['license_expiry']); ?></td>
            <td><?php echo $d['total_rides']; ?></td>
            <td><?php echo $d['rating']; ?></td>
            <td><?php echo $d['is_approved'] ? 'Yes' : 'No'; ?></td>
            <td>
                <button type="button" onclick="showEditForm(<?php echo $d['driver_id']; ?>, <?php echo $d['user_id']; ?>, '<?php echo htmlspecialchars($d['license_number'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($d['license_expiry'], ENT_QUOTES); ?>', <?php echo $d['total_rides']; ?>, <?php echo $d['rating'] ? $d['rating'] : 0; ?>, <?php echo $d['is_approved'] ? 1 : 0; ?>)">Edit</button>
                <form method="post" style="display:inline;" onsubmit="return confirm('Delete this driver?');">
                    <input type="hidden" name="delete_id" value="<?php echo $d['driver_id']; ?>">
                    <button type="submit" name="delete_driver">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div id="editDriverModal" style="display:none;padding:20px;background:#f9f9f9;border:1px solid #ccc;margin-top:30px;">
        <h3>Edit Driver</h3>
        <form method="post">
            <input type="hidden" name="edit_id" id="edit_id">
            <input type="number" name="user_id" id="edit_user_id" placeholder="User ID (driver)" required>
            <input type="text" name="license_number" id="edit_license_number" placeholder="License Number">
            <input type="date" name="license_expiry" id="edit_license_expiry" placeholder="License Expiry">
            <input type="number" name="total_rides" id="edit_total_rides" placeholder="Total Rides">
            <input type="number" step="0.01" name="rating" id="edit_rating" placeholder="Rating">
            <label><input type="checkbox" name="is_approved" id="edit_is_approved"> Approved</label>
            <button type="submit" name="edit_driver">Update Driver</button>
            <button type="button" onclick="document.getElementById('editDriverModal').style.display='none';">Cancel</button>
        </form>
    </div>
</div>
<script>
function showEditForm(id, user_id, license_number, license_expiry, total_rides, rating, is_approved) {
    document.getElementById('editDriverModal').style.display = 'block';
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_user_id').value = user_id;
    document.getElementById('edit_license_number').value = license_number;
    document.getElementById('edit_license_expiry').value = license_expiry;
    document.getElementById('edit_total_rides').value = total_rides;
    document.getElementById('edit_rating').value = rating;
    document.getElementById('edit_is_approved').checked = is_approved ? true : false;
    window.scrollTo(0, document.body.scrollHeight);
}
</script>
<?php include 'footer.php'; ?> 