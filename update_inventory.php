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

        .container-inventory {
            display: flex;
            flex-direction: column;
        }

        .row-inventory {
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

        .inventory-cards {
            display: flex;
            gap: 10px;
        }

        .card-row-inventory {
            background: white;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-row-inventory img {
            max-width: 100%;
            height: auto;
        }

        .inventory-name {
            margin-top: 10px;
            font-weight: bold;
        }

        .card-row-inventory.active {
            border: 2px solid #007bff;
            box-shadow: 0 4px 20px rgba(0, 123, 255, 0.5);
        }
    </style>
    <title>inventory Selection</title>
</head>

<body>
    <div class="container-inventory">
        <div class="row-inventory">
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
                    <tbody id="selected-inventory">
                        <!-- <tr>
                            <td class="h6">1</td>
                            <td class="input inventory_name" contenteditable="true">Inventory 10</td>
                            <td class="input enter_stock_inventory">10</td>
                        </tr>
                        <tr>
                            <td class="h6">2</td>
                            <td class="input inventory_name" contenteditable="true">Inventory 9</td>
                            <td class="input enter_stock_inventory">10</td>
                        </tr> -->
                        <!-- Selected products will appear here -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row-inventory">
            <div class="inventory-cards">
                <h2>Available Materials</h2>
                <div class="card-row-inventory" data-name-inventory="Inventory 9">
                    <img src="https://via.placeholder.com/100" alt="Inventory 9" id="Inventory 9">
                    <div class="inventory-name">Inventory 9</div>
                </div>
                <div class="card-row-inventory" data-name-inventory="Inventory 10">
                    <img src="https://via.placeholder.com/100" alt="Inventory 10" id="Inventory 10">
                    <div class="inventory-name">Inventory 10</div>
                </div>
            </div>
        </div>
        
        <div class="row-inventory">
            <div class="reset-button-inventory">
                <button id="reset-button-inventory">Reset Selection</button>
            </div>
        </div>
    </div>

    <script>
        const selectedInventory = document.getElementById('selected-inventory');
        const inventoryCount = {};
        const totalInventory = ['Inventory 9', 'Inventory 10'];

        document.querySelectorAll('.card-row-inventory').forEach(card => {
            card.addEventListener('click', function() {
                const inventoryName = this.getAttribute('data-name-inventory');
                const rowCount = selectedInventory.children.length + 1;

                // Increment the count for this material
                inventoryCount[inventoryName] = (inventoryCount[inventoryName] || 0) + 1;

                // Only add 'active' class if it's not already active
                if (!this.classList.contains('active')) {
                    this.classList.add('active');
                }

                const existingRow = Array.from(selectedInventory.children).find(row =>
                    row.querySelector('.inventory_name').innerText === inventoryName
                );

                if (existingRow) {
                    // If it exists, update the stock quantity
                    const stockCell = existingRow.querySelector('.enter_stock_inventory');
                    stockCell.value = inventoryCount[inventoryName];
                } else {
                    // If it doesn't exist, create a new row
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td class="h6">${rowCount}</td>
                        <td class="input inventory_name" contenteditable="true">${inventoryName}</td>
                        <td><input type="text" name="inventory_name[]" class="input enter_stock_inventory" value="${inventoryCount[inventoryName]}"></td>
                        <td><button class="remove-btn">Remove</button></td>
                    `;
                    selectedInventory.appendChild(newRow);

                    const removeButtonInventory = newRow.querySelector('.remove-btn-inventory');
                    removeButtonInventory.addEventListener('click', function() {
                        selectedInventory.removeChild(newRow);
                        updateRowNumbers();
                        inventoryCount[inventoryName]--;
                        if (inventoryCount[inventoryName] >= 0) {
                            delete inventoryCount[inventoryName];
                            const cardInventoryToRemove = Array.from(document.querySelectorAll('.card-row-inventory')).find(c => c.getAttribute('data-name-inventory') === inventoryName);
                            cardInventoryToRemove.classList.remove('active');
                        }
                    });
                }

                if (Object.keys(inventoryCount).length === totalInventory.length) {
                    document.querySelectorAll('.card-row-inventory').forEach(c => c.classList.add('active'));
                }
                
            });
        });
        document.getElementById('reset-button-inventory').addEventListener('click', function() {
            selectedInventory.innerHTML = '';
            for (const inventory in inventoryCount) {
                delete inventoryCount[inventory];
            }
            document.querySelectorAll('.card-row-inventory').forEach(card => {
                card.classList.remove('active');
            });
        });

        function updateRowNumbers() {
            Array.from(selectedInventory.children).forEach((row, index) => {
                row.querySelector('.h6').innerText = index + 1;
            });
        }
    </script>

</body>

</html>