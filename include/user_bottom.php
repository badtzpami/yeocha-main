  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>


  <!-- modal -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.25%.4/css/all.min.css"> -->

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

  <script>
    function updateNotification(productId) {
      $.ajax({
        type: "POST",
        url: "../user_process/update_notification.php",
        data: {
          id: productId
        }
        // ,
        // success: function(response) {
        //   // Handle success (e.g., show a success message)
        //   alert("Notification updated successfully!");
        // },
        // error: function(xhr, status, error) {
        //   // Handle error
        //   alert("An error occurred: " + error);
        // }
      });
    }
    // Function to remove the 'collapsed' class and save the state
    function removeActive(event) {
      event.preventDefault(); // Prevent the default action of the link
      const sidebarLinks = document.querySelectorAll('.sidebar-nav .nav-link');

      sidebarLinks.forEach(link => {
        link.classList.add('collapsed'); // Add 'collapsed' class to all links
      });

      // Remove 'collapsed' class only from the clicked link
      event.currentTarget.classList.remove('collapsed');

      // Save the state in localStorage
      localStorage.setItem('sidebarCollapsed', 'false');

      // Navigate to the new page after removing the class
      const targetUrl = event.currentTarget.getAttribute('href');
      window.location.href = targetUrl; // Redirect to the new page
    }

    // On page load, check localStorage for the sidebar state
    window.onload = function() {
      const sidebarLinks = document.querySelectorAll('.sidebar-nav .nav-link');
      const isCollapsed = localStorage.getItem('sidebarCollapsed');
      const currentUrl = window.location.href;

      // Remove collapsed class if the current URL matches a specific path
      sidebarLinks.forEach(link => {
        if (link.href === currentUrl) {
          link.classList.remove('collapsed'); // Remove 'collapsed' from the active link
        } else {
          link.classList.add('collapsed'); // Add 'collapsed' to all other links
        }
      });

      // Update localStorage based on the current URL
      localStorage.setItem('sidebarCollapsed', currentUrl.includes('supplier/user_item.php') ? 'false' : 'true');
    };


    function printUserTable() {
      const iframe = document.getElementById('userPrintIframe');
      iframe.contentWindow.focus(); // Make sure the iframe content is focused
      iframe.contentWindow.print(); // Trigger the print dialog of the iframe content
    }

    $(document).ready(function() {
      // $('.table-responsive table').DataTable({
      //   "ordering": false,
      //   retrieve: true,
      //   paging: true,
      //   pagingType: 'full_numbers',
      //   pagingType: 'full_numbers',
      //   "aLengthMenu": [
      //     [5, 10, 25, 50, 100, 200, 500, -1],
      //     [5, 10, 25, 50, 100, 200, 500, "All"]
      //   ],
      //   "iDisplayLength": 5,

      // });





      $('#addRowContent .table-responsive #table_add').DataTable({
        "ordering": false,
        retrieve: false,
        paging: false,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
        "searching": false, // Disable the search feature
        "info": false, // Disable the information display
        "language": {
          "emptyTable": "", // Remove "No data available" message
          "zeroRecords": ""
        }
      });

      $('#activeContent .table-responsive #table_active').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });

      $('#archiveContent .table-responsive #table_archive').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });

      $('#categoryContent .table-responsive #table_category').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });

      $('#ProductContent .table-responsive #table_category').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });


      $('#allMenuContent .table-responsive #table_menu').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });


      $('#allPhysicalInventoryRawContent .table-responsive #table_inventory_raw').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });

      $('#allPhysicalInventoryRawContent .table-responsive #table_inventory_raw').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });




      $('#allPhysicalInventoryDisposableContent .table-responsive #table_inventory_disposable').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });



      $('#activeMaterialContent .table-responsive #table_history').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });


      $('#archiveMaterialContent .table-responsive #table_archive').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });



      $('#allPhysicalInventoryRawContent .table-responsive #table_inventory_raw').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });



      $('#allPhysicalInventoryDisposableContent .table-responsive #table_inventory_disposable').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });



      $('#allSaleContent .table-responsive #table_sale').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });


      $('#allMaterialContent .table-responsive #table_category').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });

      $('#archiveMaterialContent .table-responsive #table_material_supplier').DataTable({
        "ordering": false,
        retrieve: true,
        paging: true,
        pagingType: 'full_numbers',
        pagingType: 'full_numbers',
        "aLengthMenu": [
          [5, 10, 25, 50, 100, 200, 500, -1],
          [5, 10, 25, 50, 100, 200, 500, "All"]
        ],
        "iDisplayLength": 5,
      });



      let activeTableInitialized = false;
      let archiveTableInitialized = false;


      function initializeDataTable(selector) {
        if (!$.fn.DataTable.isDataTable(selector)) {
          $(selector).DataTable();
        }
      }

      // Initial setup for Active section
      initializeDataTable('#activeContent .table-responsive table');
      activeTableInitialized = true;



      $('#viewCategoryButton').click(function() {
        $('#viewCategoryContent').show();
        $('#categoryContent').hide();
        $('#addCategoryContent').hide();

        $('#viewCategoryButton').addClass('active-button');
        $('#categoryButton').removeClass('active-button');
        $('#addCategoryButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#viewCategoryContent .table-responsive table');
          activeTableInitialized = true;
        }
      });


      $('#categoryButton').click(function() {
        $('#viewCategoryContent').hide();
        $('#categoryContent').show();
        $('#addCategoryContent').hide();

        $('#viewCategoryButton').removeClass('active-button');
        $('#categoryButton').addClass('active-button');
        $('#addCategoryButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#categoryContent .table-responsive table');
          activeTableInitialized = true;
        }
      });

      $('#addCategoryButton').click(function() {
        $('#viewCategoryContent').hide();
        $('#categoryContent').hide();
        $('#addCategoryContent').show();

        $('#viewCategoryButton').removeClass('active-button');
        $('#categoryButton').removeClass('active-button');
        $('#addCategoryButton').addClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#addCategoryContent .table-responsive table');
          activeTableInitialized = true;
        }
      });






      $('#viewProdButton').click(function() {
        $('#viewProductContent').show();
        $('#ProductContent').hide();
        $('#addProductContent').hide();

        $('#viewProdButton').addClass('active-button');
        $('#ProductButton').removeClass('active-button');
        $('#addProductButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#viewProductContent .table-responsive table');
          activeTableInitialized = true;
        }
      });


      $('#ProductButton').click(function() {
        $('#viewProductContent').hide();
        $('#ProductContent').show();
        $('#addProductContent').hide();

        $('#viewProdButton').removeClass('active-button');
        $('#ProductButton').addClass('active-button');
        $('#addProductButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#addProductContent .table-responsive table');
          activeTableInitialized = true;
        }
      });





      $('#addProductButton').click(function() {
        $('#viewProductContent').hide();
        $('#ProductContent').hide();
        $('#addProductContent').show();

        $('#viewProdButton').removeClass('active-button');
        $('#ProductButton').removeClass('active-button');
        $('#addProductButton').addClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#addProductContent .table-responsive table');
          activeTableInitialized = true;
        }
      });


















      $('#activeButton').click(function() {
        $('#archiveContent').hide();
        $('#activeContent').show();
        $('#addRowContent').hide();


        $('#activeButton').addClass('active-button');
        $('#archiveButton').removeClass('active-button');
        $('#actionButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#activeContent .table-responsive table');
          activeTableInitialized = true;
        }
      });








      $('#archiveButton').click(function() {
        $('#archiveContent').show();
        $('#activeContent').hide();
        $('#addRowContent').hide();


        $('#archiveButton').addClass('active-button');
        $('#activeButton').removeClass('active-button');
        $('#actionButton').removeClass('active-button');

        if (!archiveTableInitialized) {
          initializeDataTable('#archiveContent .table-responsive table');
          archiveTableInitialized = true;
        }
      });

      $('#actionButton').click(function() {
        $('#activeContent').hide();
        $('#archiveContent').hide();
        $('#addRowContent').show();

        $('#actionButton').addClass('active-button');
        $('#activeButton').removeClass('active-button');
        $('#archiveButton').removeClass('active-button');

        // if (!archiveTableInitialized) {
        //   initializeDataTable('#archiveContent .table-responsive table');
        //   archiveTableInitialized = true;
        // }
      });















      $('#viewMaterialButton').click(function() {
        $('#viewMaterialContent').show();
        $('#allMaterialContent').hide();
        $('#activeMaterialContent').hide();
        $('#archiveMaterialContent').hide();
        $('#addRawContent').hide();
        // $('#addDisposableContent').hide();

        $('#viewMaterialButton').addClass('active-button');
        $('#MaterialAllButton').removeClass('active-button');
        $('#MaterialActiveButton').removeClass('active-button');
        $('#MaterialArchiveButton').removeClass('active-button');
        $('#addRawMaterialButton').removeClass('active-button');
        // $('#addDisposableMaterialButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#viewMaterialContent .table-responsive table');
          activeTableInitialized = true;
        }
      });

      $('#MaterialAllButton').click(function() {
        $('#viewMaterialContent').hide();
        $('#allMaterialContent').show();
        $('#activeMaterialContent').hide();
        $('#archiveMaterialContent').hide();
        $('#addRawContent').hide();
        // $('#addDisposableContent').hide();

        $('#viewMaterialButton').removeClass('active-button');
        $('#MaterialAllButton').addClass('active-button');
        $('#MaterialActiveButton').removeClass('active-button');
        $('#MaterialArchiveButton').removeClass('active-button');
        $('#addRawMaterialButton').removeClass('active-button');
        // $('#addDisposableMaterialButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#allMaterialContent .table-responsive table');
          activeTableInitialized = true;
        }
      });


      $('#MaterialActiveButton').click(function() {
        $('#viewMaterialContent').hide();
        $('#allMaterialContent').hide();
        $('#activeMaterialContent').show();
        $('#archiveMaterialContent').hide();
        $('#addRawContent').hide();
        // $('#addDisposableContent').hide();

        $('#viewMaterialButton').removeClass('active-button');
        $('#MaterialAllButton').removeClass('active-button');
        $('#MaterialActiveButton').addClass('active-button');
        $('#MaterialArchiveButton').removeClass('active-button');
        $('#addRawMaterialButton').removeClass('active-button');
        // $('#addDisposableMaterialButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#activeMaterialContent .table-responsive table');
          activeTableInitialized = true;
        }
      });


      $('#MaterialArchiveButton').click(function() {
        $('#viewMaterialContent').hide();
        $('#allMaterialContent').hide();
        $('#activeMaterialContent').hide();
        $('#archiveMaterialContent').show();
        $('#addRawContent').hide();
        // $('#addDisposableContent').hide();

        $('#viewMaterialButton').removeClass('active-button');
        $('#MaterialAllButton').removeClass('active-button');
        $('#MaterialActiveButton').removeClass('active-button');
        $('#MaterialArchiveButton').addClass('active-button');
        $('#addRawMaterialButton').removeClass('active-button');
        // $('#addDisposableMaterialButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#archiveMaterialContent .table-responsive table');
          activeTableInitialized = true;
        }
      });



      $('#addRawMaterialButton').click(function() {
        $('#viewMaterialContent').hide();
        $('#allMaterialContent').hide();
        $('#activeMaterialContent').hide();
        $('#archiveMaterialContent').hide();
        $('#addRawContent').show();
        // $('#addDisposableContent').hide();

        $('#viewMaterialButton').removeClass('active-button');
        $('#MaterialAllButton').removeClass('active-button');
        $('#MaterialActiveButton').removeClass('active-button');
        $('#MaterialArchiveButton').removeClass('active-button');
        $('#addRawMaterialButton').addClass('active-button');
        // $('#addDisposableMaterialButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#addRawContent .table-responsive table');
          activeTableInitialized = true;
        }
      });


      // $('#addDisposableMaterialButton').click(function() {
      //   $('#viewMaterialContent').hide();
      //   $('#allMaterialContent').hide();
      //   $('#activeMaterialContent').hide();
      //   $('#archiveMaterialContent').hide();
      //   $('#addRawContent').hide();
      //   $('#addDisposableContent').show();

      //   $('#viewMaterialButton').removeClass('active-button');
      //   $('#MaterialAllButton').removeClass('active-button');
      //   $('#MaterialActiveButton').removeClass('active-button');
      //   $('#MaterialArchiveButton').removeClass('active-button');
      //   $('#addRawMaterialButton').removeClass('active-button');
      //   $('#addDisposableMaterialButton').addClass('active-button');

      //   if (!activeTableInitialized) {
      //     initializeDataTable('#addDisposableContent .table-responsive table');
      //     activeTableInitialized = true;
      //   }
      // });









      $('#viewMenuButton').click(function() {
        $('#viewMenuContent').show();
        $('#allMenuContent').hide();
        $('#addMenuContent').hide();

        $('#viewMenuButton').addClass('active-button');
        $('#MenuAllButton').removeClass('active-button');
        $('#addMenuButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#viewMenuContent .table-responsive table');
          activeTableInitialized = true;
        }
      });





      $('#MenuAllButton').click(function() {
        $('#viewMenuContent').hide();
        $('#allMenuContent').show();
        $('#addMenuContent').hide();

        $('#viewMenuButton').removeClass('active-button');
        $('#MenuAllButton').addClass('active-button');
        $('#addMenuButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#allMenuContent .table-responsive table');
          activeTableInitialized = true;
        }
      });



      $('#addMenuButton').click(function() {
        $('#viewMenuContent').hide();
        $('#allMenuContent').hide();
        $('#addMenuContent').show();

        $('#viewMenuButton').removeClass('active-button');
        $('#MenuAllButton').removeClass('active-button');
        $('#addMenuButton').addClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#addMenuContent .table-responsive table');
          activeTableInitialized = true;
        }
      });






      $('#PhysicalInventoryButton').click(function() {
        $('#allPhysicalInventoryRawContent').show();
        $('#allPhysicalInventoryDisposableContent').show();


        $('#physicalPhysicalInventoryContent').hide();
        $('#selectPhysicalInventoryDisposableContent').hide();

        $('#addPhysicalInventoryContent').hide();
        $('#selectPhysicalInventoryContent').hide();
        $('#SelectTypeContent').hide();

        $('#PhysicalInventoryButton').addClass('active-button');
        $('#updatePhysicalInventoryButton').removeClass('active-button');
        $('#addPhysicalInventoryButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#allPhysicalInventoryRawContent .table-responsive table');
          activeTableInitialized = true;
        }
      });





      $('#updatePhysicalInventoryButton').click(function() {
        $('#allPhysicalInventoryRawContent').hide();
        $('#allPhysicalInventoryDisposableContent').hide();

        $('#physicalPhysicalInventoryContent').show();
        $('#selectPhysicalInventoryDisposableContent').show();

        $('#addPhysicalInventoryContent').hide();
        $('#selectPhysicalInventoryContent').hide();
        $('#SelectTypeContent').hide();

        $('#PhysicalInventoryButton').removeClass('active-button');
        $('#updatePhysicalInventoryButton').addClass('active-button');
        $('#addPhysicalInventoryButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#physicalPhysicalInventoryContent .table-responsive table');
          activeTableInitialized = true;
        }
      });


      $('#addPhysicalInventoryButton').click(function() {
        $('#allPhysicalInventoryRawContent').hide();
        $('#allPhysicalInventoryDisposableContent').hide();
        $('#selectPhysicalInventoryDisposableContent').hide();

        $('#physicalPhysicalInventoryContent').hide();
        $('#selectPhysicalInventoryDisposableContent').hide();

        $('#addPhysicalInventoryContent').show();
        $('#selectPhysicalInventoryContent').show();
        $('#SelectTypeContent').show();

        $('#PhysicalInventoryButton').removeClass('active-button');
        $('#updatePhysicalInventoryButton').removeClass('active-button');
        $('#addPhysicalInventoryButton').addClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#addPhysicalInventoryContent .table-responsive table');
          activeTableInitialized = true;
        }
      });











      ////////////////////////////////////////////////////////////////////////////////////////////



      $('#checkOutButton').click(function() {
        $('#checkOutContent').show();
        $('#toPackContent').hide();
        $('#toShipContent').hide();
        $('#toReceiveContent').hide();
        $('#completedContent').hide();
        $('#cancelledContent').hide();

        $('#checkOutButton').addClass('active-button');
        $('#toPackButton').removeClass('active-button');
        $('#toShipButton').removeClass('active-button');
        $('#toReceiveButton').removeClass('active-button');
        $('#toCompletedButton').removeClass('active-button');
        $('#toCancelledButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#checkOutContent .table-responsive');
          activeTableInitialized = true;
        }
      });

      
      $('#toPackButton').click(function() {
        $('#checkOutContent').hide();
        $('#toPackContent').show();
        $('#toShipContent').hide();
        $('#toReceiveContent').hide();
        $('#completedContent').hide();
        $('#cancelledContent').hide();

        $('#checkOutButton').removeClass('active-button');
        $('#toPackButton').addClass('active-button');
        $('#toShipButton').removeClass('active-button');
        $('#toReceiveButton').removeClass('active-button');
        $('#toCompletedButton').removeClass('active-button');
        $('#toCancelledButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#toPackContent .table-responsive');
          activeTableInitialized = true;
        }
      });

      $('#toShipButton').click(function() {
        $('#checkOutContent').hide();
        $('#toPackContent').hide();
        $('#toShipContent').show();
        $('#toReceiveContent').hide();
        $('#completedContent').hide();
        $('#cancelledContent').hide();

        $('#checkOutButton').removeClass('active-button');
        $('#toPackButton').removeClass('active-button');
        $('#toShipButton').addClass('active-button');
        $('#toReceiveButton').removeClass('active-button');
        $('#toCompletedButton').removeClass('active-button');
        $('#toCancelledButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#toShipContent .table-responsive');
          activeTableInitialized = true;
        }
      });

      $('#toReceiveButton').click(function() {
        $('#checkOutContent').hide();
        $('#toPackContent').hide();
        $('#toShipContent').hide();
        $('#toReceiveContent').show();
        $('#completedContent').hide();
        $('#cancelledContent').hide();

        $('#checkOutButton').removeClass('active-button');
        $('#toPackButton').removeClass('active-button');
        $('#toShipButton').removeClass('active-button');
        $('#toReceiveButton').addClass('active-button');
        $('#toCompletedButton').removeClass('active-button');
        $('#toCancelledButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#toReceiveContent .table-responsive');
          activeTableInitialized = true;
        }
      });

      $('#toCompletedButton').click(function() {
        $('#checkOutContent').hide();
        $('#toPackContent').hide();
        $('#toShipContent').hide();
        $('#toReceiveContent').hide();
        $('#completedContent').show();
        $('#cancelledContent').hide();

        $('#checkOutButton').removeClass('active-button');
        $('#toPackButton').removeClass('active-button');
        $('#toShipButton').removeClass('active-button');
        $('#toReceiveButton').removeClass('active-button');
        $('#toCompletedButton').addClass('active-button');
        $('#toCancelledButton').removeClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#completedContent .table-responsive');
          activeTableInitialized = true;
        }
      });


      $('#toCancelledButton').click(function() {
        $('#checkOutContent').hide();
        $('#toPackContent').hide();
        $('#toShipContent').hide();
        $('#toReceiveContent').hide();
        $('#completedContent').hide();
        $('#cancelledContent').show();

        $('#checkOutButton').removeClass('active-button');
        $('#toPackButton').removeClass('active-button');
        $('#toShipButton').removeClass('active-button');
        $('#toReceiveButton').removeClass('active-button');
        $('#toCompletedButton').removeClass('active-button');
        $('#toCancelledButton').addClass('active-button');

        if (!activeTableInitialized) {
          initializeDataTable('#cancelledContent .table-responsive');
          activeTableInitialized = true;
        }
      });

    });







    // Function to show the custom message box
    function showMessageBox(title, message, icon) {
      // Update the message box content

      $('#new_msg').html(`<div class="alert alert-info" role="alert" style="font-size: 14px;"><strong><span>${title}</span></strong><br><span>${message}</span></div>`);

      // Optionally, set different styles based on the icon
      if (icon === 'success') {
        $('#message').css('color', 'green');
        $('#logo_msg').css('color', 'green');
        $('#logo_msg').css('font-size', '52px');
        $('#logo_msg').css('display', 'flex');
        $('#logo_msg').css('justify-content', 'center');
        $('#logo_msg').css('text-align', 'center');
        $('#logo_msg').css('margin-bottom', '22px');
        $('#logo_msg').attr('class', 'bi bi-check-circle-fill'); // Set class for success
        $('#loadingBar').css('background-color', 'green');
      } else if (icon === 'warning') {
        $('#message').css('color', 'orange');
        $('#logo_msg').css('color', 'orange');
        $('#logo_msg').css('font-size', '52px');
        $('#logo_msg').css('display', 'flex');
        $('#logo_msg').css('justify-content', 'center');
        $('#logo_msg').css('text-align', 'center');
        $('#logo_msg').css('margin-bottom', '22px');
        $('#logo_msg').attr('class', 'bi bi-exclamation-circle-fill'); // Set class for success
        $('#loadingBar').css('background-color', 'orange');
      } else {
        $('#message').css('color', 'red');
        $('#logo_msg').css('color', 'red');
        $('#logo_msg').css('font-size', '52px');
        $('#logo_msg').css('display', 'flex');
        $('#logo_msg').css('justify-content', 'center');
        $('#logo_msg').css('text-align', 'center');
        $('#logo_msg').css('margin-bottom', '22px');
        $('#logo_msg').attr('class', 'bi bi-dash-circle-fill'); // Set class for success
        $('#loadingBar').css('background-color', 'red');
      }

      // Show the message box
      $('#messageBox').show();

      // Hide the message box after 4 seconds (adjust as needed)
      setTimeout(function() {
        $('#messageBox').fadeOut();
      }, 6000);
    }


    // Function to show the progress bar
    function showProgressBar(message) {
      $('#progressDiv').show();
      // Update the message box content
      $('#progress_msg').html(`<strong>${message}</strong>`);
      // Optionally, you can add animation to the progress bar here
      $('#progressDiv .progress-bar').css('width', '100%');

      // Hide the progress bar after the redirect
      setTimeout(function() {
        $('#progressDiv').fadeOut();
      }, 5000);
    }

    // Close message box on clicking the close button
    $('#closeBtn').on('click', function() {
      $('#messageBox').fadeOut();
    });
  </script>


  </body>

  </html>