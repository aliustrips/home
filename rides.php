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
if (isset($_POST['add_ride'])) {
    $passenger_id = trim($_POST['passenger_id']);
    $driver_id = trim($_POST['driver_id']);
    $vehicle_id = trim($_POST['vehicle_id']);
    $start_location = trim($_POST['start_location']);
    $end_location = trim($_POST['end_location']);
    $start_time = trim($_POST['start_time']);
    $end_time = trim($_POST['end_time']);
    $status = $_POST['status'];
    $estimated_fare = trim($_POST['estimated_fare']);
    $actual_fare = trim($_POST['actual_fare']);
    $distance = trim($_POST['distance']);
    // Validate foreign keys
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
    $stmt->execute([$passenger_id]);
    if (!$stmt->fetch()) {
        $error = 'Passenger ID must exist.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM drivers WHERE driver_id = ?');
        $stmt->execute([$driver_id]);
        if (!$stmt->fetch()) {
            $error = 'Driver ID must exist.';
        } else {
            $stmt = $pdo->prepare('SELECT * FROM vehicles WHERE vehicle_id = ?');
            $stmt->execute([$vehicle_id]);
            if (!$stmt->fetch()) {
                $error = 'Vehicle ID must exist.';
            } else {
                $stmt = $pdo->prepare('INSERT INTO rides (passenger_id, driver_id, vehicle_id, start_location, end_location, start_time, end_time, status, estimated_fare, actual_fare, distance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$passenger_id, $driver_id, $vehicle_id, $start_location, $end_location, $start_time, $end_time, $status, $estimated_fare, $actual_fare, $distance]);
                $success = 'Ride added successfully!';
            }
        }
    }
}
// UPDATE
if (isset($_POST['edit_ride'])) {
    $edit_id = $_POST['edit_id'];
    $passenger_id = trim($_POST['passenger_id']);
    $driver_id = trim($_POST['driver_id']);
    $vehicle_id = trim($_POST['vehicle_id']);
    $start_location = trim($_POST['start_location']);
    $end_location = trim($_POST['end_location']);
    $start_time = trim($_POST['start_time']);
    $end_time = trim($_POST['end_time']);
    $status = $_POST['status'];
    $estimated_fare = trim($_POST['estimated_fare']);
    $actual_fare = trim($_POST['actual_fare']);
    $distance = trim($_POST['distance']);
    // Validate foreign keys
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
    $stmt->execute([$passenger_id]);
    if (!$stmt->fetch()) {
        $error = 'Passenger ID must exist.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM drivers WHERE driver_id = ?');
        $stmt->execute([$driver_id]);
        if (!$stmt->fetch()) {
            $error = 'Driver ID must exist.';
        } else {
            $stmt = $pdo->prepare('SELECT * FROM vehicles WHERE vehicle_id = ?');
            $stmt->execute([$vehicle_id]);
            if (!$stmt->fetch()) {
                $error = 'Vehicle ID must exist.';
            } else {
                $stmt = $pdo->prepare('UPDATE rides SET passenger_id=?, driver_id=?, vehicle_id=?, start_location=?, end_location=?, start_time=?, end_time=?, status=?, estimated_fare=?, actual_fare=?, distance=? WHERE ride_id=?');
                $stmt->execute([$passenger_id, $driver_id, $vehicle_id, $start_location, $end_location, $start_time, $end_time, $status, $estimated_fare, $actual_fare, $distance, $edit_id]);
                $success = 'Ride updated successfully!';
            }
        }
    }
}
// DELETE
if (isset($_POST['delete_ride'])) {
    $delete_id = $_POST['delete_id'];
    $stmt = $pdo->prepare('DELETE FROM rides WHERE ride_id = ?');
    $stmt->execute([$delete_id]);
    $success = 'Ride deleted successfully!';
}
// READ
$rides = $pdo->query('SELECT * FROM rides ORDER BY ride_id DESC')->fetchAll();
?>
<?php include 'header.php'; ?>
<div class="container" style="padding-top:120px;">
    <h2>Rides Management (Full CRUD)</h2>
    <?php if ($success): ?><div style="color:green;"><?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div style="color:red;"><?php echo $error; ?></div><?php endif; ?>
    <h3>Add Ride</h3>
    <form method="post" style="margin-bottom:30px;">
        <input type="number" name="passenger_id" placeholder="Passenger ID" required>
        <input type="number" name="driver_id" placeholder="Driver ID" required>
        <input type="number" name="vehicle_id" placeholder="Vehicle ID" required>
        <input type="text" name="start_location" placeholder="Start Location">
        <input type="text" name="end_location" placeholder="End Location">
        <input type="datetime-local" name="start_time" placeholder="Start Time">
        <input type="datetime-local" name="end_time" placeholder="End Time">
        <select name="status" required>
            <option value="requested">Requested</option>
            <option value="accepted">Accepted</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <input type="number" step="0.01" name="estimated_fare" placeholder="Estimated Fare">
        <input type="number" step="0.01" name="actual_fare" placeholder="Actual Fare">
        <input type="number" step="0.01" name="distance" placeholder="Distance">
        <button type="submit" name="add_ride">Add Ride</button>
    </form>
    <h3>All Rides</h3>
    <table border="1" cellpadding="6" style="width:100%;background:#fff;">
        <tr>
            <th>ID</th><th>Passenger</th><th>Driver</th><th>Vehicle</th><th>From</th><th>To</th><th>Start</th><th>End</th><th>Status</th><th>Est. Fare</th><th>Act. Fare</th><th>Distance</th><th>Actions</th>
        </tr>
        <?php foreach ($rides as $r): ?>
        <tr>
            <td><?php echo $r['ride_id']; ?></td>
            <td><?php echo $r['passenger_id']; ?></td>
            <td><?php echo $r['driver_id']; ?></td>
            <td><?php echo $r['vehicle_id']; ?></td>
            <td><?php echo htmlspecialchars($r['start_location']); ?></td>
            <td><?php echo htmlspecialchars($r['end_location']); ?></td>
            <td><?php echo htmlspecialchars($r['start_time']); ?></td>
            <td><?php echo htmlspecialchars($r['end_time']); ?></td>
            <td><?php echo htmlspecialchars($r['status']); ?></td>
            <td><?php echo $r['estimated_fare']; ?></td>
            <td><?php echo $r['actual_fare']; ?></td>
            <td><?php echo $r['distance']; ?></td>
            <td>
                <button type="button" onclick="showEditForm(<?php echo $r['ride_id']; ?>, <?php echo $r['passenger_id']; ?>, <?php echo $r['driver_id']; ?>, <?php echo $r['vehicle_id']; ?>, '<?php echo htmlspecialchars($r['start_location'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($r['end_location'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($r['start_time'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($r['end_time'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($r['status'], ENT_QUOTES); ?>', <?php echo $r['estimated_fare']; ?>, <?php echo $r['actual_fare']; ?>, <?php echo $r['distance']; ?>)">Edit</button>
                <form method="post" style="display:inline;" onsubmit="return confirm('Delete this ride?');">
                    <input type="hidden" name="delete_id" value="<?php echo $r['ride_id']; ?>">
                    <button type="submit" name="delete_ride">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div id="editRideModal" style="display:none;padding:20px;background:#f9f9f9;border:1px solid #ccc;margin-top:30px;">
        <h3>Edit Ride</h3>
        <form method="post">
            <input type="hidden" name="edit_id" id="edit_id">
            <input type="number" name="passenger_id" id="edit_passenger_id" placeholder="Passenger ID" required>
            <input type="number" name="driver_id" id="edit_driver_id" placeholder="Driver ID" required>
            <input type="number" name="vehicle_id" id="edit_vehicle_id" placeholder="Vehicle ID" required>
            <input type="text" name="start_location" id="edit_start_location" placeholder="Start Location">
            <input type="text" name="end_location" id="edit_end_location" placeholder="End Location">
            <input type="datetime-local" name="start_time" id="edit_start_time" placeholder="Start Time">
            <input type="datetime-local" name="end_time" id="edit_end_time" placeholder="End Time">
            <select name="status" id="edit_status" required>
                <option value="requested">Requested</option>
                <option value="accepted">Accepted</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <input type="number" step="0.01" name="estimated_fare" id="edit_estimated_fare" placeholder="Estimated Fare">
            <input type="number" step="0.01" name="actual_fare" id="edit_actual_fare" placeholder="Actual Fare">
            <input type="number" step="0.01" name="distance" id="edit_distance" placeholder="Distance">
            <button type="submit" name="edit_ride">Update Ride</button>
            <button type="button" onclick="document.getElementById('editRideModal').style.display='none';">Cancel</button>
        </form>
    </div>
</div>
<script>
function showEditForm(id, passenger_id, driver_id, vehicle_id, start_location, end_location, start_time, end_time, status, estimated_fare, actual_fare, distance) {
    document.getElementById('editRideModal').style.display = 'block';
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_passenger_id').value = passenger_id;
    document.getElementById('edit_driver_id').value = driver_id;
    document.getElementById('edit_vehicle_id').value = vehicle_id;
    document.getElementById('edit_start_location').value = start_location;
    document.getElementById('edit_end_location').value = end_location;
    document.getElementById('edit_start_time').value = start_time.replace(' ', 'T');
    document.getElementById('edit_end_time').value = end_time.replace(' ', 'T');
    document.getElementById('edit_status').value = status;
    document.getElementById('edit_estimated_fare').value = estimated_fare;
    document.getElementById('edit_actual_fare').value = actual_fare;
    document.getElementById('edit_distance').value = distance;
    window.scrollTo(0, document.body.scrollHeight);
}
</script>
<?php include 'footer.php'; ?> 