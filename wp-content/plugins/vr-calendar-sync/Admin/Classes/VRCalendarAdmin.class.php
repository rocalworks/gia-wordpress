<?php
class VRCalendarAdmin extends VRCSingleton {

    protected function __construct(){

        add_action('init', array($this, 'handleCommands'));
        add_action( 'admin_notices', array( $this,'adminNotice') );

        add_action( 'admin_menu', array($this,'registerAdminPages') );


        add_action( 'admin_enqueue_scripts', array( $this, 'enqueueStyles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueueScripts' ) );
    }
    function adminNotice() {
        $type = 'updated';

        if(isset ($_GET['vrc_msg']) ) {
            $msg = urldecode($_GET['vrc_msg']);
            if(!empty($msg))
            {
                if(isset ($_GET['vrc_msg_type']) ) {
                    $type = $_GET['vrc_msg_type'];
                }
                ?>
                <div class="<?php echo $type; ?>">
                    <p><?php echo $msg; ?></p>
                </div>
            <?php
            }
        }
    }
    function handleCommands() {
        if(isset($_REQUEST['vrc_cmd'])) {
            $cmd = $_REQUEST['vrc_cmd'];
            $cmd = explode(':', $cmd);
            $cmd = array_filter($cmd);
            $callable = false;
            if(count($cmd) == 2) {
                $callable = array($cmd[0], $cmd[1]);
            }
            else {
                $callable = $cmd[0];
            }
            call_user_func($callable);
        }
    }
    function syncCalendar() {
        $msg = 'Something went wrong!';
        $type = 'error';
        if(isset($_GET['cal_id'])) {
            $VRCalendarEntity = VRCalendarEntity::getInstance();
            $VRCalendarEntity->synchronizeCalendar( $_GET['cal_id'] );
            $msg = __('Calendar Synchronized successfully', VRCALENDAR_PLUGIN_TEXT_DOMAIN);
            $type = 'updated';
        }
        $msg = rawurlencode($msg);
        $redirect_url = admin_url("admin.php?page=".VRCALENDAR_PLUGIN_SLUG."-dashboard&vrc_msg={$msg}&vrc_msg_type={$type}");
        wp_redirect($redirect_url);
    }
    function syncAllCalendars() {
        $VRCalendarEntity = VRCalendarEntity::getInstance();

        /* Fetch all calendars */
        $cals = $VRCalendarEntity->getAllCalendar();
        foreach($cals as $cal) {
            $VRCalendarEntity->synchronizeCalendar($cal->calendar_id);
        }
    }
    function deleteCalendar() {
        $VRCalendarEntity = VRCalendarEntity::getInstance();
        $VRCalendarEntity->deleteCalendar( $_GET['cal_id'] );
        $msg = __('Calendar deleted successfully', VRCALENDAR_PLUGIN_TEXT_DOMAIN);
        $msg = rawurlencode($msg);
        $redirect_url = admin_url("admin.php?page=".VRCALENDAR_PLUGIN_SLUG."-dashboard&vrc_msg={$msg}");
        wp_redirect($redirect_url);
    }

    function saveCalendar() {
        $data = $_POST;
        $msg = __('Calendar updated successfully', VRCALENDAR_PLUGIN_TEXT_DOMAIN);
        if($data['calendar_id']<=0) {
            $data['calendar_created_on'] = date('Y-m-d H:i:s');
            $data['calendar_author_id'] = get_current_user_id();
            $msg = 'Calendar created successfully';
        }
        $data['calendar_modified_on'] = date('Y-m-d H:i:s');
        //$data['calendar_links'] = array_filter( $data['calendar_links'] );
        /* remove last element from link entries */
        array_pop($data['calendar_links']['name']);
        array_pop($data['calendar_links']['url']);
        $calendar_links= array();
        /* convert this to required format */
        foreach($data['calendar_links']['name'] as $k=>$v){
            $tmp = array();
            $tmp['name'] = $data['calendar_links']['name'][$k];
            $tmp['url'] = $data['calendar_links']['url'][$k];
            $calendar_links[] = $tmp;
        }
        $data['calendar_links'] = $calendar_links;

        $VRCalendarEntity = VRCalendarEntity::getInstance();
        $VRCalendarEntity->saveCalendar( $data );
        $msg = rawurlencode($msg);
        $redirect_url = admin_url("admin.php?page=".VRCALENDAR_PLUGIN_SLUG."-dashboard&vrc_msg={$msg}");
        wp_redirect($redirect_url);
        exit();
    }

    function saveSettings() {
        $VRCalendarSettings = VRCalendarSettings::getInstance();

        $VRCalendarSettings->setSettings('auto_sync', $_POST['auto_sync']);
        $VRCalendarSettings->setSettings('attribution', $_POST['attribution']);

        /* Updated sync hook */
        wp_clear_scheduled_hook( 'vrc_cal_sync_hook' );
        wp_schedule_event( time(), $VRCalendarSettings->getSettings('auto_sync', 'daily'), 'vrc_cal_sync_hook' );

        $msg = __('Settings saved successfully', VRCALENDAR_PLUGIN_TEXT_DOMAIN);

        $msg = rawurlencode($msg);
        $redirect_url = admin_url("admin.php?page=".VRCALENDAR_PLUGIN_SLUG."-settings&vrc_msg={$msg}");
        wp_redirect($redirect_url);
        exit();
    }

    function registerAdminPages() {
        add_menu_page( VRCALENDAR_PLUGIN_NAME, VRCALENDAR_PLUGIN_NAME, 'manage_options', VRCALENDAR_PLUGIN_SLUG.'-dashboard', array($this,'dashboard') );
        add_submenu_page( VRCALENDAR_PLUGIN_SLUG.'-dashboard', 'Dashboard', 'Dashboard', 'manage_options', VRCALENDAR_PLUGIN_SLUG.'-dashboard', array($this,'dashboard') );
        add_submenu_page( VRCALENDAR_PLUGIN_SLUG.'-dashboard', 'Add Calendar', 'Add Calendar', 'manage_options', VRCALENDAR_PLUGIN_SLUG.'-add-calendar', array($this,'addCalendar') );
        //add_submenu_page( VRCALENDAR_PLUGIN_SLUG.'-dashboard', 'Bookings', 'Bookings', 'manage_options', VRCALENDAR_PLUGIN_SLUG.'-calendar-bookings', array($this,'calendarBookings') );
        add_submenu_page( VRCALENDAR_PLUGIN_SLUG.'-dashboard', 'Settings', 'Settings', 'manage_options', VRCALENDAR_PLUGIN_SLUG.'-settings', array($this,'settings') );
        add_submenu_page( VRCALENDAR_PLUGIN_SLUG.'-dashboard', 'Information', 'Information', 'manage_options', VRCALENDAR_PLUGIN_SLUG.'-information', array($this,'information') );
    }

    function information() {
        require(VRCALENDAR_PLUGIN_DIR.'/Admin/Views/Information.php');
    }

    function settings() {
        require(VRCALENDAR_PLUGIN_DIR.'/Admin/Views/Settings.php');
    }

    function addCalendar() {
        /* check if we have more then one calender in system */
        $VRCalendarEntity = VRCalendarEntity::getInstance();
        if(isset($_GET['cal_id'])) {
            $cal = $VRCalendarEntity->getCalendar($_GET['cal_id']);
            if(!isset($cal->calendar_id)) {
                $msg = __('Invalid calendar!', VRCALENDAR_PLUGIN_TEXT_DOMAIN);
                $msg = rawurlencode($msg);
                $redirect_url = admin_url("admin.php?page=".VRCALENDAR_PLUGIN_SLUG."-dashboard&vrc_msg={$msg}");

                echo '<script>window.location = "'.$redirect_url.'"</script>';
                exit;
            }
        } else {
            $cals = $VRCalendarEntity->getAllCalendar();
            if( count($cals)>=1 ) {
                $msg = __('Only one calendar is allowed in free version<br/>Upgrade to the <strong>PRO</strong> or <strong>ENTERPRISE</strong> version to add more calendars', VRCALENDAR_PLUGIN_TEXT_DOMAIN);
                $msg = rawurlencode($msg);
                $redirect_url = admin_url("admin.php?page=".VRCALENDAR_PLUGIN_SLUG."-dashboard&vrc_msg={$msg}");

                echo '<script>window.location = "'.$redirect_url.'"</script>';
                exit;
            }
        }

        require(VRCALENDAR_PLUGIN_DIR.'/Admin/Views/AddCalendar.php');
    }

    function dashboard() {
        $view = 'Dashboard';
        if(isset($_GET['view']))
            $view = ucfirst($_GET['view']);

        require(VRCALENDAR_PLUGIN_DIR.'/Admin/Views/'.$view.'.php');
    }

    /**
     * Register and enqueue admin-facing style sheet.
     *
     * @since    1.0.0
     */
    public function enqueueStyles()
    {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
        wp_enqueue_style( VRCALENDAR_PLUGIN_SLUG . '-plugin-styles', VRCALENDAR_PLUGIN_URL.'/assets/css/admin.css', array(), VRCalendar::VERSION );
    }

    /**
     * Register and enqueues admin-facing JavaScript files.
     *
     * @since    1.0.0
     */
    public function enqueueScripts()
    {
        wp_enqueue_script( 'wp-color-picker');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script( VRCALENDAR_PLUGIN_SLUG . '-plugin-script', VRCALENDAR_PLUGIN_URL.'/assets/js/admin.js', array( 'jquery' ), VRCalendar::VERSION );
    }

}