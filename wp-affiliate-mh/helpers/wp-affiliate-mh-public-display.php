<!DOCTYPE html>
<html>
<head>
  <meta name="robots" content="noindex" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta charset="UTF-8">
	<title>Trang quản lý</title>
  <?php $favicon = AFF_Config::getConfig('favicon'); if($favicon):?>
  <link rel="icon" type="image/x-icon" href="<?php echo $favicon?>">
  <?php endif?>
  <style>
	.lang-header {
		position: relative;
		display: inline-block;
		margin-left: 20px;
	}
	.lang-header .init {
		position: relative;
		z-index: 888;
		background-color: #fff;
		cursor: pointer;
		text-transform: uppercase;
		overflow: hidden;
		padding: 6px 10px;
		width: 73.56px;
		border-radius: 3px;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}
	.lang-header ul {
		position: absolute;
		top: 100%;
		width: 73.56px;
		left: 0;
		background-color: #FFF;
		margin: 0;
		padding: 5px 0;
		box-shadow: rgba(0,0,0,0.15) 0 3px 8px;
		z-index: 99;
		display: none;
		opacity: 0;
		visibility: hidden;
		transition: all .3s;
	}
	.lang-header ul.open {
		display: block;
		opacity: 1;
		visibility: visible;
	}
	.lang-header img {
		box-shadow: rgba(0,0,0,0.15) 0 3px 8px;
		margin: 0;
		vertical-align: middle;
		display: inline-block;
		height: auto;
		margin: 0;
		border-radius: 3px;
		width: 33px;
	}
	.lang-header li span,
	.lang-header .init span {
		display: none;
	}
	.lang-header li {
		text-align: center;
		padding: 5px 0;
	}
	.lang-header .init .icon {
		display: inline-flex;
		align-items: center;
		background-size: 11px;
		background-repeat: no-repeat;
		transition: all .3s;
	}
  </style>
</head>
<?php $user = get_userdata(get_current_user_id()) ?>
<body>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">

<link href="<?php echo AFF_URL ?>/admin/css/animate.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo AFF_URL ?>/admin/css/quasar.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo AFF_URL ?>/admin/css/date2picker.css">
<link rel="stylesheet" href="<?php echo AFF_URL ?>/public/css/spa.css">
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src="<?php echo AFF_URL ?>/admin/js/vue.min.js"></script>
<script src="<?php echo AFF_URL ?>/admin/js/quasar.umd.min.js"></script>
<script src="<?php echo AFF_URL ?>/admin/js/vue.js"></script>
<script src="<?php echo AFF_URL ?>/admin/js/axios.js"></script>
<script src="<?php echo AFF_URL ?>/admin/js/date2picker.js"></script>
<script src="<?php echo AFF_URL ?>/admin/js/moment-with-locales.min.js"></script>
<script src="<?php echo AFF_URL ?>/admin/js/Chart.min.js"></script>
<script src="<?php echo AFF_URL ?>/admin/js/vue-chartjs.min.js"></script>
<style>
  .card-item {
      border: none;
      margin-bottom: 1rem;
      -webkit-box-shadow: 0 4px 24px 0 rgb(34 41 47 / 10%);
      box-shadow: 0 4px 24px 0 rgb(34 41 47 / 10%);
      border-radius: .428rem;
      overflow: hidden;
      padding: 1.5rem;
      /* height:100%; */
  }
  .card-name{
    font-weight: 400;
    font-size: 0.875rem;
    color: rgb(94, 88, 115);
  }
  .card-number{
    line-height: 1.2;
    color: rgb(94, 88, 115);
    font-size: 1.514rem;
    font-weight: 500;
    letter-spacing: 0px;
    margin-top: 5px;
  }
  .d-none{
    display: none;
  }
	.page-seller a.q-item[href="#/cong-tac-vien"],
	.page-seller a.q-item[href="#/banner"],
	.page-seller a.q-item[href="#/cong-cu"] {
		display: none;
	}
</style>
<script>
    window.quasarConfig = {
      brand: { // this will NOT work on IE 11
        primary: '',
        // ... or all other brand colors
      },
      notify: {}, // default set of options for Notify Quasar plugin
      loadingBar: {
        color: 'blue'
      }
      // ..and many more (check Installation card on each Quasar component/directive/plugin)
    }
    // Quasar.colors.setBrand('primary', '')
    window.RV_CONFIGS = {
      plugin_url: '<?php echo AFF_URL ?>',
    	site_url: '<?php echo get_site_url() ?>',
    	ajax_url: '<?php echo admin_url('admin-ajax.php') ?>',
      user_id: '<?php echo isset($user->ID) ? $user->ID : ''?>',
      user_login: '<?php echo isset($user->user_login) ? $user->user_login: ''?>',
      ref_name: '<?php echo AFF_Config::getConfig('ref_name') ?>',
      settings: <?php echo json_encode(AFF_Config::getConfigs()) ?>
    }
</script>

<?php 
$link_courses = '';
if ( in_array( 'seller', $user->roles, true ) ) {
	$link_courses = home_url('wp-admin/edit.php?post_type=lp_course');
}else{
	$link_courses = home_url(get_theme_mod( 'login_url' ));
}
?>
<?php if($link_courses){ ?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$(document).on('click', 'a.q-item.q-link', function(e) {
			var data_href = $(this).attr('href');
			if(data_href.split('/')[1] == 'khoa-hoc'){
				location.href = "<?php echo $link_courses; ?>";
			}
		});							
	});
</script>
<?php } ?>
<?php
	if ( is_plugin_active( 'gtranslate/gtranslate.php' ) ) {
		$menu_id = 'gt-current-language';
		$data = get_option('GTranslate');
		GTranslate::load_defaults($data);
		$lang_array = $data['native_language_names'] ? json_decode(GTranslate::$lang_array_native_json, true) : GTranslate::$lang_array;
		$lang_html = '';
		if(!empty($data['fincl_langs'])){
			$lang_html .= "<div class='init'><div class='lang-main'>Ngôn ngữ</div><span class='icon'><svg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 285 285'><path d='M282 76.5l-14.2-14.3a9 9 0 0 0-13.1 0L142.5 174.4 30.3 62.2a9 9 0 0 0-13.2 0L3 76.5a9 9 0 0 0 0 13.1l133 133a9 9 0 0 0 13.1 0l133-133a9 9 0 0 0 0-13z' style='fill:%23666'/></svg></span></div>";
			$lang_html .= '<ul>';
			foreach($data['fincl_langs'] as $lang) {
				$lang_item = GTranslate::render_single_item(array('lang' => $lang, 'widget_look' => $data['widget_look'], 'label' => $lang_array[$lang]));
				$lang_html .= '<li>'. $lang_item .'</li>';
			}
			$lang_html .= '</ul>';
		}
	}
?>
<div id="q-app" class="d-none page-<?php echo $user->roles[0]; ?>">
	
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          icon="menu"
          aria-label="Menu"
        ></q-btn>
        <template v-if="!$q.platform.is.mobile"> <a :href="configs.site_url" style="text-decoration: none; color:#fff; font-weight: bold;">Quay lại trang chủ</a> </template>
        <template v-if="$q.platform.is.mobile"> {{page_title}} </template>
        <q-space></q-space>
        <div v-if="configs.user_login != ''">Số dư: {{addCommas(user.balance)}}đ</div>
		<div class="lang-header"><?php echo $lang_html; ?></div>
      </q-toolbar>
      
    </q-header>

    <q-drawer
      v-if="configs.user_id && user.aff_active == 1"
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      :width="250"
      content-class="bg-grey-1"
    >
      <q-scroll-area style="height: calc(100% - 150px); margin-top: 150px; ">
        <q-list>
          <template v-for="nav in navs">
            <!-- <q-item v-if="nav.children.length == 0" :to="nav.to" class="text-bold" exact clickable > -->
            <q-item
              v-if="!nav.hasOwnProperty('link')"
              :to="nav.to"
              class="text-bold"
			  @click="nav.to"
              exact
              clickable
              :key="nav.to"
            >
              <q-item-section avatar>
                <q-icon :name="nav.icon" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ nav.label }}</q-item-label>
              </q-item-section>
            </q-item>

            <q-item
              v-else
              class="text-bold"
              exact
              @click="openURL(nav.link)"
              clickable
              :key="nav.link"
            >
              <q-item-section avatar>
                <q-icon :name="nav.icon" />
              </q-item-section>
              <q-item-section>
                <q-item-label>{{ nav.label }}</q-item-label>
              </q-item-section>
            </q-item>

            <!-- <q-expansion-item v-else :content-inset-level="0.2" expand-separator :icon="nav.icon" :label="nav.label">

          <q-item v-for="nav_child in nav.children" clickable :to="nav_child.to">
            <q-item-section avatar>
              <q-icon :name="nav_child.icon" />
            </q-item-section>
            <q-item-section>
              <q-item-label>{{nav_child.label}}</q-item-label>
            </q-item-section>
          </q-item>

     

        </q-expansion-item> -->
          </template>

          <q-item
              class="text-bold"
              exact
              @click="logout"
              clickable
              :key="logout"
            >
              <q-item-section avatar>
                <q-icon name="logout" />
              </q-item-section>
              <q-item-section>
                <q-item-label>Đăng xuất</q-item-label>
              </q-item-section>
            </q-item>

        </q-list>
      </q-scroll-area>
      <q-img
        class="absolute-top"
        src="https://cdn.quasar.dev/img/material.png"
        style="height: 150px"
      >
        <div class="absolute-bottom bg-transparent">
          <q-avatar size="56px" class="q-mb-sm">
            <img
              :src="settings.logo"
            />
          </q-avatar>
          <div> Xin chào <span class="text-weight-bold">{{user.display_name}}</span></div>
          <div>Số dư: <span class="text-weight-bold">{{addCommas(user.balance)}}đ</span></div>
          <div v-if="Object.keys(settings).length">Cấp độ: <span class="text-weight-bold">{{settings.commission_user_levels[user.level].name}}</span></div>
        </div>
      </q-img>
    </q-drawer>

    <q-page-container class="padding-bottom-mb-50">
      <template v-if="$route.path !== '/dang-nhap' && $route.path !== '/dang-ky'">
        <div class="q-pa-md" v-if="user.aff_active === '0'" v-html="settings.noti_not_active"></div>
        <q-btn color="primary" v-if="user.aff_active === '0'"  icon="save" class="q-mb-lg q-ml-md" label="Đăng xuất" @click="logout"/>
      </template>

      <template  name="fade" mode="out-in" v-if="($route.path === '/dang-nhap' || $route.path === '/dang-ky') || user.aff_active === '1'">
        <div class="doc-note doc-note--tip q-ma-md" v-if="Object.keys(settings).length && settings.noti_all != '' && $route.path !== '/dang-nhap' && $route.path !== '/dang-ky'" v-html="settings.noti_all">
        </div>
	    	<router-view></router-view>
      </template>
    </q-page-container>
    <q-tabs
      no-caps
      inline-label
      class="mobile-only bg-primary text-white shadow-2 fixed-bottom"
      v-if="configs.user_login != ''"
    >
      <q-tab
        name="event_available"
        icon="child_care"
        label="Trang chủ"
        @click="openURL(configs.site_url)"
      ></q-tab>
      <q-tab
        name="settings"
        icon="logout"
        label="Đăng xuất"
        @click="logout"
      ></q-tab>
    </q-tabs>
    
  </q-layout>
</div>

  <script type='module'>
  /*
    Example kicking off the UI. Obviously, adapt this to your specific needs.
    Assumes you have a <div id="q-app"></div> in your <body> above
    */
  import indexPage from '<?php echo AFF_URL ?>/public/partials/pages/dashboard.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>';
  import collaboratorPage from '<?php echo AFF_URL ?>/public/partials/pages/dashboard-2.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>';
  import historyPage from '<?php echo AFF_URL ?>/public/partials/pages/history.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>';
  import paymentPage from '<?php echo AFF_URL ?>/public/partials/pages/payment.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>';
  import userPage from '<?php echo AFF_URL ?>/public/partials/pages/user.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>';
  import toolPage from '<?php echo AFF_URL ?>/public/partials/pages/tool.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>';
  import loginPage from '<?php echo AFF_URL ?>/public/partials/pages/login.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>';
  import registerPage from '<?php echo AFF_URL ?>/public/partials/pages/register.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>';
  import profilePage from '<?php echo AFF_URL ?>/public/partials/pages/user-profile.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>';
  import bannerPage from '<?php echo AFF_URL ?>/public/partials/pages/banner.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>';

  import emptyComponent from '<?php echo AFF_URL ?>/admin/partials/components/data-empty.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>';
  import loading from '<?php echo AFF_URL ?>/admin/partials/components/loading.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>';
  import { getConfigs } from "<?php echo AFF_URL ?>/admin/partials/api/config.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>";
  import { getUserProfile, logout } from "<?php echo AFF_URL ?>/public/partials/api/user.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>";
  import { route } from "<?php echo AFF_URL ?>/public/partials/constants/constants.js?ver=<?php echo WP_AFFILIATE_MH_VERSION ?>";
  // import VueEasyLightbox from 'https://unpkg.com/vue-easy-lightbox@next/dist/vue-easy-lightbox.esm.min.js';
  const EventBus = new Vue()
  let router = null
  try{

    router = new VueRouter({
        routes: [
            { path: '/', component: indexPage }, // Root IndexIndex
            { path: '/tai-khoan', component: profilePage }, 
            { path: '/dang-nhap', component: loginPage }, 
            { path: '/dang-ky', component: registerPage }, 
            { path: '/thong-ke-cong-tac-vien', component: collaboratorPage }, 
            { path: '/lich-su', component: historyPage }, 
            { path: '/thanh-toan', component: paymentPage }, 
            { path: '/cong-tac-vien', component: userPage }, 
            { path: '/cong-cu', component: toolPage }, 
            { path: '/banner', component: bannerPage }, 

        ]
    });
  }catch(e){
        
 }
  Vue.prototype.$eventBus = EventBus
  Vue.component('empty-component', emptyComponent)
  Vue.component('loading-component', loading)
  Vue.mixin({
      methods: {
          openURL(url) {
              Quasar.utils.openURL(url)
          },
          copyText(text){
            Quasar.utils.copyToClipboard(text)
            this.NOTIFY('Sao chép thành công')
          },
          redirectURL(url){
            window.location.href = url
          },
          addCommas(nStr) {
              nStr += '';
              let x = nStr.split('.');
              let x1 = x[0];
              let x2 = x.length > 1 ? '.' + x[1] : '';
              let rgx = /(\d+)(\d{3})/;
              while (rgx.test(x1)) {
                  x1 = x1.replace(rgx, '$1' + ',' + '$2');
              }
              return x1 + x2;
          },
          formatDateRange(date) {
              const replaceW = (d) => {
                  return d.split('/').join('-');
              }

              if (date == '')
                  return '';
              if (typeof date == 'object')
                  return {
                      from: replaceW(date.from),
                      to: replaceW(date.to)
                  }
              else
                  return {
                      from: replaceW(date),
                      to: replaceW(date)
                  }
          },
          formatDateMoment(mysqlDate, format = 'DD/MM/YYYY HH:mm') {
              return moment(mysqlDate, "YYYY/MM/DD HH:mm:ss").format(format)
          },
          buildFormData(formData, data, parentKey) {
              if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File)) {
                  Object.keys(data).forEach(key => {
                      this.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
                  });
              } else {
                  const value = data == null ? '' : data;

                  formData.append(parentKey, value);
              }
          },
          jsonToFormData(data) {
              const formData = new FormData();

              this.buildFormData(formData, data);

              return formData;
          },
          NOTIFY(msg, type = true) {
              this.$q.notify({
                  message: msg,
                  progress: true,
                  type: type == true ? 'positive' : 'negative',
                  color: type == true ? 'green' : 'red',
                  position: 'top',
                  timeout: 2000
              })
          },
          PROMPT(text) {
              return new Promise((res, rej) => {
                  this.$q.dialog({
                      title: 'Xác nhận',
                      message: text,
                      prompt: {
                          model: '',
                          type: 'text' // optional
                      },
                      cancel: true,
                      persistent: true
                  }).onOk((data) => {
                      res(data)
                  }).onCancel(() => {
                      res(false)

                  })
              })
          },
          CONFIRM(text) {
              return new Promise((res, rej) => {
                  this.$q.dialog({
                      title: 'Xác nhận',
                      message: text,
                      cancel: true,
                      persistent: true,

                  }).onOk(() => {
                      res(true)
                  }).onCancel(() => {
                      res(false)

                  })
              })
          },

          deepMerge(target, source) {
              Object.entries(source).forEach(([key, value]) => {
                  if (value && typeof value === 'object') {
                      this.deepMerge(target[key] = target[key] || {}, value);
                      return;
                  }
                  target[key] = value;
              });
              return target;
          },
          getConfigs() {
              return new Promise((resolve, reject) => {
                  // if (window.hasOwnProperty('aff_settings'))
                  //     resolve(window.aff_settings)
                  // else {
                  //     getConfigs().then(res => {
                  //         window.aff_settings = res.data.data
                  //         resolve(window.aff_settings)
                  //     })
                  // }
                resolve(window.RV_CONFIGS.settings)

              })
          },
          isNormal(){
            const settings = window.aff_settings ? window.aff_settings : window.RV_CONFIGS.settings
            return settings.hasOwnProperty('version') && settings.version == 'normal' ? true : false
          },
          formatMoney(object, key) {
               let value = object[key].replace(/\D/g, '');
               value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
               object[key] = value;
          },
          
      }
  })


  
  if(router) new Vue({
      router,
      el: '#q-app',
      data: function() {
          return {
              configs: {},
              page_title: 'Affiliate',
              settings: {

              },
              logo: `${window.RV_CONFIGS.plugin_url}/public/images/virus.svg`,
              leftDrawerOpen: false,
              navs: [{
                      label: "Thống kê của bạn",
                      to: "/",
                      icon: "favorite_border",
                      login: false
                  },
                  {
                      label: "Lịch sử số dư",
                      to: "/lich-su",
                      icon: "fingerprint",
                      login: "all"
                      // children: []
                  },
                  {
                      label: "Thanh toán",
                      to: "/thanh-toan",
                      icon: "credit_card",
                      login: false
                  },
                  {
                    label: "Banner CTV",
                    to: "/banner",
                    icon: "photo_library",
                    login: false
                  },
                  {
                    label: "Tài khoản của bạn",
                    to: "/tai-khoan",
                    icon: "person",
                    login: false
                  },
                  {
                      label: "Công cụ hỗ trợ",
                      to: "/cong-cu",
                      icon: "gesture",
                      login: false
                  }],
            user: {
              balance: 0,
              display_name: '',
              aff_active: 0
            },

          }
      },
      methods: {
          setPageTitle(title) {
              this.page_title = title
          },
          async getUserProfile(id = ''){
            const res = await getUserProfile(id)
            const { data } = res.data
            console.log(data);
            if(data)
              this.user = data
          },
          getC(){
              const { RV_CONFIGS } = window
              this.configs = RV_CONFIGS
          },
          getLoggedInfo(){
            this.getC();
            this.getUserProfile()
            this.getConfigs().then(res => {
              this.settings = res
              this.navs = this.isNormal() ? route.normal : route.pro
            })
          },
          async logout(){
              const confirm = await this.CONFIRM('Bạn chắc chắn muốn đăng xuất')
              if(!confirm)
                return 
              await logout()
              window.RV_CONFIGS.user_id = ''
              window.RV_CONFIGS.user_login = ''
              this.configs.user_id = ''
              this.configs.user_login = ''
              this.$router.push('/dang-nhap')
          },
      },
      components: {

      },
      created() {
          document.querySelector('#q-app').classList.remove('d-none')
          
          this.getConfigs().then(res => {
            this.settings = res
            this.navs = this.isNormal() ? route.normal : route.pro
          })
          this.getC();

          if(!this.configs.user_id && this.$route.path != '/dang-nhap' && this.$route.path != '/dang-ky'){
            this.$router.push('/dang-nhap')
          }
          
          if(this.$route.path == '/dang-nhap' && this.configs.user_id)
            this.$router.push('/')

          if(this.configs.user_id)
            this.getLoggedInfo()
          
          EventBus.$on('set.page_title', this.setPageTitle);
          EventBus.$on('user.refresh', this.getUserProfile);
          EventBus.$on('user.login', this.getLoggedInfo);

      }
      // 
  });
    

</script>
<?php

	if ( is_plugin_active( 'gtranslate/gtranslate.php' ) ) {
		$menu_id = 'gt-current-language';
		$data = get_option('GTranslate');
		GTranslate::load_defaults($data);

		$gt_settings = GTranslate::load_settings($data);
		$unique_id = wp_rand(10000000, 88888888);

		// remove excess settings based on widget_look to keep front-end code small
		$old_settings = $gt_settings;
		$gt_settings = array();
		$keep_keys = array('default_language', 'languages', 'url_structure', 'native_language_names', 'detect_browser_language', 'flag_style', 'flag_size', 'alt_flags', 'custom_domains', 'custom_css');
		foreach($keep_keys as $key)
			if(isset($old_settings[$key]) and $old_settings[$key] !== '')
				$gt_settings[$key] = $old_settings[$key];

		$base_path = get_site_url(). '/wp-content/plugins/gtranslate';		
		$gt_settings['flags_location'] = wp_make_link_relative($base_path) . '/flags/';
		?>
		<script src="<?php echo $base_path; ?>/js/base.js" data-no-optimize="1" data-no-minify="1" data-gt-orig-url="/cong-tac-vien" data-gt-orig-domain="<?php echo $_SERVER['SERVER_NAME']; ?>" data-gt-widget-id="<?php echo $unique_id; ?>" defer></script>
		<script id="gt_widget_script_<?php echo $unique_id; ?>-js-before">
			window.gtranslateSettings = /* document.write */ window.gtranslateSettings || {};window.gtranslateSettings['<?php echo $unique_id; ?>'] = <?php echo json_encode($gt_settings); ?>;
		</script>
		<?php
	}
?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		var lang_cr = $('.glink.gt-current-lang').html();
		$(".lang-header").find('.lang-main').html(lang_cr);
		$(".lang-header").on("click", ".init", function() {
			$(this).parents(".lang-header").find('ul').addClass('open');
		});
		var allOptions = $(".lang-header ul").children('li');
		$(".lang-header ul").on("click", "li", function() {
			allOptions.removeClass('selected');
			$(this).addClass('selected');
			$(".lang-header").find('.lang-main').html($(this).html());
			$(this).parents(".lang-header").find('ul').removeClass('open');
		});						
	});
</script>
</body>
</html>