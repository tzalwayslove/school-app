/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('chengji', function (success, error) {
    axios.get("/public/tpl/chengji.html").then(function (res) {
        success({
            template: res.data,
            data(){
                return {

                }
            },
            methods:{

            },
            mounted:function(){
                console.log(this.userId);
            }
        });
    });
});