<?php
$VRCalendarSettings = VRCalendarSettings::getInstance();
$auto_sync = array(
    'none'=>__('Disable', VRCALENDAR_PLUGIN_TEXT_DOMAIN),
    'hourly'=>__('Hourly', VRCALENDAR_PLUGIN_TEXT_DOMAIN),
    'twicedaily'=>__('Twice Daily', VRCALENDAR_PLUGIN_TEXT_DOMAIN),
    'daily'=>__('Daily', VRCALENDAR_PLUGIN_TEXT_DOMAIN)
);
$attribution = array(
    'yes'=>__('Yes', VRCALENDAR_PLUGIN_TEXT_DOMAIN),
    'no'=>__('No', VRCALENDAR_PLUGIN_TEXT_DOMAIN)
);
?>
<div class="wrap">
    <h2>Settings</h2>
    <div class="tabs-wrapper">
        <h2 class="nav-tab-wrapper">
            <a class='nav-tab nav-tab-active' href='#general-options'><?php _e('General', VRCALENDAR_PLUGIN_TEXT_DOMAIN); ?></a>
        </h2>
        <div class="tabs-content-wrapper">
            <form method="post" action="" >
                <div id="general-options" class="tab-content tab-content-active">
                    <?php require(VRCALENDAR_PLUGIN_DIR.'/Admin/Views/Part/Settings/General.php'); ?>
                </div>
                <div>
                    <input type="hidden" name="vrc_cmd" id="vrc_cmd" value="VRCalendarAdmin:saveSettings" />
                    <input type="submit" value="<?php _e('Save', VRCALENDAR_PLUGIN_TEXT_DOMAIN); ?>" class="button button-primary">
                </div>
            </form>
        </div>
    </div>
</div>