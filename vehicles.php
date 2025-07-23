<?php
session_start();
require_once 'includes/db.php';
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
if (isset($_POST['add_vehicle'])) {
    $driver_id = trim($_POST['driver_id']);
    $make = trim($_POST['make']);
    $model = trim($_POST['model']);
    $year = trim($_POST['year']);
    $color = trim($_POST['color']);
    $plate_number = trim($_POST['plate_number']);
    $vehicle_type = $_POST['vehicle_type'];
    // Validate driver_id exists
    $stmt = $pdo->prepare('SELECT * FROM drivers WHERE driver_id = ?');
    $stmt->execute([$driver_id]);
    if (!$stmt->fetch()) {
        $error = 'Driver ID must exist.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO vehicles (driver_id, make, model, year, color, plate_number, vehicle_type) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$driver_id, $make, $model, $year, $color, $plate_number, $vehicle_type]);
        $success = 'Vehicle added successfully!';
    }
}
// UPDATE
if (isset($_POST['edit_vehicle'])) {
    $edit_id = $_POST['edit_id'];
    $driver_id = trim($_POST['driver_id']);
    $make = trim($_POST['make']);
    $model = trim($_POST['model']);
    $year = trim($_POST['year']);
    $color = trim($_POST['color']);
    $plate_number = trim($_POST['plate_number']);
    $vehicle_type = $_POST['vehicle_type'];
    // Validate driver_id exists
    $stmt = $pdo->prepare('SELECT * FROM drivers WHERE driver_id = ?');
    $stmt->execute([$driver_id]);
    if (!$stmt->fetch()) {
        $error = 'Driver ID must exist.';
    } else {
        $stmt = $pdo->prepare('UPDATE vehicles SET driver_id=?, make=?, model=?, year=?, color=?, plate_number=?, vehicle_type=? WHERE vehicle_id=?');
        $stmt->execute([$driver_id, $make, $model, $year, $color, $plate_number, $vehicle_type, $edit_id]);
        $success = 'Vehicle updated successfully!';
    }
}
// DELETE
if (isset($_POST['delete_vehicle'])) {
    $delete_id = $_POST['delete_id'];
    $stmt = $pdo->prepare('DELETE FROM vehicles WHERE vehicle_id = ?');
    $stmt->execute([$delete_id]);
    $success = 'Vehicle deleted successfully!';
}
// READ
$vehicles = $pdo->query('SELECT * FROM vehicles ORDER BY vehicle_id DESC')->fetchAll();
?>
<?php include 'header.php'; ?>
<div class="container" style="padding-top:120px;">
    <h2>Vehicles Management (Full CRUD)</h2>
    <?php if ($success): ?><div style="color:green;"><?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div style="color:red;"><?php echo $error; ?></div><?php endif; ?>
    <h3>Add Vehicle</h3>
    <form method="post" style="margin-bottom:30px;">
        <input type="number" name="driver_id" placeholder="Driver ID" required>
        <input type="text" name="make" placeholder="Make">
        <input type="text" name="model" placeholder="Model">
        <input type="number" name="year" placeholder="Year">
        <input type="text" name="color" placeholder="Color">
        <input type="text" name="plate_number" placeholder="Plate Number">
        <select name="vehicle_type" required>
            <option value="economy">Economy</option>
            <option value="premium">Premium</option>
            <option value="xl">XL</option>
        </select>
        <button type="submit" name="add_vehicle">Add Vehicle</button>
    </form>
    <h3>All Vehicles</h3>
    <table border="1" cellpadding="6" style="width:100%;background:#fff;">
        <tr>
            <th>ID</th><th>Driver ID</th><th>Make</th><th>Model</th><th>Year</th><th>Color</th><th>Plate</th><th>Type</th><th>Actions</th>
        </tr>
        <?php foreach ($vehicles as $v): ?>
        <tr>
            <td><?php echo $v['vehicle_id']; ?></td>
            <td><?php echo $v['driver_id']; ?></td>
            <td><?php echo htmlspecialchars($v['make']); ?></td>
            <td><?php echo htmlspecialchars($v['model']); ?></td>
            <td><?php echo $v['year']; ?></td>
            <td><?php echo htmlspecialchars($v['color']); ?></td>
            <td><?php echo htmlspecialchars($v['plate_number']); ?></td>
            <td><?php echo htmlspecialchars($v['vehicle_type']); ?></td>
            <td>
                <button type="button" onclick="showEditForm(<?php echo $v['vehicle_id']; ?>, <?php echo $v['driver_id']; ?>, '<?php echo htmlspecialchars($v['make'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($v['model'], ENT_QUOTES); ?>', <?php echo $v['year']; ?>, '<?php echo htmlspecialchars($v['color'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($v['plate_number'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($v['vehicle_type'], ENT_QUOTES); ?>')">Edit</button>
                <form method="post" style="display:inline;" onsubmit="return confirm('Delete this vehicle?');">
                    <input type="hidden" name="delete_id" value="<?php echo $v['vehicle_id']; ?>">
                    <button type="submit" name="delete_vehicle">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div id="editVehicleModal" style="display:none;padding:20px;background:#f9f9f9;border:1px solid #ccc;margin-top:30px;">
        <h3>Edit Vehicle</h3>
        <form method="post">
            <input type="hidden" name="edit_id" id="edit_id">
            <input type="number" name="driver_id" id="edit_driver_id" placeholder="Driver ID" required>
            <input type="text" name="make" id="edit_make" placeholder="Make">
            <input type="text" name="model" id="edit_model" placeholder="Model">
            <input type="number" name="year" id="edit_year" placeholder="Year">
            <input type="text" name="color" id="edit_color" placeholder="Color">
            <input type="text" name="plate_number" id="edit_plate_number" placeholder="Plate Number">
            <select name="vehicle_type" id="edit_vehicle_type" required>
                <option value="economy">Economy</option>
                <option value="premium">Premium</option>
                <option value="xl">XL</option>
            </select>
            <button type="submit" name="edit_vehicle">Update Vehicle</button>
            <button type="button" onclick="document.getElementById('editVehicleModal').style.display='none';">Cancel</button>
        </form>
    </div>
</div>
<script>
function showEditForm(id, driver_id, make, model, year, color, plate_number, vehicle_type) {
    document.getElementById('editVehicleModal').style.display = 'block';
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_driver_id').value = driver_id;
    document.getElementById('edit_make').value = make;
    document.getElementById('edit_model').value = model;
    document.getElementById('edit_year').value = year;
    document.getElementById('edit_color').value = color;
    document.getElementById('edit_plate_number').value = plate_number;
    document.getElementById('edit_vehicle_type').value = vehicle_type;
    window.scrollTo(0, document.body.scrollHeight);
}
</script>
<?php include 'footer.php'; ?> 