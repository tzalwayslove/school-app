/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('liushui', function (success, error) {
    axios.get("/public/tpl/liushui.html").then(function (res) {
        success({
            template: res.data,
            props: ['user', 'user_name', 'account'],
            data(){
                return {
                    jiazai:true,
                    liushui:[],
                    queryList:[],
                    nextPage:false,
                    page: 1,
                    selected:"now",
                    price:''
                }
            },
            computed: {

            },
            methods:{
                next: function(){
                    this.page++;
                    this.getData(1);
                },
                changeData:function(){
                    this.page = 1;
                    this.getData(0)
                },

                getData:function(cover){
                    $this =this;
                    this.jiazai = true;
                    ago = new Date();
                    timestamp = ago.getTime() / 1000;
                    timestamp  = timestamp - 60 * 60 * 24 * 3; //3天
                    ago.setTime(timestamp * 1000);
                    now = new Date();
                    agoMonth = ago.getMonth()+ 1;
                    nowMounth = now.getMonth() +1 ;

                    start_time = "" + ago.getFullYear() + agoMonth +ago.getDate();
                    end_time = "" + now.getFullYear() + nowMounth +now.getDate();

                    $.each(this.queryList, function(key, value){
                        if(key == $this.selected){
                            start_time = value.start_time;
                            end_time = value.end_time
                        }
                    });

                    axios.post('wx/yikatong/liushui?user=' + this.user, {
                        start_time:start_time,
                        end_time:end_time,
                        page:this.page
                    }).then(function(res){
                        $this.jiazai = false;
                        if(res.data.result.code == -2){
                            //重新登录
                            alert('您的登录凭证已过期，请重新登录一卡通');
                            window.location='/wx/yikatong/reLogin?user='+$this.user;
                        }else if(res.data.result.code == 1){
                            $this.price = res.data.price;
                            if(cover == 0){
                                $this.liushui = res.data.liushui.data;
                            }else{
                                $this.liushui = $this.liushui.concat(res.data.liushui.data)
                            }
                            $this.nextPage = res.data.liushui.nextPage
                        }
                    });
                }
            },


            mounted: function(){
                this.jiazai = true;
                $this = this;
                axios.get('/wx/yikatong/queryList?user=' + this.user).then(function(res){
                    $this.queryList =res.data;
                });
                this.getData(0);
            }
        });
    });
});