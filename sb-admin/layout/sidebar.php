<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Data List</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="career.php">Career</a>
                <a class="collapse-item" href="appointment.php">Appointment</a>
                <a class="collapse-item" href="customer.php">Customer</a>
                <a class="collapse-item" href="service.php">Service</a>
                <a class="collapse-item" href="inventory.php">Inventory</a>
                <a class="collapse-item" href="invoice.php">Invoice</a>
                <a class="collapse-item" href="invoice_item.php">Invoice-Item</a>
                <a class="collapse-item" href="review.php">Review</a>

            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Manage DataList</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="create_career.php">Create Career</a>
                <a class="collapse-item" href="create_appointment.php">Create appointment</a>
                <a class="collapse-item" href="create_service.php">Create service</a>
                <a class="collapse-item" href="create_customer.php">Create Customer</a>
                <a class="collapse-item" href="create_inventory.php">Create Inventory</a>
                <a class="collapse-item" href="create_invoice.php">Create Invoice</a>
                <a class="collapse-item" href="create_invoiceitem.php">Create Invoice-Item</a>
                <a class="collapse-item" href="create_review.php">Create Review</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <?php
    // // include './layout/sidebar/pages.php';
    // include './layout/sidebar/chart.php';
    // include './layout/sidebar/table.php';
    ?>

    <!-- Nav Item - Charts -->

    <!-- Nav Item - Tables -->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->


</ul>