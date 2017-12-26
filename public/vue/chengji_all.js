/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('Chengjiall', function (success, error) {
    axios.get("/public/tpl/chengji_all.html").then(function (res) {
        success({

            template: res.data,
            props: ['user', 'user_name', 'account'],

            data(){
                return {
                    jiazai:true,
                    chengji:[],
                    page:'all',
                    error:{
                            color:'red'
                     }

                }
            },

            computed: {
                GPA: function () {
                    xuefenjidian = 0;
                    xuefen = 0;
                    chengji = [];
                    for (i = 0, len = this.chengji.length; i < len; ++i) {
                        this.chengji[i].xuefen = Number(this.chengji[i].xuefen);
                        this.chengji[i].jidian = Number(this.chengji[i].jidian);
                        xuefenjidian += this.chengji[i].xuefen * this.chengji[i].jidian;

                        if(!this.inArray(chengji , this.chengji[i].kechengbianhao)){
                            chengji.push(this.chengji[i].kechengbianhao);
                            xuefen += this.chengji[i].xuefen;
                            console.log(this.chengji[i].xuefen);
                        }
                    }

                    return xuefen > 0
                        ? (xuefenjidian / xuefen).toFixed(2)
                        : 0;
                }
            },
            methods:{
                changePage: function(){
                    if(this.page == 'newest'){
                        window.location.href= '/wx/chengji?user='+this.user
                    }
                },
                inArray: function(arr, item){
                    for (var i = 0, len = arr.length; i < len; ++i) {
                        if(item == arr[i]){
                            return true;
                        }
                    }
                    return false;
                },
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