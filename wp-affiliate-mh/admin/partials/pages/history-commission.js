

const template = `
<div class="q-mt-lg">
<loading-component v-if="isLoading"/>
<empty-component v-else-if="records.length == 0 && isLoading == false" />
<template v-else>

            
            <div class="row q-col-gutter-md q-mb-md">
              <div class="col-6 flex" style="align-items:center">
                <q-btn color="primary" label="Lịch sử số dư" to="/history"/>
                <q-btn color="primary" label="Lịch sử hoa hồng" to="/history-commission/" class="q-ml-sm" />
              </div>
            <div class="col-2">
                    <q-input filled v-model="filters.search" label="Nhập ID đơn hàng, hoặc tài khoản" dense debounce="500"/>
            </div>
            
            <div class="col-3">
                <div class="mx-height-40">
                    <date-picker v-model="filters.date_range" type="date" range placeholder="Chọn theo ngày" confirm format="DD-MM-YYYY" valueType="YYYY-MM-DD" :lang="lang"></date-picker>

                </div>
            </div>
            <div class="col-1">
                <q-btn color="primary" label="Lọc" style="width: 100%" @click="getData"/>
            </div>
            </div>
            <div class="row q-col-gutter-md">
                <div class="dash-item col-12">
                    <div class="card-item ">
                        <q-markup-table separator="horizontal" wrap-cells flat>
                            <thead>
                                <tr>
                                    <th class="text-left">Đơn hàng</th>
                                    <th class="text-left">Tổng đơn</th>
                                    <th class="text-left">Hoa hồng</th>
                                    <th class="text-left">Tài khoản</th>
                                    <th class="text-left">Trạng thái đơn</th>
                                    <th class="text-left">Mô tả</th>
                                    <th class="text-left">Ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(record, i) in records" :key="record.id">
                                    <td class="text-left"><a :href="confis.site_url + '/wp-admin/post.php?post='+record.order_id+'&action=edit'" target="_blank">{{record.order_id}}</a></td>
                                    <td class="text-left">{{addCommas(record.total)}}</td>
                                    <td class="text-left">{{addCommas(record.commission)}}</td>
                                    <td class="text-left">{{record.user_login}}</td>
                                    <td class="text-left"><q-badge v-if="record.order_status" :color="ORDER_STATUS_COLOR[record.order_status]">{{
                                        ORDER_STATUS[record.order_status] }}</q-badge>
                                    </td> </td>
                                    <td class="text-left">{{ record.description }}</td>
                                    <td class="text-left">{{formatDateMoment(record.date)}}</td>
                                  
                                </tr>
                        
                            </tbody>
                        </q-markup-table>

                        <div class="flex flex-center q-mt-lg">
                        
                            <q-pagination v-model="pagination.page" :max="pagination.max" :max-pages="6"  direction-links boundary-links :disabled="isLoading"></q-pagination>
                        
                            | Tổng {{pagination.total}} | Số bản ghi trên trang
                            <q-btn-dropdown color="primary" :label="pagination.per_page" class="q-ml-xs">
                                <q-list>
                        
                                    <q-item clickable v-close-popup>
                                        <q-item-section @click="pagination.per_page = 10">
                                            <q-item-label>10</q-item-label>
                                        </q-item-section>
                                    </q-item>
                        
                                    <q-item clickable v-close-popup>
                                        <q-item-section @click="pagination.per_page = 20">
                                            <q-item-label>20</q-item-label>
                                        </q-item-section>
                                    </q-item>
                        
                                    <q-item clickable v-close-popup>
                                        <q-item-section @click="pagination.per_page = 50">
                                            <q-item-label>50</q-item-label>
                                        </q-item-section>
                                    </q-item>
                        
                                    <q-item clickable v-close-popup>
                                        <q-item-section @click="pagination.per_page = 100">
                                            <q-item-label>100</q-item-label>
                                        </q-item-section>
                                    </q-item>
                                    <q-item clickable v-close-popup>
                                        <q-item-section @click="pagination.per_page = 1000">
                                            <q-item-label>1000</q-item-label>
                                        </q-item-section>
                                    </q-item>
                        
                                </q-list>
                            </q-btn-dropdown>
                        </div>

                    </div>
                </div>
                
            </div>
            

         


            
            
        </template>
</div>
`;

import { getUserOrderHistory } from "../api/history.js"
import { LANG_DATE_PICKER, ORDER_STATUS, ORDER_STATUS_COLOR } from "../constants/constants.js"
const { RV_CONFIGS } = window 
export default {
    data: () => ({
        confis: RV_CONFIGS,
        isLoading: false,
        filters: {
            date_range: [],
            search: ''
        },
        lang: LANG_DATE_PICKER,
        ORDER_STATUS,
        ORDER_STATUS_COLOR,
        records: [],
        pagination: {
            page: 1,
            max: 1,
            per_page: 10,
            total: 0,
        },
      
    }),
   
    methods: {
        async getData(){
            this.$q.loading.show()
            const res = await getUserOrderHistory({filters: this.filters, page: this.pagination.page, per_page: this.pagination.per_page})
            const {data, pagination} = res.data
            if(data)
                this.records = data
            this.pagination.total = pagination.total
            this.pagination.max = pagination.max_page
            this.$q.loading.hide()
          
        }
	},
	components:{
	},
    watch:{
        
        'pagination.page': function(){
          this.getData()
        },
        'filters.search': function(){
            this.pagination.page = 1
            this.getData()
        },
        'pagination.per_page': function(){
         this.pagination.page = 1
         this.getData()
        },
      
    },
    template: template,
    created(){
        this.getData();
        this.$eventBus.$emit('set.page_title', 'Lịch sử hoa hồng');
    }

}