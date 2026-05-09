<?php
include 'db.php';

// Get search query
$query = $_GET['query'] ?? '';

try {

    if (!empty($query)) {
        // Search members
        $stmt = $pdo->prepare("
            SELECT id, name, email, status 
            FROM members 
            WHERE name LIKE :query 
               OR email LIKE :query 
               OR status LIKE :query
            ORDER BY id DESC
        ");
        $stmt->execute(['query' => "%$query%"]);
    } else {
        // Fetch latest 5 members (default)
        $stmt = $pdo->prepare("
            SELECT id, name, email, status 
            FROM members 
            ORDER BY id DESC 
            LIMIT 5
        ");
        $stmt->execute();
    }

    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($members) {
        foreach ($members as $row) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>
                        <span class='badge " . 
                            ($row['status'] == 'active' ? 'bg-success' : 'bg-danger') . 
                        "'>
                            " . htmlspecialchars($row['status']) . "
                        </span>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4' class='text-center'>No members found</td></tr>";
    }

} catch (PDOException $e) {
    echo "<tr><td colspan='4'>Error: " . $e->getMessage() . "</td></tr>";
}
?>