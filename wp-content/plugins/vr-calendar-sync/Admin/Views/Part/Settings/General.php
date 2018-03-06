<table class="form-table">
    <tbody>
    <tr valign="top">
        <th>
            <?php _e('Auto Sync', VRCALENDAR_PLUGIN_TEXT_DOMAIN); ?>
        </th>
        <td>
            <select id="auto_sync" name="auto_sync" class="large-text">
                <?php foreach($auto_sync as $val=>$text):
                    $selected = '';
                    if( $val == $VRCalendarSettings->getSettings('auto_sync', 'daily') )
                        $selected = 'selected="selected"';
                    ?>
                    <option value="<?php echo $val; ?>" <?php echo $selected; ?>><?php echo $text; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
    <tr valign="top">
        <th>
            <?php _e('Show Attribution Link Below Calendar?', VRCALENDAR_PLUGIN_TEXT_DOMAIN); ?>
        </th>
        <td>
            <select id="attribution" name="attribution" class="large-text">
                <?php foreach($attribution as $val=>$text):
                    $selected = '';
                    if( $val == $VRCalendarSettings->getSettings('attribution') )
                        $selected = 'selected="selected"';
                    ?>
                <option value="<?php echo $val; ?>" <?php echo $selected; ?>><?php echo $text; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
    </tbody>
</table>