/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('liushui', function (success, error) {
    axios.get("/public/tpl/liushui.html").then(function (res) {
        success({
            template: res.data,
            props: ['user'],
            data(){
                return {
                    jiazai:true,
                    liushui:[],
                    queryList:[],
                    nextPage:false,
                    page: 1,
                    selected:"threeDaysAgo"
                }
            },
            computed: {

            },
            methods:{
                next: function(){
                    ++this.page;
                    this.getData(0);
                },
                changeData:function(){
                    this.page = 1;
                    console.log(this.selected);
                    this.getData()
                },
                getData:function(cover = 1){
                    $this =this;
                    this.jiazai = true;

                    start_time = "19991130";
                    end_time = "20171222";

                    $.each(this.queryList, function(key, value){
                        console.log('value');
                        console.log(value);

                        console.log('key');
                        console.log(key);
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
                            if(cover == 1){
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
                    $this.jiazai = false;
                    $this.queryList =res.data;
                });
                this.getData(1);
            }
        });
    });
});