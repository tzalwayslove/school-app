/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('Chengjiall', function (success, error) {
    axios.get("/public/tpl/chengji_all.html").then(function (res) {
        success({
            template: res.data,
            props: ['user'],
            data(){
                return {
                    jiazai:true,
                    chengji:[],
                    page:'all'
                }
            },
            computed: {
                GPA: function () {
                    count = 0;

                    for( i=0, len = this.chengji.length; i< len; ++i){
                        count += this.chengji[i].jidian;
                    }

                    return this.chengji.length > 1
                        ? count / this.chengji.length
                        : 0;
                }
            },
            methods:{
                changePage: function(){
                    if(this.page == 'newest'){
                        window.location.href= '/wx/chengji?user='+this.user
                    }
                }
            },
            mounted: function(){
                console.log('加载完成');
                $this = this;
                axios.get("/api/chengji_all?user="+this.user).then(function(res){
                    $this.jiazai = false;
                    if(res.data.result.code == 0){
                        alert(res.data.result.message || '获取失败!');
                    }else{
                        $this.chengji = res.data.chengji;
                    }
                });
            }
        });
    });
});