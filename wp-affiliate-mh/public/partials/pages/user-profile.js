

const template = `
<div class="q-pa-md" v-if="!isLoading">
    <div class="row">
        <div class="col-md-6 col-xs-12 text-center card-item">
            <transition appear enter-active-class="animated zoomIn" :duration="1000">
                <div class="flex justify-center">
                    <!-- <img src="~assets/vbimex.jpg" width="150px" style="position:relative; left:-15px"> -->
                </div>
            </transition>
            <p class="text-h6 q-mb-md">THÔNG TIN TÀI KHOẢN</p>
            <q-form @submit="onSubmit" class="q-gutter-sm">

                <q-chip :color="LEVEL_COLOR[user.level]" icon="stars" text-color="white">{{settings.commission_user_levels?.[user.level].name}}</q-chip>
                <q-chip color="orange" text-color="white" icon="attach_money">Số dư: {{addCommas(user.balance)}} đ</q-chip>
                <q-chip color="purple" text-color="white" icon="shopping_cart">Doanh số: {{addCommas(user.income)}} đ</q-chip>
                <q-input disable filled type="text" v-model="user.user_login" label="Tên đăng nhập *" lazy-rules
                    :rules="[val => (val && val.length > 0) || 'Điền tên tài khoản']" />
        
                <q-input filled type="text" v-model="user.display_name" label="Tên hiển thị" lazy-rules
                    :rules="[val => (val && val.length > 0) || 'Điền tên hiển thị']" />

                
                <q-input filled type="text" v-model="user.user_phone" label="Số điện thoại *" lazy-rules />
        
                <q-input filled type="email" v-model="user.user_email" label="Email *" lazy-rules :rules="[
                                  val => (val && val.length > 0) || 'Điền tên email',
                                  val =>
                                    (val && validateEmail(val)) || 'Định dạng Email không chính xác'
                                ]" />
        
        
        
                <div class="q-gutter-md">
                    <q-btn label="Lưu thông tin" type="submit" color="primary" />
                    <q-btn label="Đổi mật khẩu" color="red" @click="change_pass.show_dialog = true"/>
                   
                </div>
            </q-form>
            <q-dialog v-model="change_pass.show_dialog">
                <q-card style="min-width: 350px;">
                    <q-card-section class="row items-center q-pb-none">
                        <div class="text-h6">Đổi mật khẩu</div>
                        <q-space />
                        <q-btn icon="close" flat round dense v-close-popup />
                    </q-card-section>
            
                    <q-card-section class="q-gutter-md">
                            <q-input filled type="password" v-model="change_pass.old_password" label="Mật khẩu cũ *"/>
                            <q-input filled type="password" v-model="change_pass.new_password" label="Đổi mật khẩu mới *"/>
                            <q-input filled type="password" v-model="change_pass.renew_password" label="Nhập lại mật khẩu *"  />

                            <q-btn label="Đổi mật khẩu" color="primary" @click="changePass"/>

                    </q-card-section>
                    </q-card>
            </q-dialog>
        </div>
		<div class="col-md-6 col-xs-12 text-center card-item">
			<p class="text-h6 q-mb-md">Cấp độ chiết khấu</p>
			<div class="level-ck">
				<div class="row q-col-gutter-sm q-mb-sm" v-for="(level, i) in settings.commission_user_levels" >
					<template v-if="(i + 1) <= settings.user_level">
						<div class="col-4">
							<q-input filled v-model="level.name" label="Tên cấp độ"  stack-label readonly="readonly" />
						</div>
						<div class="col-4">
							<q-input filled v-model="level.income" label="Doanh thu"  stack-label readonly="readonly" />
						</div>
						<div class="col-4">
							<q-input filled v-model="level.commission" label="Chiết khấu %" stack-label readonly="readonly" />
						</div>
					</template>
				</div>
			</div>
        </div>
    </div>
</div>
`;
import { updateUserProfile, getUserProfile, changePassword, getConfigs } from '../api/user.js'
import {  LEVEL_COLOR, validateEmail, validatePhone } from "../constants/constants.js"
const { RV_CONFIGS } = window 
export default {
    data: () => ({
        configs: RV_CONFIGS,
        isLoading: true,
        settings: {
		  commission_user_levels: [],
		  aff_reset_level_month: false,
		  user_level: 4,
		},
        validateEmail,
        validatePhone,
        user: {
            user_login: "",
            display_name: "",
            user_phone: "",
            user_email: "",
            password: "",
            password_confirmation: "",
            ref: '',
            balance: 0,
            income: 0,
            data_json: ''
        },
        LEVEL_COLOR,
        change_pass: {
            show_dialog: false,
            old_password: '',
            new_password: '',
            renew_password: '',
        },

    }),
   
    methods: {
        onSubmit() {
            this.$q.loading.show()
            updateUserProfile(this.user).then(res => {
                const { success, msg } = res.data
                this.NOTIFY(msg, success)
                this.$q.loading.hide()
            })
        },
        async getData(){
            this.$q.loading.show()
            const res = await getUserProfile(this.configs.user_id)
            const {data} = res.data
            this.user = data
            this.$q.loading.hide()
            this.isLoading = false
        },
        async changePass(){
            const {old_password, new_password, renew_password} = this.change_pass
            if(old_password == '' || new_password == '' || renew_password == '')
                return this.NOTIFY('Yêu cầu điền đầy đủ thông tin mật khẩu', false)

            this.$q.loading.show()
            const res = await changePassword({...this.change_pass})
            const { success, msg } = res.data
            this.NOTIFY(msg, success)

            console.log(res)
            this.$q.loading.hide()
        }
	},
	components:{
       
	},
    watch:{

    },
    template: template,
    created(){
        this.getConfigs().then(res => {
            this.settings = res
        })
        this.getData();
        this.$eventBus.$emit('set.page_title', 'Thông tin tài khoản');
    }
}