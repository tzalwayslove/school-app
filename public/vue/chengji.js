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
            computed: {
                GPA:function(){
                    count = 0;
                    console.log(this.chengji.length);
                    if(count / this.chengji.length > 0){
                        for ( i=0, count = this.chengji.length; i<count; ++i){
                            count += this.chengji[i].jidian
                        }
                        console.log(count);
                        console.log(this.chengji.length);

                        return count / this.chengji.length;
                    }else{
                        return 0;
                    }
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