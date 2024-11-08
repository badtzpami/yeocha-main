<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        .container-materials {
            display: flex;
            flex-direction: column;
        }

        .row-materials {
            margin-bottom: 20px;
        }

        .product-table {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .material-cards {
            display: flex;
            gap: 10px;
        }

        .card-row {
            background: white;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-row img {
            max-width: 100%;
            height: auto;
        }

        .material-name {
            margin-top: 10px;
            font-weight: bold;
        }

        .card-row.active {
            border: 2px solid #007bff;
            box-shadow: 0 4px 20px rgba(0, 123, 255, 0.5);
        }
    </style>
    <title>Material Selection</title>
</head>

<body>
    <div class="container-materials">
        <div class="row-materials">
            <div class="product-table">
                <h2>Selected Products</h2>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Material Name</th>
                            <th>Enter Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="selected-products">
                        <!-- Selected products will appear here -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="material-cards">
                <h2>Available Materials</h2>
                <div class="card-row" data-name="Material 1">
                    <img src="https://via.placeholder.com/100" alt="Material 1" id="Material 1">
                    <div class="material-name">Material 1</div>
                </div>
                <div class="card-row" data-name="Material 2">
                    <img src="https://via.placeholder.com/100" alt="Material 2" id="Material 2">
                    <div class="material-name">Material 2</div>
                </div>
                <div class="card-row" data-name="Material 3">
                    <img src="https://via.placeholder.com/100" alt="Material 3" id="Material 3">
                    <div class="material-name">Material 3</div>
                </div>
                <div class="card-row" data-name="Material 4">
                    <img src="https://via.placeholder.com/100" alt="Material 4" id="Material 4">
                    <div class="material-name">Material 4</div>
                </div>
                <div class="card-row" data-name="Material 5">
                    <img src="https://via.placeholder.com/100" alt="Material 5" id="Material 5">
                    <div class="material-name">Material 5</div>
                </div>
                <div class="card-row" data-name="Material 6">
                    <img src="https://via.placeholder.com/100" alt="Material 6" id="Material 6">
                    <div class="material-name">Material 6</div>
                </div>
                <div class="card-row" data-name="Material 7">
                    <img src="https://via.placeholder.com/100" alt="Material 7" id="Material 7">
                    <div class="material-name">Material 7</div>
                </div>
                <div class="card-row" data-name="Material 8">
                    <img src="https://via.placeholder.com/100" alt="Material 8" id="Material 8">
                    <div class="material-name">Material 8</div>
                </div>
                <div class="card-row" data-name="Material 9">
                    <img src="https://via.placeholder.com/100" alt="Material 9" id="Material 9">
                    <div class="material-name">Material 9</div>
                </div>
                <div class="card-row" data-name="Material 10">
                    <img src="https://via.placeholder.com/100" alt="Material 10" id="Material 10">
                    <div class="material-name">Material 10</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="reset-button">
                <button id="reset-button">Reset Selection</button>
            </div>
        </div>
    </div>

    <script>
        const selectedProducts = document.getElementById('selected-products');
        const materialCount = {};
        const totalMaterials = ['Material 1', 'Material 2', 'Material 3',
            'Material 4', 'Material 5', 'Material 6',
            'Material 7', 'Material 8', 'Material 9', 'Material 10'
        ];

        document.querySelectorAll('.card-row').forEach(card => {
            card.addEventListener('click', function() {
                const materialName = this.getAttribute('data-name');
                const rowCount = selectedProducts.children.length + 1;

                // Increment the count for this material
                materialCount[materialName] = (materialCount[materialName] || 0) + 1;

                // Only add 'active' class if it's not already active
                if (!this.classList.contains('active')) {
                    this.classList.add('active');
                }

                const existingRow = Array.from(selectedProducts.children).find(row =>
                    row.querySelector('.material_name').innerText === materialName
                );

                if (existingRow) {
                    // If it exists, update the stock quantity
                    const stockCell = existingRow.querySelector('.enter_stock');
                    stockCell.innerText = materialCount[materialName];
                } else {
                    // If it doesn't exist, create a new row
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td class="h6">${rowCount}</td>
                        <td class="input material_name" contenteditable="true">${materialName}</td>
                        <td class="input enter_stock">${materialCount[materialName]}</td>
                        <td><button class="remove-btn">Remove</button></td>
                    `;
                    selectedProducts.appendChild(newRow);

                    const removeButton = newRow.querySelector('.remove-btn');
                    removeButton.addEventListener('click', function() {
                        selectedProducts.removeChild(newRow);
                        updateRowNumbers();
                        materialCount[materialName]--;
                        if (materialCount[materialName] >= 0) {
                            delete materialCount[materialName];
                            const cardToRemove = Array.from(document.querySelectorAll('.card-row')).find(c => c.getAttribute('data-name') === materialName);
                            cardToRemove.classList.remove('active');
                        }
                    });
                }

                if (Object.keys(materialCount).length === totalMaterials.length) {
                    document.querySelectorAll('.card-row').forEach(c => c.classList.add('active'));
                }
            });
        });

        document.getElementById('reset-button').addEventListener('click', function() {
            selectedProducts.innerHTML = '';
            for (const material in materialCount) {
                delete materialCount[material];
            }
            document.querySelectorAll('.card-row').forEach(card => {
                card.classList.remove('active');
            });
        });

        function updateRowNumbers() {
            Array.from(selectedProducts.children).forEach((row, index) => {
                row.querySelector('.h6').innerText = index + 1;
            });
        }
    </script>
</body>

</html>
