/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('Kecheng', function (success, error) {
    axios.get("/public/tpl/kecheng.html").then(function (res) {
        success({
            template: res.data,
            props: ['user'],
            data(){
                return {
                    jiazai:true,
                    table:{}
                }
            },
            methods:{

            },
            mounted: function(){
                $this = this;
                axios.get("/api/kecheng?user="+this.user).then(function(res){

                    $this.jiazai = false;
                    if(res.data.result.code == 0){
                        alert(res.data.result.message || '获取失败!');
                    }else{
                        $this.table = res.data.table;

                        console.log($this.table);
                    }
                });
            }
        });
    });
});