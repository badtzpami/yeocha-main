<style>
    #sidebar {
        background-color: #2C3E50 !important; /* Pink color with !important */
    }
</style>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav bg-custom-secondary">

        <li class="nav-item">
            <a class="nav-link  " href="../admin/dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- <li class="nav-item">
            <a class="nav-link collapsed " href="../admin/user_product.php">
                <i class="bi bi-basket"></i>
                <span>Product</span>
            </a>
        </li> -->

        <li class="nav-item">
            <a class="nav-link" data-bs-target="#account-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-basket"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="account-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="../admin/user_category.php">
                        <i class="bi bi-box"></i><span>Category</span>
                    </a>
                </li>
                <li>
                    <a href="../admin/user_product.php">
                        <i class="bi bi-cart"></i><span>Products</span>
                    </a>
                </li>
                

                 
                <li>
                    <a href="../admin/user_product_material.php">
                        <i class="bi bi-book"></i><span>Materials</span>
                    </a>
                </li>

                
                <li>
                    <a href="../admin/user_product_menu.php">
                        <i class="bi bi-basket"></i><span>Menu</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Product Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed " href="../admin/user_cart.php">
                <i class="bi bi-cart"></i>
                <span>Cart</span>
            </a>
        </li><!-- End Product Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed " href="../admin/user_orders.php">
                <i class="bi bi-bag"></i>
                <span>Orders</span>
            </a>
        </li><!-- End Product Nav -->

        
        <li class="nav-item">
            <a class="nav-link collapsed " href="../admin/user_logistic.php">
                <i class="bi bi-truck"></i>
                <span>Logistics</span>
            </a>
        </li><!-- End Product Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed " href="../admin/user_report.php">
                <i class="bi bi-pie-chart"></i>
                <span>Reports</span>
            </a>
        </li><!-- End Product Nav -->



        <li class="nav-heading">User</li>


        <li class="nav-item">
            <a class="nav-link collapsed " href="../admin/user_account.php">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>
        </li><!-- End Product Nav -->


        <li class="nav-item">
            <a class="nav-link collapsed" href="../admin/user_account_supplier.php">
                <i class="bi bi-people"></i>
                <span>Supplier</span>
            </a>
        </li><!-- End User Nav -->

        <li class="nav-heading">Setting</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="../include/user_profile.php">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->


        <li class="nav-heading">Others</li>


        <li class="nav-item">
            <a class="nav-link collapsed" href="../admin/user_message.php">
                <i class="bi bi-chat-left-text"></i>
                <span>Messages</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-contact.html">
                <i class="bi bi-bell"></i>
                <span>Notification</span>
            </a>
        </li><!-- End Contact Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="../include/user_logout.php">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Logout</span>
            </a>
        </li><!-- End Login Page Nav -->

    </ul>

</aside><!-- End Sidebar-->