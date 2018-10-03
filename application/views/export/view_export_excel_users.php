<table border="1" style="width: 60%;">
    <thead>
        <tr>
            <th colspan="8" style="text-align: left; font-size: 20xp;padding: 10px;"><?php echo SYSTEM_NAME; ?> System Users Review</th>
        </tr>
        <tr>
            <th style="text-align: left; padding: 10px;">Full Name</th>
            <th style="text-align: left; padding: 10px;">Email</th>
            <th style="text-align: left; padding: 10px;">Phone Number</th>
            <th style="text-align: left; padding: 10px;">Role</th>
            <th style="text-align: left; padding: 10px;">AD Name</th>
            <th style="text-align: left; padding: 10px;">Status</th>
            <th style="text-align: left; padding: 10px;">2FA Status</th>
            <th style="text-align: left; padding: 10px;">Created On</th>
            <th style="text-align: left; padding: 10px;">Last Logon</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($users as $i => $u) {
            ?>
            <tr>

                <td style="text-align: left; padding: 10px;"><?php echo strtoupper($u['usr_fullname']); ?></td>
                <td style="text-align: left; padding: 10px;"><?php echo strtolower($u['usr_email']); ?></td>
                <td style="text-align: left; padding: 10px;mso-number-format:'\@';"><?php echo $u['usr_phone']; ?></td>
                <td style="text-align: left; padding: 10px;"><?php echo ucwords($u['usr_role']); ?></td>
                <td style="text-align: left; padding: 10px;"><?php echo $u['usr_ad_name']; ?></td>
                <td style="text-align: left; padding: 10px;"><?php echo ucwords($u['usr_status']); ?></td>
                <td style="text-align: left; padding: 10px;">
                    <?php
                    if($u['usr_2fa_enabled'] == '1'){
                       echo 'ENABLED'; 
                    }elseif($u['usr_2fa_enabled'] == '0'){
                        echo 'DISABLED';
                    }
                    
                    ?>
                </td>
                <td style="text-align: left; padding: 10px;"><?php echo ucwords($u['usr_timestamp']); ?></td>
                <td style="text-align: left; padding: 10px;"><?php echo ucwords($u['usr_last_login']); ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>