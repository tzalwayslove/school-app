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
                    bujige:[],
                    page: 'newest'
                }
            },
            computed: {
                GPA:function(){
                    count = 0;

                    for ( var i = 0, len = this.chengji.length; i < len; ++i ){
                        jidian = this.chengji[i].jidian;
                        count += jidian;
                    }

                    return this.chengji.length > 1
                        ? count / this.chengji.length
                        : 0;
                }
            },
            methods:{
                changePage: function(){
                    if(this.page == 'all'){
                        window.location.href='/wx/chengji_all?user='+this.user
                    }
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
                            return item.chengji >= 60;
                        });
                        $this.bujige = $this.chengji.filter(function(item){
                            return item.chengji < 60;
                        });
                    }
                });
            }
        });
    });
});