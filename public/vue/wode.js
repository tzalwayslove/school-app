/**
 * Created by Administrator on 2017/11/30.
 */

wode = Vue.component('wode', function (resolve, reject) {
    axios.get("/public/tpl/wode.html").then(function (res) {
        resolve({
            data:function(){

            },
            template: res.data,
            mounted:function(){
                console.log(vue.user);
            }
        });
    });
});