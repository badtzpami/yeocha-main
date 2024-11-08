<?php // Fetch users (shops) and their materials
$users = [];
$userQuery = $conn->query("SELECT user_id, store FROM users");
while ($userRow = $userQuery->fetch_assoc()) {
    // Fetch materials for each user
    $materialQuery = $conn->query("SELECT * FROM supplier_material WHERE user_id = {$userRow['user_id']}");

    $materials = [];
    while ($materialRow = $materialQuery->fetch_assoc()) {
        $material_name = strtolower(str_replace(' ', '', $materialRow['material_name']));
        $materials[] = [
            'name' => $materialRow['material_name'],
            'type' => $materialRow['type'],
            'stock' => $materialRow['stock'],
            'enter_stock' => $materialRow['enter_stock'],
            'selling_price' => $materialRow['selling_price'],
            'unit' => $materialRow['unit'],
            'image' => $materialRow['image']
        ];
    }

    $users[$userRow['store']] = $materials; // Associate materials with user (shop)
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User's Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            margin-top: 20px;
        }

        .materials {
            display: none;
            margin-top: 10px;
        }

        .chevron-icon {
            justify-content: right;
            right: 0;
            transition: transform 0.3s;
        }

        .chevron-title {
            justify-content: left;
            margin-left: 10px;
            left: 0;
            transition: transform 0.3s;
        }

        .card-products {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        div.collapse {
            width: 100%;
            height: 55px;
            padding: 10px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
        }

        .checkbox-container input {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-1">
        <?php foreach ($users as $username => $materials): ?>
            <div class="card mb-3">
                <div class="card-header" id="heading<?= htmlspecialchars($username) ?>">
                    <?php if (!empty($materials)): ?>
                        <!-- Checkbox for selecting all items in the shop -->
                        <div class="checkbox-container">
                            <input type="checkbox" id="selectAll<?= htmlspecialchars($username) ?>" onclick="toggleAllCheckboxes('<?= htmlspecialchars($username) ?>')" />
                        </div>
                    <?php endif; ?>
                    <h5 class="mb-0">
                        <button class="btn btn-link card-products" onclick="toggleMaterials('<?= htmlspecialchars($username) ?>')">
                            <span class="chevron-title"><?= htmlspecialchars($username) ?>'s Shop</span>
                            <span class="chevron-icon" id="icon<?= htmlspecialchars($username) ?>"><i class="fas fa-chevron-down"></i></span>
                        </button>
                    </h5>
                </div>
                <div id="<?= $username ?>Materials" class="collapse">
                    <div class="card-body">
                        <?php if (!empty($materials)): ?>
                            <?php foreach ($materials as $material): ?>
                                <div class="card mb-2">
                                    <div class="card-body card-products">
                                        <!-- Checkbox for selecting the material -->
                                        <div class="checkbox-container">
                                            <input type="checkbox" class="material-checkbox" id="material_<?= htmlspecialchars($material['name']) ?>" name="materials[]" value="<?= htmlspecialchars($material['name']) ?>" onclick="updateSelectAllCheckboxState('<?= htmlspecialchars($username) ?>')" />
                                        </div>
                                        <span class="chevron-title"><?= htmlspecialchars($material['name']) ?></span>

                                        <?php if (empty($material['image'])) { ?>
                                            <img src="../assets/images/default_images/tea.jpeg" width=80 height=80 title="default_image">
                                        <?php } else { ?>
                                            <img src="../assets/images/material_images/<?= $material['image']; ?>" width=80 height=80 title="<?= $material['name']; ?>">
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No materials available for this shop.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        // Function to toggle the collapse/expand of materials
        function toggleMaterials(shop) {
            const materialsDiv = document.getElementById(`${shop}Materials`);
            const icon = document.getElementById(`icon${shop}`);
            const isOpen = materialsDiv.classList.contains('show');
            materialsDiv.classList.toggle('collapse', isOpen);
            materialsDiv.classList.toggle('show', !isOpen);
            icon.innerHTML = isOpen ? '<i class="fas fa-chevron-down"></i>' : '<i class="fas fa-chevron-up"></i>';
        }

        // Function to toggle all checkboxes inside a shop
        function toggleAllCheckboxes(shop) {
            const selectAllCheckbox = document.getElementById(`selectAll${shop}`);
            const materialCheckboxes = document.querySelectorAll(`#${shop}Materials .material-checkbox`);

            // Set all checkboxes to the state of the "select all" checkbox
            materialCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }

        // Function to update the "Select All" checkbox state based on the individual checkboxes
        function updateSelectAllCheckboxState(shop) {
            const selectAllCheckbox = document.getElementById(`selectAll${shop}`);
            const materialCheckboxes = document.querySelectorAll(`#${shop}Materials .material-checkbox`);

            // If all material checkboxes are checked, mark the "Select All" checkbox as checked
            selectAllCheckbox.checked = Array.from(materialCheckboxes).every(checkbox => checkbox.checked);
        }

        // Ensure the "Select All" checkbox reflects the state of individual checkboxes
        document.addEventListener('change', function(event) {
            // Check if the target is a material checkbox
            if (event.target.classList.contains('material-checkbox')) {
                // Get the closest shop container (collapse section)
                const collapseDiv = event.target.closest('.collapse');

                // Get the shop name (ID of the collapse div without 'Materials' part)
                const shop = collapseDiv.id.replace('Materials', '');

                // Update the "Select All" checkbox state
                updateSelectAllCheckboxState(shop);
            }
        });
    </script>
</body>

</html>
