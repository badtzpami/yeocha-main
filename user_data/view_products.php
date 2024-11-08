<?php
// Database connection parameters
$servername = "localhost:4306"; // Adjust if needed
$username = "root"; // Your DB username
$password = ""; // Your DB password
$dbname = "yeocha_main"; // Your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch categories
$categories = [];
$categoryQuery = $conn->query("SELECT ca_id, category_name FROM category");
while ($categoryRow = $categoryQuery->fetch_assoc()) {
    // Remove spaces and convert to lowercase
    $categories[$categoryRow['ca_id']] = strtolower(str_replace(' ', '_', $categoryRow['category_name']));
}

// Fetch products and materials
$products = [];
foreach ($categories as $ca_id => $ca_name) {
    $productQuery = $conn->query("SELECT * FROM product WHERE ca_id = $ca_id");

    // If no products are found for the category
    if ($productQuery->num_rows === 0) {
        $products[$ca_name] = [
            'materials' => [],
            'no_products' => true // Mark this category as having no products
        ];
        continue; // Move to the next category
    }

    while ($productRow = $productQuery->fetch_assoc()) {
        // Remove spaces and use lowercase for product names
        $product_name = strtolower(str_replace(' ', '', $productRow['product_name']));

        // Fetch materials for this product
        $materialQuery = $conn->query("SELECT m.material_name, m.type FROM material m
            JOIN menu menu ON m.ma_id = menu.ma_id
            WHERE menu.pr_id = {$productRow['pr_id']}");

        $rawMaterials = [];
        $disposableMaterials = [];

        while ($materialRow = $materialQuery->fetch_assoc()) {
            // Remove spaces and handle material types
            $material_name = strtolower(str_replace(' ', '', $materialRow['material_name']));
            if ($materialRow['type'] == '1') { // Raw materials
                $rawMaterials[] = $material_name;
            } elseif ($materialRow['type'] == '2') { // Disposable materials
                $disposableMaterials[] = $material_name;
            }
        }

        // Organize products by category
        if (!isset($products[$ca_name])) {
            $products[$ca_name] = ['materials' => []];
        }

        $product_image = htmlspecialchars($productRow['image']); // Get the product image

        // ... existing code ...

        $products[$ca_name]['materials'][$product_name] = [
            'raw' => $rawMaterials,
            'disposable' => $disposableMaterials,
            'image' => $product_image // Add the image to the product data
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Categories</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            /* Space between chevron and text */
            transition: transform 0.3s;
            /* Smooth transition for rotation */
        }

        .chevron-title {
            justify-content: left;
            margin-left: 10px;
            left: 0;
            /* Space between chevron and text */
            transition: transform 0.3s;
            /* Smooth transition for rotation */
        }

        .card-products {
            width: 100%;

            display: flex;
            justify-content: space-between;
            /* Distributes space between title and icon */
            align-items: center;
            /* Centers items vertically */
            /* Ensures the button takes full width */
        }

        div.collapse {
            width: 100%;
            height: 55px;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-1">

        <?php foreach ($categories as $ca_id => $ca_name): ?>
            <div class="card mb-3">
                <div class="card-header" id="heading<?= htmlspecialchars($ca_name) ?>">
                    <h5 class="mb-0">
                        <button class="btn btn-link card-products" onclick="toggleProducts('<?= htmlspecialchars($ca_name) ?>')">
                            <span class="chevron-title"><?= htmlspecialchars(str_replace('_', ' ', $ca_name)) ?></span> <span class="chevron-icon" id="icon<?= htmlspecialchars($ca_name) ?>"><i class="fas fa-chevron-down"></i></span>
                        </button>
                    </h5>
                </div>
                <div id="<?= $ca_name ?>Products" class="collapse">
                    <div class="card-body">
                        <?php if (isset($products[$ca_name]) && !empty($products[$ca_name]['materials'])): ?>
                            <?php foreach ($products[$ca_name]['materials'] as $product_name => $materials): ?>
                                <div class="card mb-2" onclick="showMaterials('<?= $ca_name ?>', '<?= htmlspecialchars($product_name) ?>')">
                                    <div class="card-body card-products">
                                        <span class="chevron-title"><?= htmlspecialchars(str_replace('_', ' ', $product_name)) ?></span> <span class="chevron-icon" id="icon<?= htmlspecialchars($product_name) ?>"><i class="fas fa-chevron-down"></i></span>
                                        <?php
                                        if (is_array($product_image)) { ?>
                                            <?php if (empty($product_image)) { ?>
                                                <img src="../assets/images/default_images/tea.jpeg" width=150 height=150 title="yeaocha_main">
                                            <?php } else { ?>
                                                <img src="../assets/images/product_images/<?php echo $product_image; ?>" width=150 height=150 title="<?php echo $image; ?>">
                                        <?php }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="materials" id="<?= $ca_name ?>Materials<?= htmlspecialchars($product_name) ?>"></div>
                            <?php endforeach; ?>
                        <?php elseif (isset($products[$ca_name]['no_products'])): ?>
                            <p>No products available for this category.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

    <script>
        const products = <?= json_encode($products, JSON_PRETTY_PRINT) ?>;

        console.log(products); // Debug: Log the products array to see its structure

        function toggleProducts(category) {
            const productsDiv = document.getElementById(`${category}Products`);
            const icon = document.getElementById(`icon${category}`);

            if (!productsDiv || !icon) {
                console.error(`Element not found for category: ${category}`);
                return;
            }

            // Close all other open categories
            const allCategoryDivs = document.querySelectorAll('[id$="Products"]');
            allCategoryDivs.forEach(div => {
                if (div !== productsDiv) {
                    div.classList.remove('show');
                    div.classList.add('collapse');
                    const otherCategory = div.id.replace('Products', '');
                    document.getElementById(`icon${otherCategory}`).innerHTML = '<i class="fas fa-chevron-down"></i>';
                }
            });

            const isOpen = productsDiv.classList.contains('show');

            // Toggle the selected category
            productsDiv.classList.toggle('collapse', isOpen);
            productsDiv.classList.toggle('show', !isOpen);
            icon.innerHTML = isOpen ? '<i class="fas fa-chevron-down"></i>' : '<i class="fas fa-chevron-up"></i>';
        }

        function showMaterials(category, product) {
            const materialsDiv = document.getElementById(`${category}Materials${product}`);
            const materials = products[category].materials[product];

            if (!materials) {
                console.error(`Materials not found for ${category} and product ${product}`);
                return;
            }

            const icon = document.getElementById(`icon${product}`);

            if (materialsDiv) {
                if (materialsDiv.style.display === 'block') {
                    // Hide the materials and change icon to down
                    materialsDiv.style.display = 'none';
                    icon.innerHTML = '<i class="fas fa-chevron-down"></i>';
                } else {
                    // Close all other opened materials
                    const allMaterialsDivs = document.querySelectorAll('.materials');
                    allMaterialsDivs.forEach(div => {
                        div.style.display = 'none';
                    });

                    // Change icons back to down for all products
                    const allIcons = document.querySelectorAll('.chevron-icon i');
                    allIcons.forEach(i => {
                        i.classList.remove('fa-chevron-up');
                        i.classList.add('fa-chevron-down');
                    });

                    // Show materials and change icon to up
                    materialsDiv.innerHTML = `
                    <div class="row">
                <div class="col-8">
                 <strong>RAW:</strong>
                <ul>${materials.raw.map(item => `<li>${item}</li>`).join('')}</ul>
                <strong>DISPOSABLE:</strong>
                <ul>${materials.disposable.map(item => `<li>${item}</li>`).join('')}</ul>
                </div>
                <div class="col-4">
                
                    <img src="${materials.image ? '../assets/images/product_images/' + materials.image : '../assets/images/default_images/tea.jpeg'}"
                    width="150" height="150"
                    title="${materials.image ? materials.image : 'yeaocha_main'}"
                    position:absolute; 
                    display: flex;
                    flex-direction: column;
                    justify-content:right;
                    align-items:right;
                    right:0;
                    border: 3px solid #DCDCDC;
                    height: 40px;
                    width: 40px;>
                </div>
            </div>
               
            `;
                    materialsDiv.style.display = 'block';
                    icon.innerHTML = '<i class="fas fa-chevron-up"></i>';
                }
            } else {
                console.error(`Element with ID ${category}Materials${product} not found.`);
            }
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>