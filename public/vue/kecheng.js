/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('Kecheng', function (success, error) {
    axios.get("/public/tpl/kecheng.html").then(function (res) {
        success({
            template: res.data,
            props: ['user', 'all', 'user_name', 'xuehao', 'day'],
            data(){
                return {
                    jiazai:true,
                    table:{},
                    desc: '',
                    page: 'all',
                }
            },
            methods:{
                getData: function(all){
                    $this = this;
                    this.jiazai = true;
                    this.page = all == 1
                        ? 'all'
                        : 'now';
                    axios.get("/api/kecheng?user="+this.user + '&all='+ all).then(function(res){
                        $this.jiazai = false;
                        if(res.data.result.code == 0){
                            alert(res.data.result.message || '获取失败!');
                        }else{
                            $this.table = res.data.data.table;
                            $this.desc = res.data.data.desc;
                        }
                    });
                },
                changePage:function(){
                    if(this.page == 'all'){
                        this.getData(1);
                    }else{
                        this.getData(0);
                    }
                }
            },
            mounted: function(){
                this.getData(1);
            }
        });
    });
});