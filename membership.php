<?php 
// Include the header section
include 'header.php'; 

// Start session and check if admin is logged in
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar Section -->
        <div class="col-lg-2">
            <?php include 'sidebar.php'; ?>
        </div>

        <?php
        // Connect to database and fetch membership plans
        include 'db.php';
        $stmt = $pdo->prepare("SELECT * FROM membership_plans ORDER BY id ASC");
        $stmt->execute();
        $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <!-- Main Content Section -->
        <div class="col-lg-10">
            <h2 class="mb-4">⭐ Membership Plans Dashboard</h2>
            <section>
                <div class="row">
                    <!-- Display each membership plan in a card -->
                    <?php foreach ($plans as $plan): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header text-center fw-bold">
                                    <?php echo $plan['name']; ?>
                                </div>
                                <div class="card-body text-center">
                                   <h3>₹<?php echo number_format($plan['price'], 2); ?></h3>
                                    <p><?php echo $plan['description']; ?></p>
                                    <!-- Edit button triggers modal -->
                                    <button class="btn btn-primary edit-plan-btn" data-id="<?php echo $plan['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($plan['name']); ?>"
                                        data-price="<?php echo $plan['price']; ?>"
                                        data-description="<?php echo htmlspecialchars($plan['description']); ?>"
                                        data-bs-toggle="modal" data-bs-target="#editPlanModal">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Edit Membership Plan Modal -->
<section>
    <div class="modal fade" id="editPlanModal" tabindex="-1" aria-labelledby="editPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editPlanForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPlanModalLabel">Edit Membership Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden field to store plan ID -->
                        <input type="hidden" name="plan_id" id="plan_id">
                        <div class="mb-3">
                            <label class="form-label">Plan Name</label>
                            <input type="text" class="form-control" name="name" id="plan_name" required>
                        </div>
                        <div class="mb-3">
                           <label class="form-label">Price (₹)</label>
                            <input type="number" class="form-control" name="price" id="plan_price" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="plan_description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Fill modal fields with plan data when edit button is clicked
    document.querySelectorAll('.edit-plan-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('plan_id').value = this.dataset.id;
            document.getElementById('plan_name').value = this.dataset.name;
            document.getElementById('plan_price').value = this.dataset.price;
            document.getElementById('plan_description').value = this.dataset.description;
        });
    });

    // Handle form submission via AJAX
    document.getElementById('editPlanForm').addEventListener('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        fetch('update_membership.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status == 'success') {
                alert('Plan updated successfully!');
                location.reload(); // Reload page to see updated plans
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(err => console.error(err));
    });

});
</script>

<?php 
// Include the footer section
include 'footer.php'; 
?>