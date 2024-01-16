const template = `
    <div>
        <div class="flex justify-between">
            <p>Thông tin đơn hàng</p>
        </div>
        <q-markup-table separator="horizontal" wrap-cells flat class="max-height-sc scroll-view-sc primary-bar">
            <thead>
                <tr>
                    <th class="text-left" width="50px">ID</th>
                    <th class="text-left">Cộng tác viên</th>
                    <th class="text-left">Giá trị</th>
                    <th class="text-left">Hoa hồng</th>
                    <th class="text-left">Trạng thái</th>
                    <th class="text-left">Thời gian</th>
                    <th class="text-left">#</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(record, i) in orders" :key="record.ID">
                    <td class="text-left"><a :href="RV_CONFIGS.site_url + '/wp-admin/post.php?post=' + record.order_id + '&action=edit'" target="_blank">{{ record.order_id }}</a></td>
                    <td class="text-left">{{ record.user_login }}</td>
                    <td class="text-left">{{ addCommas(record.total) }}</td>
                    <td class="text-left">{{ addCommas(record.commission) }}</td>
                    <td class="text-left">
                        <q-badge v-if="record.order_status" :color="ORDER_STATUS_COLOR[record.order_status]">{{ ORDER_STATUS[record.order_status] }}</q-badge>
                    </td>
                    <td class="text-left">{{formatDateMoment(record.date)}}</td>
                    <td class="text-left">
                        <q-btn round color="primary" icon="visibility" size="sm" class="q-mr-xs" @click="viewOrder(record, i)"/>
                    </td>
                </tr>
        
            </tbody>
        </q-markup-table>
        <viewOrderDialog :view_order="view_order" v-if="view_order.showDialog"/>
    </div>
          
`;
import viewOrderDialog from "../../components/dashboard/view-order-dialog.js"
import { ORDER_STATUS, ORDER_STATUS_COLOR } from "../../constants/constants.js"
const { RV_CONFIGS } = window
export default {
    props: ['orders'],
    data: () => ({
        settings: {},
        ORDER_STATUS,
        ORDER_STATUS_COLOR,
        RV_CONFIGS,
        view_order: {
            showDialog: false,
            order: null
        }
    }),
    methods: {
        viewOrder(order, index){
            if(!order.order_json)
                return;
                
            this.view_order.order = order
            this.view_order.index = index
            this.view_order.showDialog = true
        },
    },
    computed: {
        
    },
    components:{
        viewOrderDialog
    },
    template: template,
    created(){
        
    },
    watch: {
        
    },


}