/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('kaochang', function (success, error) {
    axios.get("/public/tpl/kaochang.html").then(function (res) {
        success({
            template: res.data,
            props: ['user', 'user_name', 'account'],
            data(){
                return {
                    jiazai:true,
                    kaochang:{},
                    itemStyleFinish : {
                        'float': 'right',
                        'margin-right': '6px',
                        'color': '#8f8f94'
                    },
                    itemStyleFinishh : {
                        'position':'absolute',
                        'right':'10px',
                        'color': '#FFFFFF',
                        'top':0
                    },
                    itemStyleUnFinish : {
                        'float': 'right',
                        'margin-right': '6px',
                        'color': '#FFFFFF'
                    },
                    zuowei:{
                        float:'right',
                        'margin-right':'6px',
                        color:'#8f8f94'
                    }
                }
            },
            methods:{

            },
            mounted: function(){
                $this = this;

                axios.get("/api/kaochang?user="+this.user).then(function(res){
                    $this.jiazai = false;
                    if(res.data.result.code == 0){
                        alert(res.data.result.message || '获取失败!');
                    } else {
                        $this.kaochang = res.data.kaochang;
                    }

                });

            }
        });
    });
});