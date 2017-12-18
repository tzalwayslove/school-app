/**
 * Created by Administrator on 2017/11/30.
 */

wode = Vue.component('wode', function (resolve, reject) {
    axios.get("/public/tpl/wode.html").then(function (res) {
        resolve({
            data:function(){
                return {
                    user:null
                }
            },
            template: res.data,
            mounted:function(){
                this.user = vue.user;
            }
        });
    });
});