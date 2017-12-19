/**
 * Created by Administrator on 2017/11/30.
 */

wode = Vue.component('wode', function (resolve, reject) {
    axios.get("/public/tpl/wode.html").then(function (res) {
        resolve({
            data:function(){
                return {
                    userId:null,
                    zan:0,
                    tiezi:0,
                    user:{
                        niming:1,
                        sex:1,
                        avatar:'/public/wx/img/m-touxiang.png'
                    }
                }
            },
            template: res.data,
            mounted:function(){
                this.userId = data.user;
                $this = this;
                axios.get('/api/get/user?user='+this.userId).then(function(res){
                    console.log(res);
                    $this.user = res.data;
                });

            }
        });
    });
});