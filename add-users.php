<?php
    // Starting the session
    session_start();

    if(!isset($_SESSION['user'])) header('location: index.php');
    $_SESSION['table'] = 'users';
    $user = $_SESSION['user'];

    $usersList = include('database/show-database-function.php');
?>

<html>
    <head>
        <title>Dashboard - Morty's Pet Store Management System</title>
        <link rel="stylesheet" type="text/css" href="css/login.css?v=<?= time(); ?>">
        <!-- FontAwesome Kit (for logos) -->
        <script src="https://kit.fontawesome.com/65a31e3d12.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="dashBoardMainContainer">
            <?php include('prefabs/dashboard-sidebar.php') ?>
            <div class="dashBoardContentContainer" id="dashBoardContentContainer">
                <?php include('prefabs/dashboard-top-nav-bar.php') ?>
                <div class="dashBoardContent">
                    <div class="contentMainBody">
                        <div class="row">
                            <div class="column addUserFormColumn">
                                <h1 class="columnHeader"><i class="fa-solid fa-plus"></i> Add User Information</h1> 
                                <div id="addUserFormContainer">
                                    <form action="database/add-function.php" method="POST" class="addUserForm">
                                        <div class="addUserFormInputBox">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="addUserInput" id="first_name" name="first_name" />
                                        </div>
                                        <div class="addUserFormInputBox">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="addUserInput" id="last_name" name="last_name" />
                                        </div>
                                        <div class="addUserFormInputBox">
                                            <label for="email">Email</label>
                                            <input type="email" class="addUserInput" id="email" name="email" />
                                        </div>
                                        <div class="addUserFormInputBox">
                                            <label for="password">Password</label>
                                            <input type="password" class="addUserInput" id="password" name="password" />
                                        </div>
                                        <button type="submit" class="addUserBtn"><i class="fa-solid fa-user-plus"></i> Add User</button>
                                    </form>
                                    <?php 
                                        if(isset($_SESSION['response'])) {
                                            $response_message = $_SESSION['response']['message'];
                                            $is_success = $_SESSION['response']['success'];
                                    ?>
                                        <div class="responseMessage">
                                            <p class="<?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>">
                                                <?= $response_message ?>
                                            </p>
                                        </div>
                                    <?php unset($_SESSION['response']); } ?>
                                </div>
                            </div>
                            <div class="column userListColumn">
                                <h1 class="columnHeader"><i class="fa-solid fa-list"></i> List of Users</h1>
                                <div class="userListContainer">
                                    <div class="usersList">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($usersList as $index => $user) { ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td class="firstName"><?= $user['first_name'] ?></td>
                                                        <td class="lastName"><?= $user['last_name'] ?></td>
                                                        <td class="email"><?= $user['email'] ?></td>
                                                        <td><?= date('F d, Y @ h:i:s A', strtotime($user['created_at'])) ?></td>
                                                        <td><?= date('F d, Y @ h:i:s A', strtotime($user['last_updated_at'])) ?></td>
                                                        <td>
                                                            <a href="" class="editUserIcon" data-userid="<?= $user['id'] ?>"><i class="fa-solid fa-pencil"></i> Edit</a>
                                                            <a href="" class="deleteUserIcon" data-userid="<?= $user['id'] ?>" data-fname="<?= $user['first_name'] ?>" data-lname="<?= $user['last_name'] ?>"><i class="fa-solid fa-trash"></i> Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <p class="userCount"><?= count($usersList) ?> Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- JQuery 3.7.1 JS -->
    <script src="js/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 3.3.7 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional Bootstrap 3.37 CSS theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Bootstrap 3.3.7 JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Bootstrap3-Dialog 1.35.4 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css" integrity="sha512-PvZCtvQ6xGBLWHcXnyHD67NTP+a+bNrToMsIdX/NUqhw+npjLDhlMZ/PhSHZN4s9NdmuumcxKHQqbHlGVqc8ow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap3-Dialog 1.35.4 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.js" integrity="sha512-AZ+KX5NScHcQKWBfRXlCtb+ckjKYLO1i10faHLPXtGacz34rhXU8KM4t77XXG/Oy9961AeLqB/5o0KTJfy2WiA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Custom JS Scripts -->
    <script src="js/script.js?v=<?= time(); ?>"></script>  
    
    <script>
        function script() {

            this.initialize = function() {
                this.registerEvents();
            },

            this.registerEvents = function() {
                document.addEventListener('click', function(e) {
                    targetElement = e.target;

                    if(e.target.classList.contains('deleteUserIcon')) {
                        e.preventDefault();
                        userId = targetElement.dataset.userid;
                        fname = targetElement.dataset.fname;
                        lname = targetElement.dataset.lname;
                        fullName = fname + ' ' + lname;

                        BootstrapDialog.confirm({
                            type: BootstrapDialog.TYPE_DANGER,
                            message: 'Are you sure you want to delete this user: ' + fullName + '?',
                            callback: function(isDelete) {
                                if(isDelete) {
                                    $.ajax({
                                        method: 'POST',
                                        data: { id: userId, f_name: fname, l_name: lname },
                                        url: 'database/delete-function.php',
                                        dataType: 'json',
                                        success: function(data) {
                                            if(data.success) {
                                                BootstrapDialog.alert({
                                                    type: BootstrapDialog.TYPE_SUCCESS,
                                                    message: data.message,
                                                    callback: function() {
                                                        location.reload();
                                                    }
                                                });
                                            } else {
                                                BootstrapDialog.alert({
                                                    type: BootstrapDialog.TYPE_DANGER,
                                                    message: data.message,
                                                });
                                            }
                                        }
                                    });
                                } else { alert('Not deleting'); }
                            }
                        });
                    }

                    if(e.target.classList.contains('editUserIcon')) {
                        e.preventDefault();

                        // Getting data
                        firstName = targetElement.closest('tr').querySelector('td.firstName').innerHTML;
                        lastName = targetElement.closest('tr').querySelector('td.lastName').innerHTML;
                        email = targetElement.closest('tr').querySelector('td.email').innerHTML;
                        fullName = firstName + ' ' + lastName;
                        userId = targetElement.dataset.userid;

                        BootstrapDialog.confirm({
                            title: 'Are you sure you want to update this user information: ' + fullName + '?',
                            message: '<form>\
                                        <div class="editUserForm">\
                                            <label for="firstName">First Name:</label>\
                                            <input type="text" class="editUserInput" id="firstName" value="'+ firstName +'">\
                                        </div>\
                                        <div class="editUserForm">\
                                            <label for="lastName">Last Name:</label>\
                                            <input type="text" class="editUserInput" id="lastName" value="'+ lastName +'">\
                                        </div>\
                                        <div class="editUserForm">\
                                            <label for="email">Email Address:</label>\
                                            <input type="email" class="editUserInput" id="emailUpdate" value="'+ email +'">\
                                        </div>\
                                    </form>',
                                    callback: function(isUpdate) {
                                        if(isUpdate) {
                                            $.ajax({
                                                method: 'POST',
                                                data: {
                                                    id: userId,
                                                    f_name: document.getElementById('firstName').value,
                                                    l_name: document.getElementById('lastName').value,
                                                    email: document.getElementById('emailUpdate').value
                                                },
                                                url: 'database/update-function.php',
                                                dataType: 'json',
                                                success: function(data) {
                                                    if(data.success) {
                                                        BootstrapDialog.alert({
                                                            type: BootstrapDialog.TYPE_SUCCESS,
                                                            message: data.message,
                                                            callback: function() {
                                                                location.reload();
                                                            }
                                                        });
                                                    } else {
                                                        BootstrapDialog.alert({
                                                            type: BootstrapDialog.TYPE_DANGER,
                                                            message: data.message,
                                                        });
                                                    }
                                                }
                                            });
                                        } else { alert('Not updating'); }
                                    }
                        });
                    }
                });
            }
        }

        var script = new script;
        script.initialize();
    </script>  
    </body>
</html>