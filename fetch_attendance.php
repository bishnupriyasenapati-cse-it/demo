<?php
// Include database connection
include 'db.php';

// Get search input (member name) from POST, default = empty
$search = $_POST['search'] ?? '';

// Get selected date or use today's date by default
$date = $_POST['date'] ?? date('Y-m-d');

// Prepare SQL query
// - Fetch all members
// - LEFT JOIN attendance for the selected date
$stmt = $pdo->prepare("
    SELECT m.id AS member_id, m.name, 
           a.checkin_time, a.checkout_time
    FROM members m
    LEFT JOIN attendance a 
        ON m.id = a.member_id
        AND DATE(a.checkin_time) = ?
    WHERE m.name LIKE ?
");

// Execute query with date and search filter
$stmt->execute([$date, "%$search%"]);

// Serial number counter
$i = 1;

// 🔥 MAIN LOOP: iterate through each member record
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>

    <tr>
        <!-- Serial Number -->
        <td><?= $i++; ?></td>

        <!-- Member ID -->
        <td><?= $row['member_id']; ?></td>

        <!-- Member Name -->
        <td><?= $row['name']; ?></td>

        <!-- Check-in Time (or '-' if not available) -->
        <td><?= $row['checkin_time'] ?? '-'; ?></td>

        <!-- Attendance Status -->
        <td>
            <?php
            // If no check-in → Absent
            if (empty($row['checkin_time'])) {
                echo '<span class="badge rounded-pill bg-danger px-3 py-2">Absent</span>';

            // If check-in exists but no checkout → Active
            } elseif (empty($row['checkout_time'])) {
                echo '<span class="badge rounded-pill bg-warning text-dark px-3 py-2">Active</span>';

            // If both exist → Completed
            } else {
                echo '<span class="badge rounded-pill bg-success px-3 py-2">Completed</span>';
            }
            ?>
        </td>

        <!-- Action Buttons -->
        <td>
            <?php
            // Show Check-in button if user is absent
            if (empty($row['checkin_time'])) {
                echo '<button class="btn btn-success btn-sm rounded-pill px-3 checkinBtn" data-id="' . $row['member_id'] . '">Check-in</button>';

            // Show Check-out button if user is active
            } elseif (empty($row['checkout_time'])) {
                echo '<button class="btn btn-danger btn-sm rounded-pill px-3 checkoutBtn" data-id="' . $row['member_id'] . '">Check-out</button>';

            // No action if completed
            } else {
                echo '-';
            }
            ?>
        </td>
    </tr>

<?php
} // ✅ END LOOP
?>