<?php
    // Starting the session
    session_start();
    if(!isset($_SESSION['user'])) header('location: index.php');

    $_SESSION['table'] = 'users';
    $user = $_SESSION['user'];

    $target_table = 'users';
    $usersList = include('database/show-function.php');
?>

<html>
    <head>
        <title>View Users - Morty's Pet Store Management System</title>
        <?php include('prefabs/script-header-links.php'); ?>
    </head>
    <body>
        <div id="dashBoardMainContainer">
            <?php include('prefabs/dashboard-sidebar.php') ?>
            <div class="dashBoardContentContainer" id="dashBoardContentContainer">
                <?php include('prefabs/dashboard-top-nav-bar.php') ?>
                <div class="dashBoardContent">
                    <div class="contentMainBody">
                        <div class="row">
                            <div class="column column-12">
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
                                                        <td><?= date('F d, Y @ h:i:s A', strtotime($user['updated_at'])) ?></td>
                                                        <td>
                                                            <a href="" class="editUserIcon" data-userid="<?= $user['id'] ?>"><i class="fa-solid fa-pencil"></i> Edit</a>
                                                            <a href="" class="deleteUserIcon" data-userid="<?= $user['id'] ?>" data-fname="<?= $user['first_name'] ?>" data-lname="<?= $user['last_name'] ?>"><i class="fa-solid fa-trash-can"></i> Delete</a>
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

        <?php include('prefabs/script-footer-links.php') ?>
    
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
                            title: 'Delete User',
                            message: 'Are you sure you want to delete this user: <strong>' + fullName + '</strong>?',
                            callback: function(isDelete) {
                                if(isDelete) {
                                    $.ajax({
                                        method: 'POST',
                                        data: { id: userId, table: 'users' },
                                        url: 'database/delete-function.php',
                                        dataType: 'json',
                                        success: function(data) {
                                            const message = data.success ? fullName + ' has been deleted from the database!' : 'Error processing request!';

                                            BootstrapDialog.alert({
                                                type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                                message: message,
                                                callback: function() {
                                                    if (data.success) location.reload();
                                                }
                                            });
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