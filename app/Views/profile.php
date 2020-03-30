<div class="profile">
    <div class="profile-wrapper">
        <div class="row">
            <div class="avatar">
                <div class="avatar-placeholder" style="background-image:url('<?php echo $user['photo'];?>');">
                </div>
                <div class="user-id">#<?php echo $user['id'];?></div>
            </div>
            <div class="name">
                <h3><?php echo $user['name'];?></h3>
                <p class="email"><?php echo $user['email'];?></p>
                <p><?php echo $user['dateOfBirth'];?> (<?php echo $user['usersYear'];?>)</p>
            </div>
        </div>

        <div class="row">
            <p class="text">
                <?php echo $user['bio'];?>
            </p>
        </div>
        <div>
            <a class="btn" href="/logout">Выйти</a>
        </div>
        <div class="row">
            <p class="info">
                Аккаунт создан: <?php echo $user['created'];?>
            </p>
        </div>
    </div>
</div>