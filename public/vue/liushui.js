/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('liushui', function (success, error) {
    axios.get("/public/tpl/liushui.html").then(function (res) {
        success({
            template: res.data,
            props: ['user'],
            data(){
                return {
                    jiazai:true,
                    liushui:[],
                }
            },
            computed: {

            },
            methods:{

            },

            mounted: function(){

            }
        });
    });
});