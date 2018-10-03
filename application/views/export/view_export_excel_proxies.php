<table border="1" style="width: 60%;">
    <thead>
        <tr>
            <th colspan="6" style="text-align: left; font-size: 20xp;padding: 10px;">Vodacom AGM Shareholders Proxy Report</th>
        </tr>
        <tr>
            <th style="text-align: left; padding: 10px;">Attendee Name</th>
            <th style="text-align: left; padding: 10px;">Phone Number</th>
            <th style="text-align: left; padding: 10px;">Address</th>
            <th style="text-align: left; padding: 10px;">Type</th>
            <th style="text-align: left; padding: 10px;">CDS Number(s)</th>
            <th style="text-align: left; padding: 10px;">Total Shares</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($proxies as $i => $proxy) {
            ?>
            <tr>

                <td style="text-align: left; padding: 10px;"><?php echo ucwords($proxy['att_fullname']); ?></td>
                <td style="text-align: left; padding: 10px;mso-number-format:'\@';"><?php echo $proxy['att_phone_number']; ?></td>
                <td style="text-align: left; padding: 10px;"><?php echo ucwords($proxy['att_address']); ?></td>
                <td style="text-align: left; padding: 10px;"><?php echo $proxy['att_attends_as']; ?></td>
                <td style="text-align: left; padding: 10px;"><?php echo ucwords($proxy['cds_accounts']); ?></td>
                <td style="text-align: left; padding: 10px;"><?php echo $proxy['total_shares']; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>