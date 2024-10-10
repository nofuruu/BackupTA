<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Sidebar with Dynamic Content</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="navbar-brand">
            <img src="../assets/logoA.png" alt="logo" id="dslogo">
        </div>
        <ul>
            <li><a href="#" onclick="showContent('website')"><i class="fas fa-globe"></i> Website</a></li>
            <li><a href="#" onclick="showContent('user')"><i class="fas fa-user"></i> User</a></li>
            <li><a href="#" onclick="showContent('module')"><i class="fas fa-box"></i> Module</a></li>
            <li><a href="#" onclick="showContent('role')"><i class="fas fa-briefcase"></i> Role</a></li>
            <li><a href="#" onclick="showContent('menu')"><i class="fas fa-file-alt"></i> Menu</a></li>
            <li><a href="#" onclick="showContent('assign-role')"><i class="fas fa-link"></i> Assign Role</a></li>
            <li><a href="#" onclick="showContent('setting-website')"><i class="fas fa-cog"></i> Setting Website</a></li>
            <li><a href="#" onclick="showContent('layout-setting')"><i class="fas fa-th-large"></i> Layout Setting</a></li>
        </ul>
    </div>

    <div class="content">
        <!-- Dynamic Content Area -->
        <div id="website" class="content-section" style="display:none;">
            <h1>Website Content</h1>
            <p>Information about website settings goes here.</p>
        </div>
        
        <div id="user" class="content-section" style="display:none;">
            <h1>User Management</h1>
            <p>This is where you can manage users.</p>
        </div>
        
        <div id="module" class="content-section" style="display:none;">
            <h1>Module Management</h1>
            <p>Manage modules for your website here.</p>
        </div>
        
        <div id="role" class="content-section" style="display:none;">
            <h1>Role Management</h1>
            <p>Assign and manage roles here.</p>
        </div>
        
        <div id="menu" class="content-section" style="display:none;">
            <h1>Menu Management</h1>
            <p>Manage your website menu here.</p>
        </div>
        
        <div id="assign-role" class="content-section" style="display:none;">
            <h1>Assign Roles</h1>
            <p>Assign roles to users here.</p>
        </div>
        
        <div id="setting-website" class="content-section" style="display:none;">
            <h1>Website Settings</h1>
            <p>Configure website settings here.</p>
        </div>
        
        <div id="layout-setting" class="content-section" style="display:none;">
            <h1>Layout Settings</h1>
            <p>Adjust your website layout here.</p>
        </div>
    </div>

    <script>
        function showContent(section) {
            // Hide all sections first
            var sections = document.getElementsByClassName('content-section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].style.display = 'none';
            }

            // Show the selected section
            document.getElementById(section).style.display = 'block';
        }
    </script>
</body>
</html>
