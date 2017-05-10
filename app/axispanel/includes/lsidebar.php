    <!-----------------------------------------------------------------+
       "#sidebar_left" Helper Classes:
    -------------------------------------------------------------------+
       * Positioning Classes:
        '.affix' - Sets Sidebar Left to the fixed position

       * Available Skin Classes:
         .sidebar-dark (default no class needed)
         .sidebar-light
         .sidebar-light.light
    -------------------------------------------------------------------+
       Example: <aside id="sidebar_left" class="affix sidebar-light">
       Results: Fixed Left Sidebar with light/white background
    ------------------------------------------------------------------->

   <!-- Start: Sidebar Left -->
    <aside id="sidebar_left" class="nano nano-primary affix">

      <!-- Start: Sidebar Left Content -->
      <div class="sidebar-left-content nano-content">

        <!-- Start: Sidebar Left Menu -->
        <ul class="nav sidebar-menu">

          <li class="sidebar-label pt20">Main Menu</li>
          <li <?php if(isset($pagename) && $pagename=='Calendar') { echo 'class="active"'; } ?>>
            <a href="#">
              <span class="fa fa-calendar"></span>
              <span class="sidebar-title">Calendar</span>
              <span class="sidebar-title-tray">
                <span class="label label-xs bg-info">Comming Soon</span>
              </span>
            </a>
          </li>
          <li <?php if(isset($pagename) && $pagename=='Dashboard') { echo 'class="active"'; } ?>>
            <a href="index.php">
              <span class="glyphicon glyphicon-home"></span>
              <span class="sidebar-title">Dashboard</span>
            </a>
          </li>

            <?php
            //Project Types query
            //project types Query
            $sqlsidetypes = "SELECT * FROM tblprojecttype ORDER BY projectTypeName ASC";
            $resultsidetypes = mysqli_query($conn, $sqlsidetypes);
            ?>
		  <!-- sidebar bullets -->
          <li class="sidebar-label pt20">Projects</li>
          <li <?php if(isset($pagename) && $pagename=='Project Details') { echo 'class="active"'; } ?>>
            <a class="accordion-toggle" href="#">
              <span class="fa fa-columns"></span>
              <span class="sidebar-title">Project Details</span>
              <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
            <?php
                if (mysqli_num_rows($resultsidetypes) > 0) {
                    while($siderow = mysqli_fetch_assoc($resultsidetypes)) {
            ?>
              <li>
                <a href="projectdetails.php?projecttype=<?php echo $siderow['projectTypeName']; ?>"> <?php echo $siderow['projectTypeName']; ?> </a>
              </li>
            <?php } } else echo '<li><a href="#"> No Types </a></li>'; ?>
            </ul>
          </li>
		  <li <?php if(isset($pagename) && $pagename=='Project Names') { echo 'class="active"'; } ?>>
            <a href="projectnames.php">
              <span class="fa fa-plus-square-o"></span>
              <span class="sidebar-title">Project Names</span>
            </a>
          </li>
		  <li <?php if(isset($pagename) && $pagename=='Project Types') { echo 'class="active"'; } ?>>
            <a href="projecttypes.php">
              <span class="fa fa-bars"></span>
              <span class="sidebar-title">Project Types</span>
            </a>
          </li>

          <li class="sidebar-label pt20">Items</li>
          <li <?php if(isset($pagename) && $pagename=='Item Details') { echo 'class="active"'; } ?>>
            <a class="accordion-toggle" href="#">
              <span class="glyphicon glyphicon-shopping-cart"></span>
              <span class="sidebar-title">Item Details</span>
              <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
              <li>
                <a href="items.php?type=Appliances"> Home Appliances </a>
              </li>
              <li>
                <a href="items.php?type=Hardware"> Hardware </a>
              </li>
            </ul>
          </li>
		  <li <?php if(isset($pagename) && $pagename=='Item Brands') { echo 'class="active"'; } ?>>
            <a href="brands.php">
              <span class="glyphicon glyphicon-tags"></span>
              <span class="sidebar-title">Item Brands</span>
            </a>
          </li>
		  <li <?php if(isset($pagename) && $pagename=='Item Categories') { echo 'class="active"'; } ?>>
            <a href="categories.php">
              <span class="fa fa-table"></span>
              <span class="sidebar-title">Item Categories</span>
            </a>
          </li>

        </ul>
        <!-- End: Sidebar Menu -->

	      <!-- Start: Sidebar Collapse Button -->
	      <div class="sidebar-toggle-mini">
	        <a href="#">
	          <span class="fa fa-sign-out"></span>
	        </a>
	      </div>
	      <!-- End: Sidebar Collapse Button -->

      </div>
      <!-- End: Sidebar Left Content -->

    </aside>
    <!-- End: Sidebar Left -->