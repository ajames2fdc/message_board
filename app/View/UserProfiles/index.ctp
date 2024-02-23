<?php
echo 'Succesfully added';
pr($userProfile);
?>


<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1 class="display-4"><?= ($userProfile['first_name'] . ' ' . $userProfile['last_name']) ?></h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Gender:</strong> <?= h($userProfile['gender']) ?></li>
                        <li class="list-group-item"><strong>Birthday:</strong> <?= h($userProfile['birthday']) ?></li>
                        <li class="list-group-item"><strong>Joined Date:</strong> <?= h($userProfile['joined_date']) ?></li>
                        <li class="list-group-item"><strong>Last Login:</strong> <?= h($userProfile['last_login']) ?></li>
                        <li class="list-group-item"><strong>Hobby:</strong> <?= h($userProfile['hobby']) ?></li>
                        <li class="list-group-item"><strong>Bio:</strong> <?= h($userProfile['bio']) ?></li>
                        <li class="list-group-item"><strong>Profile Picture:</strong> <?= h($userProfile['profile_picture']) ?></li>
                    </ul>
                </div>
                <!-- Add more columns or styling as needed -->
            </div>
        </div>
    </div>
</div>