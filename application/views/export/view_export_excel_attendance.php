
<table border="1" style="width: 60%;">

    <thead>
        <tr>
            <th colspan="7" style="text-align: left; font-size: 20xp;padding: 10px;"><?php echo $year['year_name']; ?> - Vodacom AGM Attendance Report</th>
        </tr>
        <tr>
            <th style="text-align: left;">No.</th>
            <th style="text-align: left;">CDS Acc No</th>
            <th style="text-align: left;">Shareholder Name</th>
            <th style="text-align: left;">Type</th>
            <th style="text-align: left;">Represented By</th>
            <th style="text-align: left;">Phone Number</th>
            <th style="text-align: left;">Total Shares</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($attendance as $i => $att) {
            ?>
            <tr>
                <td style="text-align: left;"><?php echo $i + 1; ?></td>
                <td style="text-align: left;"><?php echo $att['cds_acc_number']; ?></td>
                <td style="text-align: left;"><?php echo $att['cds_acc_fullname']; ?></td>
                <td style="text-align: left;">
                    <?php
                    if ($att['cds_att_type'] == 'SELF') {
                        ?>
                        SELF
                        <?php
                    } elseif ($att['cds_att_type'] == 'REPRESENTED') {
                        ?>
                        REPRESENTED
                        <?php
                    }
                    ?>
                </td>
                <td style="text-align: left;">
                    <?php
                    if ($att['cds_att_type'] == 'REPRESENTED') {
                        echo $att['att_fullname'];
                    }
                    ?>
                </td>
                <td style="text-align: left; mso-number-format:'\@';"><?php echo $att['att_phone_number']; ?></td>
                <td style="text-align: left;"><?php echo $att['cds_acc_shares']; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>