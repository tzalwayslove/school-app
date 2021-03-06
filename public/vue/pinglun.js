/**
 * Created by Administrator on 2017/11/30.
 */
pinglun = Vue.component('pinglun', function (success, error) {
    axios.get("/public/tpl/pinglun.html").then(function (res) {
        success({
                template: res.data,
                props: ['articel'],
                data(){
                    return {
                        data : {},
                        list: [],
                        articelData : {
                            _user_account:{
                                avatar:'/public/wx/img/m-touxiang.png',
                                nick_name: '',
                                sex: '1'
                            }
                        },
                        jiahao: true,
                        pinglun_input: false,
                        comment: '',
                        success:false,
                        timeOut:null,

                    }
                },
                methods:{
                    getData:function(){
                        let id =this.$route.params.id;
                        let $this =this;

                        axios.get('wx/comment/?user='+data.user + '&id='+id).then(function(res){
                            $this.articelData = res.data.data;
                            $this.list = res.data.data.get_comment;
                        });
                    },
                    addpinglun(){
                        this.showConvert();
                    },
                    showConvert(){
                        this.jiahao = !this.jiahao;
                        this.pinglun_input = !this.pinglun_input;
                    },
                    showSuccess: function(){
                        // "#toast"
                        if(!this.success){
                            this.success = true;
                            this.timeOut = setTimeout(function(obj){
                                obj.success = false;
                            }, 1000, this);
                        }


                    },
                    send(){
                        niming = confirm('是否匿名?');

                        let articel_id = this.articelData.id;
                        let $this = this;

                        axios.post('wx/addComment', {
                            id: articel_id,
                            content: this.comment,
                            niming:niming,
                            user:data.user
                        }).then(function(res){
                            if(res.data.result.code == 1){
                                $this.getData()
                                $this.comment = '';
                                $this.showSuccess();
                            }else{
                                alert(res.data.result.message || '评论失败');
                            }
                        });
                        this.showConvert();
                    },
                    setZan: function (item) {
                        zan = !!!item.zanLog ? 1 : -1;
                        id = item.id;
                        axios.post('wx/comment_zan', {
                            id: id,
                            zan: zan,
                            user:data.user
                        }).then(function (res) {
                            item.zan = res.data.comment.zan ;
                        });
                        item.zanLog = !!!item.zanLog;
                    },
                    hide_input(){
                        this.jiahao = true;
                        this.pinglun_input = false;
                    },
                    reply(item){
                        console.log('click');
                        console.log(item);

                        id = item.id;
                        niming = item.niming;
                        sex = item._get_user.sex;
                        router.push({
                            path: '/reply/' + id + '/' + niming + '/' + sex + '/'+ item.articel,
                        })
                    },
                },
                mounted: function () {
                   this.getData();
                   data.bar_buttom = false;

                }
            }
        );
    });
});