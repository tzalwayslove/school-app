/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('chengji', function (success, error) {
    axios.get("/public/tpl/chengji.html").then(function (res) {
        success({
            template: res.data,
            props: ['user'],
            data(){
                return {
                    jiazai:true,
                    chengji:[],
                    jige:[],
                    bujige:[]
                }
            },
            methods:{
                isJige:function(item){
                    return item.jidian > 1;
                }
            },
            mounted: function(){
                $this = this;

                axios.get("/api/chengji?user="+this.user).then(function(res){
                    $this.jiazai = false;
                    if(res.data.result.code == 0){
                        alert(res.data.result.message || '获取失败!');
                    }else{
                        $this.chengji = res.data.chengji;
                        console.log(res.data.chengji);
                        $this.jige =$this.chengji.filter(function(item){
                            return item.jidian > 1;
                        });
                        $this.bujige = $this.chengji.filter(function(item){
                            return item.jidian < 2;
                        });
                    }
                });
            }
        });
    });
});