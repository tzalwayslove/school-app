/**
 * Created by Administrator on 2017/11/30.
 */
jubao = Vue.component('jubao', function (success, error) {
    axios.get("/public/tpl/jubao.html").then(function (res) {
        console.log(11111111);
        success({
            template: res.data,
            props: ['articel'],
            data(){
                return {
                    content:''
                }
            },
            methods:{
                back: function(){
                    router.push({
                        path: '/tiezi',
                    })
                },
                send: function(){
                    $this = this;
                    sendData  = {
                        articel : this.$route.params.articel,
                        content:content
                    };
                    axios.post('/wx/jubao?user='+data.user, sendData).then(function(res){
                        res = res.data;
                        if(res.result.code == 1){
                            data.success = true;
                            $this.back();
                        }else{
                            alert(res.result.message);
                        }
                    });
                }
            },

        });
    });
});